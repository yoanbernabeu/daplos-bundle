<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Service;

/**
 * Interface du service de génération d'entités et de repositories.
 *
 * Ce service permet de générer automatiquement des entités Doctrine et leurs repositories
 * à partir des référentiels DAPLOS disponibles.
 *
 * @author Yoan Bernabeu
 */
interface EntityGeneratorServiceInterface
{
    /**
     * Vérifie le statut de toutes les entités DAPLOS potentielles.
     *
     * Retourne un tableau avec les informations sur chaque référentiel :
     * - referential_id : ID du référentiel DAPLOS
     * - referential_name : Nom du référentiel
     * - entity_name : Nom de l'entité générée
     * - entity_exists : true si l'entité existe déjà
     * - repository_exists : true si le repository existe déjà
     * - entity_path : Chemin complet vers l'entité (si elle existe)
     * - repository_path : Chemin complet vers le repository (s'il existe)
     * - trait_name : Nom du trait utilisé
     *
     * @param string $namespace Le namespace des entités (default: App\Entity\Daplos)
     *
     * @return array<int, array{referential_id: int, referential_name: string, entity_name: string, entity_exists: bool, repository_exists: bool, entity_path: string|null, repository_path: string|null, trait_name: string}>
     */
    public function checkStatus(string $namespace = 'App\\Entity\\Daplos'): array;

    /**
     * Génère une entité et optionnellement son repository.
     *
     * Cette méthode est idempotente : elle ne recrée pas une entité existante
     * sans l'option force=true.
     *
     * @param array<string, mixed> $referential    Les données du référentiel DAPLOS
     * @param string               $namespace      Le namespace de l'entité (default: App\Entity\Daplos)
     * @param bool                 $withRepository Générer aussi le repository
     * @param bool                 $dryRun         Mode simulation (ne crée pas les fichiers)
     * @param bool                 $force          Forcer la recréation si l'entité existe
     *
     * @return array{success: bool, message: string, entity_path: string|null, repository_path: string|null, dry_run: bool}
     */
    public function generateEntity(
        array $referential,
        string $namespace = 'App\\Entity\\Daplos',
        bool $withRepository = true,
        bool $dryRun = false,
        bool $force = false
    ): array;

    /**
     * Génère toutes les entités pour tous les référentiels DAPLOS disponibles.
     *
     * Cette méthode est idempotente : elle ne recrée pas les entités existantes
     * sans l'option force=true.
     *
     * @param string $namespace        Le namespace des entités (default: App\Entity\Daplos)
     * @param bool   $withRepositories Générer aussi les repositories
     * @param bool   $dryRun           Mode simulation (ne crée pas les fichiers)
     * @param bool   $force            Forcer la recréation des entités existantes
     *
     * @return array<int, array{success: bool, message: string, entity_name: string, entity_path: string|null}>
     */
    public function generateAllEntities(
        string $namespace = 'App\\Entity\\Daplos',
        bool $withRepositories = true,
        bool $dryRun = false,
        bool $force = false
    ): array;
}
