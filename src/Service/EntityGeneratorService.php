<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Service;

/**
 * Service de génération de l'entité DaplosReferential dans le projet utilisateur.
 *
 * Ce service permet de générer automatiquement l'entité Doctrine unique et son repository
 * pour stocker tous les référentiels DAPLOS dans une seule table.
 *
 * Principes d'idempotence :
 * - Ne crée pas de doublons (vérifie l'existence avant création)
 * - Rejouable sans effets de bord (force=false par défaut)
 *
 * @author Yoan Bernabeu
 */
class EntityGeneratorService implements EntityGeneratorServiceInterface
{
    private const ENTITY_NAME = 'DaplosReferential';

    public function __construct(
        private readonly string $projectDir,
        private readonly ?string $dbSchema = null
    ) {
    }

    /**
     * Vérifie le statut de l'entité DaplosReferential.
     *
     * @return array{entity_exists: bool, repository_exists: bool, entity_path: string, repository_path: string}
     */
    public function checkStatus(string $namespace = 'App\\Entity'): array
    {
        $entityPath = $this->getEntityPath($namespace);
        $repositoryPath = $this->getRepositoryPath($namespace);

        return [
            'entity_exists' => file_exists($entityPath),
            'repository_exists' => file_exists($repositoryPath),
            'entity_path' => $entityPath,
            'repository_path' => $repositoryPath,
        ];
    }

    /**
     * Génère l'entité DaplosReferential et son repository.
     *
     * @return array{success: bool, message: string, entity_path: string|null, repository_path: string|null, dry_run: bool}
     */
    public function generateEntity(
        string $namespace = 'App\\Entity',
        bool $withRepository = true,
        bool $dryRun = false,
        bool $force = false
    ): array {
        $entityPath = $this->getEntityPath($namespace);
        $repositoryPath = $withRepository ? $this->getRepositoryPath($namespace) : null;

        // Idempotence : vérifier si l'entité existe déjà
        if (file_exists($entityPath) && !$force) {
            return [
                'success' => false,
                'message' => sprintf('L\'entité %s existe déjà (utilisez --force pour écraser)', self::ENTITY_NAME),
                'entity_path' => $entityPath,
                'repository_path' => null,
                'dry_run' => false,
            ];
        }

        // Mode dry-run : ne pas créer les fichiers
        if ($dryRun) {
            return [
                'success' => true,
                'message' => sprintf('[DRY-RUN] Entité %s serait créée', self::ENTITY_NAME),
                'entity_path' => $entityPath,
                'repository_path' => $repositoryPath,
                'dry_run' => true,
            ];
        }

        // Générer le contenu de l'entité
        $entityContent = $this->generateEntityContent($namespace);

        // Créer le répertoire si nécessaire
        $entityDir = dirname($entityPath);
        if (!is_dir($entityDir)) {
            mkdir($entityDir, 0o755, true);
        }

        // Écrire l'entité
        file_put_contents($entityPath, $entityContent);

        // Générer le repository si demandé
        if ($withRepository) {
            $repositoryContent = $this->generateRepositoryContent($namespace);

            $repositoryDir = dirname($repositoryPath);
            if (!is_dir($repositoryDir)) {
                mkdir($repositoryDir, 0o755, true);
            }

            file_put_contents($repositoryPath, $repositoryContent);
        }

        return [
            'success' => true,
            'message' => sprintf('Entité %s créée avec succès', self::ENTITY_NAME),
            'entity_path' => $entityPath,
            'repository_path' => $repositoryPath,
            'dry_run' => false,
        ];
    }

    /**
     * Calcule le chemin du fichier d'entité.
     */
    private function getEntityPath(string $namespace): string
    {
        $relativePath = str_replace('\\', '/', str_replace('App\\', 'src/', $namespace));

        return $this->projectDir.'/'.$relativePath.'/'.self::ENTITY_NAME.'.php';
    }

