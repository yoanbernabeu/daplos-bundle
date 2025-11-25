<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Service;

use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;
use YoanBernabeu\DaplosBundle\Exception\DaplosApiException;

/**
 * Interface pour le service de synchronisation des référentiels DAPLOS.
 */
interface ReferentialSyncServiceInterface
{
    /**
     * Synchronise un référentiel DAPLOS spécifique.
     *
     * @param string                  $entityClass Le nom complet de la classe entité (ex: App\Entity\DaplosReferential)
     * @param DaplosReferentialType   $type        Le type de référentiel à synchroniser
     *
     * @return array{created: int, updated: int, total: int}
     *
     * @throws DaplosApiException
     */
    public function syncReferential(
        string $entityClass,
        DaplosReferentialType $type
    ): array;

    /**
     * Synchronise tous les référentiels DAPLOS.
     *
     * @param string $entityClass Le nom complet de la classe entité (ex: App\Entity\DaplosReferential)
     *
     * @return array{created: int, updated: int, total: int, types_synced: int}
     *
     * @throws DaplosApiException
     */
    public function syncAllReferentials(string $entityClass): array;

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
     * @return array{referential: array<string, mixed>, references: array<int, array<string, mixed>>}
     *
     * @throws DaplosApiException
     */
    public function getReferentialDetails(int $referentialId): array;
}
