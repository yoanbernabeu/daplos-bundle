<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;
use YoanBernabeu\DaplosBundle\Parser\Exception\InvalidReferentialCodeException;

/**
 * Service pour résoudre les codes DAPLOS vers les entités référentielles.
 */
final class ReferentialCodeResolver
{
    /** @var array<string, array<string, object|null>> Cache des entités résolues */
    private array $resolvedEntities = [];

    /** @var class-string|null Classe de l'entité référentielle */
    private ?string $entityClass = null;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Configure la classe d'entité à utiliser pour la résolution.
     *
     * @param class-string $entityClass
     */
    public function setEntityClass(string $entityClass): void
    {
        $this->entityClass = $entityClass;
    }

    /**
     * Résout un code vers son entité référentielle.
     *
     * @throws InvalidReferentialCodeException Si le code n'existe pas et $strict=true
     */
    public function resolve(string $code, DaplosReferentialType $type, bool $strict = false): ?object
    {
        if (null === $this->entityClass) {
            if ($strict) {
                throw new InvalidReferentialCodeException($code, $type);
            }

            return null;
        }

        // Normaliser le code
        $code = trim($code);
        if ('' === $code) {
            return null;
        }

        // Vérifier dans le cache
        $cacheKey = $type->value;
        if (isset($this->resolvedEntities[$cacheKey]) && array_key_exists($code, $this->resolvedEntities[$cacheKey])) {
            $entity = $this->resolvedEntities[$cacheKey][$code];
            if ($strict && null === $entity) {
                throw new InvalidReferentialCodeException($code, $type);
            }

            return $entity;
        }

        // Chercher dans la base de données
        $entity = $this->findEntity($code, $type);

        // Mettre en cache
        if (!isset($this->resolvedEntities[$cacheKey])) {
            $this->resolvedEntities[$cacheKey] = [];
        }
        $this->resolvedEntities[$cacheKey][$code] = $entity;

        if (null === $entity && $strict) {
            throw new InvalidReferentialCodeException($code, $type);
        }

        return $entity;
    }

    /**
     * Vérifie si un code existe dans le référentiel.
     */
    public function exists(string $code, DaplosReferentialType $type): bool
    {
        return null !== $this->resolve($code, $type);
    }

    /**
     * Résout plusieurs codes à la fois (optimisation batch).
     *
     * @param array<string> $codes
     *
     * @return array<string, object|null>
     */
    public function resolveMany(array $codes, DaplosReferentialType $type): array
    {
        if (null === $this->entityClass) {
            return array_fill_keys($codes, null);
        }

        $result = [];
        $codesToFetch = [];
        $cacheKey = $type->value;

        // Vérifier le cache et identifier les codes à charger
        foreach ($codes as $code) {
            $normalizedCode = trim($code);
            if ('' === $normalizedCode) {
                $result[$code] = null;

                continue;
            }

            if (isset($this->resolvedEntities[$cacheKey][$normalizedCode])) {
                $result[$code] = $this->resolvedEntities[$cacheKey][$normalizedCode];
            } else {
                $codesToFetch[$normalizedCode] = $code;
            }
        }

        // Charger les codes manquants en une seule requête
        if (count($codesToFetch) > 0) {
            $entities = $this->findEntitiesByCodes(array_keys($codesToFetch), $type);

            foreach ($codesToFetch as $normalizedCode => $originalCode) {
                $entity = $entities[$normalizedCode] ?? null;

                // Mettre en cache
                if (!isset($this->resolvedEntities[$cacheKey])) {
                    $this->resolvedEntities[$cacheKey] = [];
                }
                $this->resolvedEntities[$cacheKey][$normalizedCode] = $entity;

                $result[$originalCode] = $entity;
            }
        }

        return $result;
    }

    /**
     * Retourne le libellé d'un code.
     */
    public function getLabel(string $code, DaplosReferentialType $type): ?string
    {
        $entity = $this->resolve($code, $type);
        if (null === $entity) {
            return null;
        }

        // Utilise la méthode getDaplosTitle() si elle existe
        if (method_exists($entity, 'getDaplosTitle')) {
            return $entity->getDaplosTitle();
        }

        return null;
    }

    /**
     * Précharge tous les codes d'un type de référentiel.
     */
    public function preloadType(DaplosReferentialType $type): void
    {
        if (null === $this->entityClass) {
            return;
        }

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('e')
            ->from($this->entityClass, 'e')
            ->where('e.referentialType = :type')
            ->setParameter('type', $type);

        $entities = $qb->getQuery()->getResult();
        $cacheKey = $type->value;

        if (!isset($this->resolvedEntities[$cacheKey])) {
            $this->resolvedEntities[$cacheKey] = [];
        }

        foreach ($entities as $entity) {
            if (method_exists($entity, 'getDaplosReferenceCode')) {
                $code = $entity->getDaplosReferenceCode();
                if (null !== $code) {
                    $this->resolvedEntities[$cacheKey][$code] = $entity;
                }
            }
        }
    }

    /**
     * Réinitialise le cache des entités résolues.
     */
    public function clearCache(): void
    {
        $this->resolvedEntities = [];
    }

    private function findEntity(string $code, DaplosReferentialType $type): ?object
    {
        if (null === $this->entityClass) {
            return null;
        }

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('e')
            ->from($this->entityClass, 'e')
            ->where('e.daplosReferenceCode = :code')
            ->andWhere('e.referentialType = :type')
            ->setParameter('code', $code)
            ->setParameter('type', $type)
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param array<string> $codes
     *
     * @return array<string, object>
     */
    private function findEntitiesByCodes(array $codes, DaplosReferentialType $type): array
    {
        if (null === $this->entityClass || 0 === count($codes)) {
            return [];
        }

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('e')
            ->from($this->entityClass, 'e')
            ->where('e.daplosReferenceCode IN (:codes)')
            ->andWhere('e.referentialType = :type')
            ->setParameter('codes', $codes)
            ->setParameter('type', $type);

        $entities = $qb->getQuery()->getResult();
        $result = [];

        foreach ($entities as $entity) {
            if (method_exists($entity, 'getDaplosReferenceCode')) {
                $code = $entity->getDaplosReferenceCode();
                if (null !== $code) {
                    $result[$code] = $entity;
                }
            }
        }

        return $result;
    }
}
