<?php

namespace YoanBernabeu\DaplosBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
use YoanBernabeu\DaplosBundle\Client\DaplosApiClientInterface;
use YoanBernabeu\DaplosBundle\Contract\DaplosEntityInterface;
use YoanBernabeu\DaplosBundle\Exception\DaplosApiException;

/**
 * Service de synchronisation des référentiels DAPLOS avec les entités Doctrine.
 */
class ReferentialSyncService implements ReferentialSyncServiceInterface
{
    private const BATCH_SIZE = 100;

    public function __construct(
        private readonly DaplosApiClientInterface $apiClient,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * Synchronise un référentiel DAPLOS avec une entité Doctrine.
     *
     * @param string        $entityClass   Nom complet de la classe de l'entité (ex: App\Entity\Culture)
     * @param int           $referentialId ID du référentiel DAPLOS
     * @param callable|null $mapper        Fonction de mapping personnalisée (optionnel)
     *
     * @return array{created: int, updated: int, total: int}
     *
     * @throws DaplosApiException
     */
    public function syncReferential(
        string $entityClass,
        int $referentialId,
        ?callable $mapper = null
    ): array {
        $data = $this->apiClient->getReferential($referentialId);
        
        // Vérifier si le référentiel contient des données valides
        if (!isset($data['references']) || !is_array($data['references'])) {
            $receivedKeys = array_keys($data);
            $sample = json_encode(array_slice($data, 0, 3));
            throw new DaplosApiException(
                sprintf(
                    'Structure de données invalide pour le référentiel %d. Clés attendues : [referential, references]. Clés reçues : [%s]. Échantillon des données : %s',
                    $referentialId,
                    implode(', ', $receivedKeys),
                    $sample
                )
            );
        }
        
        $references = $data['references'];

        $stats = ['created' => 0, 'updated' => 0, 'total' => count($references)];

        $this->entityManager->beginTransaction();

        try {
            $i = 0;

            foreach ($references as $reference) {
                $daplosId = $reference['id'] ?? null;
                if (!$daplosId) {
                    continue;
                }

                // Rechercher si l'entité existe déjà
                // Important : on récupère le repository à chaque fois car clear() peut le détacher
                $entity = $this->findEntityByDaplosId($entityClass, $daplosId);

                $isNew = false;
                if (!$entity) {
                    $entity = new $entityClass();
                    $isNew = true;
                }

                // Utiliser le mapper personnalisé si fourni
                if ($mapper) {
                    $entity = $mapper($entity, $reference);
                } else {
                    // Mapping par défaut
                    $this->mapDefaultFields($entity, $reference);
                }

                $this->entityManager->persist($entity);

                if ($isNew) {
                    ++$stats['created'];
                } else {
                    ++$stats['updated'];
                }

                // Batch processing : flush périodique pour éviter les problèmes de mémoire
                ++$i;
                if (0 === $i % self::BATCH_SIZE) {
                    $this->entityManager->flush();
                    $this->entityManager->clear();
                }
            }

            // Flush final des entités restantes
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();

            throw new DaplosApiException(sprintf('Erreur lors de la synchronisation du référentiel %d : %s', $referentialId, $e->getMessage()), 0, $e);
        }

        return $stats;
    }

    /**
     * Mapping par défaut des champs du référentiel vers l'entité.
     *
     * Si l'entité implémente DaplosEntityInterface, utilise les méthodes de l'interface.
     * Sinon, tente de trouver les setters appropriés en utilisant la reflection.
     *
     * @param array<string, mixed> $reference
     */
    private function mapDefaultFields(object $entity, array $reference): void
    {
        $daplosId = $reference['id'] ?? null;
        $title = $reference['title'] ?? null;
        $referenceCode = $reference['reference_code'] ?? null;

        // Si l'entité implémente l'interface, c'est simple
        if ($entity instanceof DaplosEntityInterface) {
            $entity
                ->setDaplosId($daplosId)
                ->setDaplosTitle($title)
                ->setDaplosReferenceCode($referenceCode);

            return;
        }

        // Sinon, chercher les setters via reflection
        $reflection = new \ReflectionClass($entity);

        // Chercher la propriété avec l'attribut #[DaplosId] pour déterminer le préfixe
        $prefix = $this->findPropertyPrefix($reflection);

        if (null === $prefix) {
            // Fallback : impossible de déterminer le préfixe
            return;
        }

        // Mapper les champs avec le préfixe trouvé
        $mappings = [
            'Id' => $daplosId,
            'Title' => $title,
            'ReferenceCode' => $referenceCode,
        ];

        foreach ($mappings as $suffix => $value) {
            if (null === $value) {
                continue;
            }

            $setterName = 'set'.ucfirst($prefix).$suffix;

            if (!$reflection->hasMethod($setterName)) {
                continue;
            }

            $method = $reflection->getMethod($setterName);

            // Vérifier que la méthode est publique et prend exactement 1 paramètre
            if (!$method->isPublic() || 1 !== $method->getNumberOfParameters()) {
                continue;
            }

            $params = $method->getParameters();
            $expectedType = $params[0]->getType();

            // Vérifier la compatibilité des types
            if ($expectedType && !$this->isTypeCompatible($value, $expectedType)) {
                continue;
            }
            
            // Tronquer les chaînes trop longues pour éviter les erreurs SQL
            $truncatedValue = $this->truncateValueIfNeeded($reflection, $prefix, $suffix, $value);

            $entity->$setterName($truncatedValue);
        }
    }
    
    /**
     * Tronque une valeur si elle dépasse la longueur maximale de la propriété.
     */
    private function truncateValueIfNeeded(\ReflectionClass $reflection, string $prefix, string $suffix, mixed $value): mixed
    {
        // Ne tronquer que les chaînes
        if (!is_string($value)) {
            return $value;
        }
        
        $propertyName = lcfirst($prefix) . $suffix;
        
        try {
            $property = $reflection->getProperty($propertyName);
            $attributes = $property->getAttributes(\Doctrine\ORM\Mapping\Column::class);
            
            if (empty($attributes)) {
                return $value;
            }
            
            $columnAttribute = $attributes[0]->newInstance();
            $maxLength = $columnAttribute->length ?? null;
            
            if ($maxLength && mb_strlen($value) > $maxLength) {
                return mb_substr($value, 0, $maxLength);
            }
        } catch (\ReflectionException $e) {
            // Si la propriété n'existe pas, retourner la valeur telle quelle
            return $value;
        }
        
        return $value;
    }

    /**
     * Trouve le préfixe des propriétés DAPLOS dans l'entité.
     *
     * Cherche une propriété avec l'attribut #[DaplosId] et extrait son préfixe.
     * Par exemple, si la propriété est $culturesId, retourne "cultures".
     *
     * @param \ReflectionClass<object> $reflection
     */
    private function findPropertyPrefix(\ReflectionClass $reflection): ?string
    {
        foreach ($reflection->getProperties() as $property) {
            $attributes = $property->getAttributes(DaplosId::class);
            if (!empty($attributes)) {
                // Extraire le préfixe du nom de la propriété
                $propertyName = $property->getName();
                // Retirer "Id" à la fin
                if (str_ends_with($propertyName, 'Id')) {
                    return substr($propertyName, 0, -2);
                }
            }
        }

        return null;
    }

    /**
     * Vérifie si une valeur est compatible avec un type attendu.
     */
    private function isTypeCompatible(mixed $value, \ReflectionType $expectedType): bool
    {
        if ($expectedType instanceof \ReflectionNamedType) {
            $typeName = $expectedType->getName();

            return match ($typeName) {
                'int' => is_int($value),
                'string' => is_string($value),
                'float' => is_float($value) || is_int($value),
                'bool' => is_bool($value),
                'array' => is_array($value),
                'mixed' => true,
                default => $value instanceof $typeName,
            };
        }

        // Pour les union types ou autres, on considère compatible
        return true;
    }

    /**
     * Recherche une entité par son ID DAPLOS.
     *
     * Stratégie :
     * 1. Si l'entité implémente DaplosEntityInterface, cherche avec getDaplosId()
     * 2. Sinon, cherche une propriété avec l'attribut #[DaplosId]
     */
    private function findEntityByDaplosId(string $entityClass, int $daplosId): ?object
    {
        $repository = $this->entityManager->getRepository($entityClass);
        $reflection = new \ReflectionClass($entityClass);

        // Cas 1 : L'entité implémente DaplosEntityInterface
        if ($reflection->implementsInterface(DaplosEntityInterface::class)) {
            // Chercher par la méthode getDaplosId()
            // On doit deviner le nom de la propriété... essayons plusieurs variantes
            $possibleProperties = ['daplosId', 'id'];

            foreach ($possibleProperties as $propertyName) {
                try {
                    $result = $repository->findOneBy([$propertyName => $daplosId]);
                    if ($result) {
                        return $result;
                    }
                } catch (\Exception $e) {
                    // Propriété inexistante, continuer
                    continue;
                }
            }
        }

        // Cas 2 : Chercher une propriété avec l'attribut #[DaplosId]
        foreach ($reflection->getProperties() as $property) {
            $attributes = $property->getAttributes(DaplosId::class);
            if (!empty($attributes)) {
                $propertyName = $property->getName();

                try {
                    $result = $repository->findOneBy([$propertyName => $daplosId]);
                    if ($result) {
                        return $result;
                    }
                } catch (\Exception $e) {
                    // Erreur lors de la recherche, continuer
                    continue;
                }
            }
        }

        return null;
    }

    /**
     * Récupère la liste de tous les référentiels disponibles.
     *
     * @return array<int, array<string, mixed>>
     *
     * @throws DaplosApiException
     */
    public function getAvailableReferentials(): array
    {
        return $this->apiClient->getReferentials();
    }

    /**
     * Récupère les détails d'un référentiel spécifique.
     *
     * @return array{referential: array<string, mixed>, references: array<int, array<string, mixed>>}
     *
     * @throws DaplosApiException
     */
    public function getReferentialDetails(int $referentialId): array
    {
        return $this->apiClient->getReferential($referentialId);
    }
}
