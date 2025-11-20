<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Service;

/**
 * Service de génération d'entités et de repositories dans le projet utilisateur.
 *
 * Ce service permet de générer automatiquement des entités Doctrine et leurs repositories
 * à partir des référentiels DAPLOS disponibles. Les entités générées utilisent les traits
 * du bundle et l'attribut #[DaplosId] pour faciliter la synchronisation.
 *
 * Principes d'idempotence :
 * - Ne crée pas de doublons (vérifie l'existence avant création)
 * - Rejouable sans effets de bord (force=false par défaut)
 * - Utilise des identifiants uniques (nom de l'entité basé sur le référentiel)
 *
 * @author Yoan Bernabeu
 */
class EntityGeneratorService implements EntityGeneratorServiceInterface
{
    public function __construct(
        private readonly ReferentialSyncServiceInterface $syncService,
        private readonly string $projectDir,
        private readonly ?string $dbSchema = null
    ) {
    }

    /**
     * Vérifie le statut de toutes les entités DAPLOS potentielles.
     *
     * @return array<int, array{referential_id: int, referential_name: string, entity_name: string, entity_exists: bool, repository_exists: bool, entity_path: string|null, repository_path: string|null, trait_name: string}>
     */
    public function checkStatus(string $namespace = 'App\\Entity\\Daplos'): array
    {
        $referentials = $this->syncService->getAvailableReferentials();
        $status = [];

        foreach ($referentials as $ref) {
            $entityName = $this->generateEntityName($ref['name']);
            $traitName = $this->generateTraitName($ref['name']);

            $entityPath = $this->getEntityPath($entityName, $namespace);
            $repositoryPath = $this->getRepositoryPath($entityName, $namespace);

            $status[] = [
                'referential_id' => $ref['id'],
                'referential_name' => $ref['name'],
                'entity_name' => $entityName,
                'entity_exists' => file_exists($entityPath),
                'repository_exists' => file_exists($repositoryPath),
                'entity_path' => file_exists($entityPath) ? $entityPath : null,
                'repository_path' => file_exists($repositoryPath) ? $repositoryPath : null,
                'trait_name' => $traitName,
            ];
        }

        return $status;
    }

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
    ): array {
        $entityName = $this->generateEntityName($referential['name']);
        $entityPath = $this->getEntityPath($entityName, $namespace);
        $repositoryPath = $withRepository ? $this->getRepositoryPath($entityName, $namespace) : null;

        // Idempotence : vérifier si l'entité existe déjà
        if (file_exists($entityPath) && !$force) {
            return [
                'success' => false,
                'message' => sprintf('L\'entité %s existe déjà (utilisez --force pour écraser)', $entityName),
                'entity_path' => $entityPath,
                'repository_path' => null,
                'dry_run' => false,
            ];
        }

        $traitName = $this->generateTraitName($referential['name']);
        $propertyPrefix = lcfirst($this->normalizeTraitName($referential['name']));

        // Générer le contenu de l'entité
        $entityContent = $this->generateEntityContent(
            entityName: $entityName,
            namespace: $namespace,
            traitName: $traitName,
            propertyPrefix: $propertyPrefix,
            referential: $referential
        );

        // Mode dry-run : ne pas créer les fichiers
        if ($dryRun) {
            return [
                'success' => true,
                'message' => sprintf('[DRY-RUN] Entité %s serait créée', $entityName),
                'entity_path' => $entityPath,
                'repository_path' => $repositoryPath,
                'dry_run' => true,
            ];
        }

        // Créer le répertoire si nécessaire
        $entityDir = dirname($entityPath);
        if (!is_dir($entityDir)) {
            mkdir($entityDir, 0o755, true);
        }

        // Écrire l'entité
        file_put_contents($entityPath, $entityContent);

        // Générer le repository si demandé
        if ($withRepository) {
            $repositoryContent = $this->generateRepositoryContent(
                entityName: $entityName,
                namespace: $namespace
            );

            $repositoryDir = dirname($repositoryPath);
            if (!is_dir($repositoryDir)) {
                mkdir($repositoryDir, 0o755, true);
            }

            file_put_contents($repositoryPath, $repositoryContent);
        }

        return [
            'success' => true,
            'message' => sprintf('Entité %s créée avec succès', $entityName),
            'entity_path' => $entityPath,
            'repository_path' => $repositoryPath,
            'dry_run' => false,
        ];
    }

    /**
     * Génère toutes les entités pour tous les référentiels disponibles.
     *
     * Cette méthode est idempotente : elle ne recrée pas les entités existantes.
     *
     * @return array<int, array{success: bool, message: string, entity_name: string, entity_path: string|null}>
     */
    public function generateAllEntities(
        string $namespace = 'App\\Entity\\Daplos',
        bool $withRepositories = true,
        bool $dryRun = false,
        bool $force = false
    ): array {
        $referentials = $this->syncService->getAvailableReferentials();
        $results = [];

        foreach ($referentials as $ref) {
            $result = $this->generateEntity(
                referential: $ref,
                namespace: $namespace,
                withRepository: $withRepositories,
                dryRun: $dryRun,
                force: $force
            );

            $results[] = array_merge($result, [
                'entity_name' => $this->generateEntityName($ref['name']),
            ]);
        }

        return $results;
    }

    /**
     * Met à jour les repositories existants pour implémenter DaplosRepositoryInterface.
     */
    public function updateRepositories(
        string $namespace = 'App\\Entity\\Daplos',
        bool $dryRun = false
    ): array {
        $referentials = $this->syncService->getAvailableReferentials();
        $results = [];

        foreach ($referentials as $ref) {
            $entityName = $this->generateEntityName($ref['name']);
            $repositoryPath = $this->getRepositoryPath($entityName, $namespace);

            if (!file_exists($repositoryPath)) {
                continue;
            }

            $content = file_get_contents($repositoryPath);

            // Vérifier si déjà mis à jour
            if (str_contains($content, 'implements DaplosRepositoryInterface')) {
                $results[] = [
                    'repository' => basename($repositoryPath),
                    'status' => 'skipped',
                    'message' => 'Déjà à jour',
                ];
                continue;
            }

            // Préparer les modifications
            $newContent = $content;
            $updated = false;

            // 1. Ajouter le use
            if (!str_contains($newContent, 'use YoanBernabeu\DaplosBundle\Contract\DaplosRepositoryInterface;')) {
                $newContent = preg_replace(
                    '/(use Doctrine\\\\Persistence\\\\ManagerRegistry;)/',
                    "$1\nuse YoanBernabeu\DaplosBundle\Contract\DaplosRepositoryInterface;",
                    $newContent
                );
            }

            // 2. Ajouter l'interface
            if (!str_contains($newContent, 'implements DaplosRepositoryInterface')) {
                $newContent = preg_replace(
                    '/class\s+\w+Repository\s+extends\s+ServiceEntityRepository/',
                    '$0 implements DaplosRepositoryInterface',
                    $newContent
                );
            }

            // 3. Ajouter la méthode si absente
            if (!str_contains($newContent, 'findOneByDaplosId')) {
                $methodCode = <<<PHP

                    /**
                     * Trouve une entité par son ID DAPLOS.
                     * Utile pour éviter les doublons lors de la synchronisation.
                     */
                    public function findOneByDaplosId(int \$daplosId): ?{$entityName}
                    {
                        return \$this->findOneBy(['{$this->lcfirst($this->normalizeTraitName($entityName))}Id' => \$daplosId]);
                    }
                }
                PHP;

                // Remplacer la dernière accolade fermante
                $newContent = preg_replace('/}\s*$/', $methodCode, $newContent);
                $updated = true;
            }

            if ($updated) {
                if (!$dryRun) {
                    file_put_contents($repositoryPath, $newContent);
                }

                $results[] = [
                    'repository' => basename($repositoryPath),
                    'status' => 'updated',
                    'message' => $dryRun ? 'Serait mis à jour' : 'Mis à jour avec succès',
                ];
            }
        }

        return $results;
    }

    /**
     * Génère le nom de l'entité à partir du nom du référentiel.
     * Exemple: "Culture (Destination)" → "CultureDestination".
     * Exemple: "Cultures" → "Culture".
     *
     * Pour éviter les collisions, on garde les qualifiants entre parenthèses.
     */
    private function generateEntityName(string $referentialName): string
    {
        // Utiliser la même logique que normalizeTraitName pour conserver les qualifiants
        $normalized = $this->normalizeTraitName($referentialName);

        // Ne pas mettre au singulier - les noms des traits n'ont pas ce traitement
        // Garder la cohérence avec les traits pour éviter les problèmes de mapping
        return ucfirst($normalized);
    }

    /**
     * Génère le nom du trait à partir du nom du référentiel.
     */
    private function generateTraitName(string $referentialName): string
    {
        return $this->normalizeTraitName($referentialName).'Trait';
    }

    /**
     * Convertit une chaîne en CamelCase en préservant les séparateurs de mots.
     */
    private function toCamelCase(string $text): string
    {
        // Nettoyer les accents
        $unwantedArray = [
            'Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z',
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A',
            'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
            'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N',
            'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',
            'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a',
            'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n',
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y',
        ];

        $text = strtr($text, $unwantedArray);

        // Diviser en mots par espaces, tirets, underscores et autres caractères non alphanumériques
        $words = preg_split('/[\s\-_]+|[^a-zA-Z0-9]+/', $text, -1, PREG_SPLIT_NO_EMPTY);

        // Mettre en majuscule la première lettre de chaque mot et concaténer
        $camelCase = '';
        foreach ($words as $word) {
            // Ne garder que les caractères alphanumériques du mot
            $cleanWord = preg_replace('/[^a-zA-Z0-9]/', '', $word);
            if ('' !== $cleanWord) {
                $camelCase .= ucfirst(strtolower($cleanWord));
            }
        }

        return $camelCase;
    }

    /**
     * Normalise un nom de référentiel en nom de classe/trait.
     */
    private function normalizeTraitName(string $name): string
    {
        $qualifier = '';
        if (preg_match('/\(([^)]+)\)/', $name, $matches)) {
            $qualifier = $matches[1];
        }

        $mainName = preg_replace('/\s*\([^)]*\)/', '', $name);

        // Convertir en CamelCase
        $mainNameCamelCase = $this->toCamelCase($mainName);
        $qualifierCamelCase = '' !== $qualifier ? $this->toCamelCase($qualifier) : '';

        return $mainNameCamelCase.$qualifierCamelCase;
    }

    /**
     * Calcule le chemin du fichier d'entité.
     */
    private function getEntityPath(string $entityName, string $namespace): string
    {
        $relativePath = str_replace('\\', '/', str_replace('App\\', 'src/', $namespace));

        return $this->projectDir.'/'.$relativePath.'/'.$entityName.'.php';
    }

    /**
     * Calcule le chemin du fichier de repository.
     */
    private function getRepositoryPath(string $entityName, string $namespace): string
    {
        $relativePath = str_replace('\\Entity', '\\Repository', $namespace);
        $relativePath = str_replace('\\', '/', str_replace('App\\', 'src/', $relativePath));

        return $this->projectDir.'/'.$relativePath.'/'.$entityName.'Repository.php';
    }

    /**
     * Génère le contenu PHP de l'entité.
     *
     * @param array<string, mixed> $referential
     */
    private function generateEntityContent(
        string $entityName,
        string $namespace,
        string $traitName,
        string $propertyPrefix,
        array $referential
    ): string {
        $repositoryNamespace = str_replace('\\Entity', '\\Repository', $namespace);

        return <<<PHP
            <?php

            declare(strict_types=1);

            namespace {$namespace};

            use {$repositoryNamespace}\\{$entityName}Repository;
            use Doctrine\ORM\Mapping as ORM;
            use YoanBernabeu\DaplosBundle\Entity\Trait\\{$traitName};

            /**
             * Entité {$entityName}
             * 
             * Correspond au référentiel DAPLOS "{$referential['name']}" (ID: {$referential['id']})
             * Repository Code: {$referential['repository_code']}
             * 
             * Générée automatiquement par DaplosBundle.
             */
            #[ORM\Entity(repositoryClass: {$entityName}Repository::class)]
            #[ORM\Table(name: '{$this->generateTableName($entityName)}'{$this->getSchemaAttribute()})]
            class {$entityName}
            {
                use {$traitName};

                #[ORM\Id]
                #[ORM\GeneratedValue]
                #[ORM\Column]
                private ?int \$id = null;

                public function getId(): ?int
                {
                    return \$this->id;
                }

                // Les getters/setters pour {$propertyPrefix}Id, {$propertyPrefix}Title, {$propertyPrefix}ReferenceCode
                // sont fournis par le trait {$traitName}
                // La propriété {$propertyPrefix}Id est définie dans le trait avec l'attribut #[DaplosId]
            }

            PHP;
    }

    /**
     * Génère le contenu PHP du repository.
     */
    private function generateRepositoryContent(string $entityName, string $namespace): string
    {
        $repositoryNamespace = str_replace('\\Entity', '\\Repository', $namespace);

        return <<<PHP
            <?php

            declare(strict_types=1);

            namespace {$repositoryNamespace};

            use {$namespace}\\{$entityName};
            use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
            use Doctrine\Persistence\ManagerRegistry;
            use YoanBernabeu\DaplosBundle\Contract\DaplosRepositoryInterface;

            /**
             * Repository pour l'entité {$entityName}
             * 
             * Générée automatiquement par DaplosBundle.
             * 
             * @extends ServiceEntityRepository<{$entityName}>
             */
            class {$entityName}Repository extends ServiceEntityRepository implements DaplosRepositoryInterface
            {
                public function __construct(ManagerRegistry \$registry)
                {
                    parent::__construct(\$registry, {$entityName}::class);
                }

                /**
                 * Trouve une entité par son ID DAPLOS.
                 * Utile pour éviter les doublons lors de la synchronisation.
                 */
                public function findOneByDaplosId(int \$daplosId): ?{$entityName}
                {
                    return \$this->findOneBy(['{$this->lcfirst($this->normalizeTraitName($entityName))}Id' => \$daplosId]);
                }
            }

            PHP;
    }

    /**
     * Génère le nom de table à partir du nom de l'entité.
     */
    private function generateTableName(string $entityName): string
    {
        // Convertir CamelCase en snake_case et ajouter le préfixe daplos_
        $tableName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $entityName));

        return 'daplos_'.$tableName;
    }

    /**
     * Première lettre en minuscule.
     */
    private function lcfirst(string $string): string
    {
        return lcfirst($string);
    }

    /**
     * Génère l'attribut schema si défini.
     */
    private function getSchemaAttribute(): string
    {
        if (null === $this->dbSchema) {
            return '';
        }

        return ", schema: '{$this->dbSchema}'";
    }
}
