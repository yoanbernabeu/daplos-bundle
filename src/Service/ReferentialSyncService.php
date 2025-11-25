<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use YoanBernabeu\DaplosBundle\Client\DaplosApiClientInterface;
use YoanBernabeu\DaplosBundle\Contract\DaplosEntityInterface;
use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;
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
     * Synchronise un référentiel DAPLOS spécifique.
     *
     * @return array{created: int, updated: int, total: int}
     *
     * @throws DaplosApiException
     */
    public function syncReferential(
        string $entityClass,
        DaplosReferentialType $type
    ): array {
        $referentialId = $type->getId();
        $data = $this->apiClient->getReferential($referentialId);
        $references = $data['references'];

        $stats = ['created' => 0, 'updated' => 0, 'total' => count($references)];

        $this->entityManager->beginTransaction();

        try {
            $i = 0;
            $repository = $this->entityManager->getRepository($entityClass);

            foreach ($references as $reference) {
                $daplosId = $reference['id'] ?? null;
                if (!$daplosId) {
                    continue;
                }

                // Rechercher si l'entité existe déjà (par daplosId + type)
                $entity = $repository->findOneBy([
                    'daplosId' => $daplosId,
                    'referentialType' => $type,
                ]);

                $isNew = false;
                if (!$entity) {
                    $entity = new $entityClass();
                    $isNew = true;
                }

                // Mapping des champs
                $this->mapFields($entity, $reference, $type);

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

            throw new DaplosApiException(sprintf('Erreur lors de la synchronisation du référentiel %s (ID: %d) : %s', $type->getLabel(), $referentialId, $e->getMessage()), 0, $e);
        }

        return $stats;
    }

    /**
     * Synchronise tous les référentiels DAPLOS.
     *
     * @return array{created: int, updated: int, total: int, types_synced: int}
     *
     * @throws DaplosApiException
     */
    public function syncAllReferentials(string $entityClass): array
    {
        $totalStats = [
            'created' => 0,
            'updated' => 0,
            'total' => 0,
            'types_synced' => 0,
        ];

        foreach (DaplosReferentialType::cases() as $type) {
            try {
                $stats = $this->syncReferential($entityClass, $type);

                $totalStats['created'] += $stats['created'];
                $totalStats['updated'] += $stats['updated'];
                $totalStats['total'] += $stats['total'];
                ++$totalStats['types_synced'];
            } catch (DaplosApiException $e) {
                // Log l'erreur mais continue avec les autres référentiels
                // L'appelant peut choisir de gérer ça différemment
                throw $e;
            }
        }

        return $totalStats;
    }

    /**
     * Mapping des champs du référentiel vers l'entité.
     *
     * @param DaplosEntityInterface $entity
     * @param array<string, mixed>  $reference
     */
    private function mapFields(object $entity, array $reference, DaplosReferentialType $type): void
    {
        if (!$entity instanceof DaplosEntityInterface) {
            throw new \InvalidArgumentException(sprintf('L\'entité doit implémenter %s', DaplosEntityInterface::class));
        }

        $daplosId = $reference['id'] ?? null;
        $title = $reference['title'] ?? null;
        $referenceCode = $reference['reference_code'] ?? null;

        // Tronquer le title si nécessaire (max 255 caractères)
        if (null !== $title && mb_strlen($title) > 255) {
            $title = mb_substr($title, 0, 255);
        }

        // Tronquer le referenceCode si nécessaire (max 100 caractères)
        if (null !== $referenceCode && mb_strlen($referenceCode) > 100) {
            $referenceCode = mb_substr($referenceCode, 0, 100);
        }

        $entity
            ->setDaplosId($daplosId)
            ->setDaplosTitle($title)
            ->setDaplosReferenceCode($referenceCode)
            ->setReferentialType($type);
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