    /**
     * Calcule le chemin du fichier de repository.
     */
    private function getRepositoryPath(string $namespace): string
    {
        $repositoryNamespace = str_replace('\\Entity', '\\Repository', $namespace);
        $relativePath = str_replace('\\', '/', str_replace('App\\', 'src/', $repositoryNamespace));

        return $this->projectDir.'/'.$relativePath.'/'.self::ENTITY_NAME.'Repository.php';
    }

    /**
     * Génère le contenu PHP de l'entité.
     */
    private function generateEntityContent(string $namespace): string
    {
        $repositoryNamespace = str_replace('\\Entity', '\\Repository', $namespace);
        $schemaAttribute = $this->getSchemaAttribute();

        return <<<PHP
            <?php

            declare(strict_types=1);

            namespace {$namespace};

            use {$repositoryNamespace}\\DaplosReferentialRepository;
            use Doctrine\ORM\Mapping as ORM;
            use YoanBernabeu\DaplosBundle\Contract\DaplosEntityInterface;
            use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosReferentialTrait;
            use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;

            /**
             * Entité unique pour tous les référentiels DAPLOS.
             *
             * Cette entité stocke tous les items de tous les référentiels DAPLOS
             * dans une seule table, discriminés par le champ referentialType.
             *
             * Générée automatiquement par DaplosBundle.
             */
            #[ORM\Entity(repositoryClass: DaplosReferentialRepository::class)]
            #[ORM\Table(name: 'daplos_referential'{$schemaAttribute})]
            #[ORM\UniqueConstraint(name: 'daplos_unique_item', columns: ['daplos_id', 'referential_type'])]
            #[ORM\Index(name: 'daplos_type_idx', columns: ['referential_type'])]
            class DaplosReferential implements DaplosEntityInterface
            {
                use DaplosReferentialTrait;

                #[ORM\Id]
                #[ORM\GeneratedValue]
                #[ORM\Column]
                private ?int \$id = null;

                public function getId(): ?int
                {
                    return \$this->id;
                }
            }

            PHP;
    }

    /**
     * Génère le contenu PHP du repository.
     */
    private function generateRepositoryContent(string $namespace): string
    {
        $repositoryNamespace = str_replace('\\Entity', '\\Repository', $namespace);

        return <<<PHP
            <?php

            declare(strict_types=1);

            namespace {$repositoryNamespace};

            use {$namespace}\\DaplosReferential;
            use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
            use Doctrine\Persistence\ManagerRegistry;
            use YoanBernabeu\DaplosBundle\Contract\DaplosRepositoryInterface;
            use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;

            /**
             * Repository pour l'entité DaplosReferential.
             *
             * Généré automatiquement par DaplosBundle.
             *
             * @extends ServiceEntityRepository<DaplosReferential>
             */
            class DaplosReferentialRepository extends ServiceEntityRepository implements DaplosRepositoryInterface
            {
                public function __construct(ManagerRegistry \$registry)
                {
                    parent::__construct(\$registry, DaplosReferential::class);
                }

                /**
                 * Trouve une entité par son ID DAPLOS et son type de référentiel.
                 */
                public function findOneByDaplosIdAndType(int \$daplosId, DaplosReferentialType \$type): ?DaplosReferential
                {
                    return \$this->findOneBy([
                        'daplosId' => \$daplosId,
                        'referentialType' => \$type,
                    ]);
                }

                /**
                 * Trouve toutes les entités d'un type de référentiel donné.
                 *
                 * @return array<DaplosReferential>
                 */
                public function findByReferentialType(DaplosReferentialType \$type): array
                {
                    return \$this->findBy(['referentialType' => \$type]);
                }

                /**
                 * Trouve une entité par son code de référence et son type.
                 */
                public function findOneByReferenceCodeAndType(string \$referenceCode, DaplosReferentialType \$type): ?DaplosReferential
                {
                    return \$this->findOneBy([
                        'daplosReferenceCode' => \$referenceCode,
                        'referentialType' => \$type,
                    ]);
                }
            }

            PHP;
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
