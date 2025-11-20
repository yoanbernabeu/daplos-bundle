<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Contract;

/**
 * Interface pour les repositories gérant les entités DAPLOS.
 *
 * @template T of object
 */
interface DaplosRepositoryInterface
{
    /**
     * Trouve une entité par son ID DAPLOS.
     *
     * @return T|null
     */
    public function findOneByDaplosId(int $daplosId): ?object;
}
