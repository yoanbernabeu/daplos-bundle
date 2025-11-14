<?php

namespace YoanBernabeu\DaplosBundle\Client;

use YoanBernabeu\DaplosBundle\Exception\DaplosApiException;

/**
 * Interface pour le client API DAPLOS.
 */
interface DaplosApiClientInterface
{
    /**
     * Récupère la liste de tous les référentiels disponibles.
     *
     * @return array<int, array{id: int, count: int, name: string, repository_code: string, repository_explanation: string}>
     *
     * @throws DaplosApiException
     */
    public function getReferentials(): array;

    /**
     * Récupère les détails d'un référentiel spécifique avec ses références.
     *
     * @param int $referentialId ID du référentiel
     *
     * @return array{referential: array<string, mixed>, references: array<int, array<string, mixed>>}
     *
     * @throws DaplosApiException
     */
    public function getReferential(int $referentialId): array;

    /**
     * Invalide le cache d'un référentiel spécifique.
     */
    public function clearReferentialCache(int $referentialId): void;

    /**
     * Invalide tout le cache des référentiels.
     */
    public function clearAllCache(): void;
}
