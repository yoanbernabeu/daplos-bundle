<?php

namespace YoanBernabeu\DaplosBundle\Service;

use YoanBernabeu\DaplosBundle\Exception\DaplosApiException;

/**
 * Interface pour le service de synchronisation des référentiels DAPLOS.
 */
interface ReferentialSyncServiceInterface
{
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
    ): array;

    /**
     * Récupère la liste de tous les référentiels disponibles.
     *
     * @return array<int, array<string, mixed>>
     *
     * @throws DaplosApiException
     */
    public function getAvailableReferentials(): array;

    /**
     * Récupère les détails d'un référentiel spécifique.
     *
     * @return array<string, mixed>
     *
     * @throws DaplosApiException
     */
    public function getReferentialDetails(int $referentialId): array;
}
