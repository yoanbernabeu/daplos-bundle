<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Service;

/**
 * Interface du service de génération d'entité DAPLOS.
 *
 * Ce service permet de générer automatiquement l'entité unique DaplosReferential
 * et son repository dans le projet utilisateur.
 *
 * @author Yoan Bernabeu
 */
interface EntityGeneratorServiceInterface
{
    /**
     * Vérifie le statut de l'entité DaplosReferential.
     *
     * @param string $namespace Le namespace de l'entité (default: App\Entity)
     *
     * @return array{entity_exists: bool, repository_exists: bool, entity_path: string, repository_path: string}
     */
    public function checkStatus(string $namespace = 'App\\Entity'): array;

    /**
     * Génère l'entité DaplosReferential et son repository.
     *
     * Cette méthode est idempotente : elle ne recrée pas une entité existante
     * sans l'option force=true.
     *
     * @param string $namespace      Le namespace de l'entité (default: App\Entity)
     * @param bool   $withRepository Générer aussi le repository
     * @param bool   $dryRun         Mode simulation (ne crée pas les fichiers)
     * @param bool   $force          Forcer la recréation si l'entité existe
     *
     * @return array{success: bool, message: string, entity_path: string|null, repository_path: string|null, dry_run: bool}
     */
    public function generateEntity(
        string $namespace = 'App\\Entity',
        bool $withRepository = true,
        bool $dryRun = false,
        bool $force = false
    ): array;
}
