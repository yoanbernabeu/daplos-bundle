<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Contract;

use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;

/**
 * Interface pour les repositories gérant les entités DAPLOS.
 *
 * @template T of object
 */
interface DaplosRepositoryInterface
{
    /**
     * Trouve une entité par son ID DAPLOS et son type de référentiel.
     *
     * @return T|null
     */
    public function findOneByDaplosIdAndType(int $daplosId, DaplosReferentialType $type): ?object;

    /**
     * Trouve toutes les entités d'un type de référentiel donné.
     *
     * @return array<T>
     */
    public function findByReferentialType(DaplosReferentialType $type): array;
}
