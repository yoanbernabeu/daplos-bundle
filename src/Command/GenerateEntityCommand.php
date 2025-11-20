<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use YoanBernabeu\DaplosBundle\Service\EntityGeneratorServiceInterface;

#[AsCommand(
    name: 'daplos:generate:entity',
    description: 'Génère des entités et repositories pour les référentiels DAPLOS'
)]
class GenerateEntityCommand extends Command
{
    public function __construct(
        private readonly EntityGeneratorServiceInterface $generatorService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption(
                'namespace',
                's',
                InputOption::VALUE_OPTIONAL,
                'Namespace des entités à générer',
                'App\\Entity\\Daplos'
            )
            ->addOption(
                'no-repository',
                null,
                InputOption::VALUE_NONE,
                'Ne pas générer les repositories'
            )
            ->addOption(
                'dry-run',
                null,
                InputOption::VALUE_NONE,
                'Simule la génération sans créer les fichiers'
            )
            ->addOption(
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Force la recréation des entités existantes'
            )
            ->addOption(
                'all',
                'a',
                InputOption::VALUE_NONE,
                'Génère toutes les entités pour tous les référentiels'
            )
            ->addOption(
                'check',
                'c',
                InputOption::VALUE_NONE,
                'Vérifie le statut des entités sans les générer'
            )
            ->addOption(
                'update-repos',
                'u',
                InputOption::VALUE_NONE,
                'Met à jour les repositories existants pour implémenter l\'interface requise'
            )
            ->setHelp(
                <<<'HELP'
                    Cette commande génère automatiquement des entités Doctrine et leurs repositories
                    à partir des référentiels DAPLOS disponibles.
                    
                    <info>Exemples d'utilisation :</info>
                    
                      # Vérifier le statut des entités
                      <comment>php bin/console daplos:generate:entity --check</comment>
                      
                      # Mettre à jour les repositories existants (ajout interface/méthode)
                      <comment>php bin/console daplos:generate:entity --update-repos</comment>

                      # Générer toutes les entités (mode interactif)
                      <comment>php bin/console daplos:generate:entity --all</comment>

                      # Simuler la génération (dry-run)
                      <comment>php bin/console daplos:generate:entity --all --dry-run</comment>

                      # Générer dans un namespace personnalisé
                      <comment>php bin/console daplos:generate:entity --all --namespace="App\Domain\Agriculture"</comment>

                      # Générer sans repositories
                      <comment>php bin/console daplos:generate:entity --all --no-repository</comment>

                      # Force la recréation des entités existantes
                      <comment>php bin/console daplos:generate:entity --all --force</comment>

                    <info>Principes d'idempotence :</info>

                      La commande est idempotente par défaut : elle ne recrée pas les entités
                      existantes. Utilisez --force pour forcer la recréation.

                    HELP
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Générateur d\'entités DAPLOS');

        $namespace = $input->getOption('namespace');
        $withRepositories = !$input->getOption('no-repository');
        $dryRun = $input->getOption('dry-run');
        $force = $input->getOption('force');
        $generateAll = $input->getOption('all');
        $checkOnly = $input->getOption('check');
        $updateRepos = $input->getOption('update-repos');

        if ($dryRun) {
            $io->warning('Mode DRY-RUN : Aucun fichier ne sera créé');
        }

        // Mode check : afficher le statut
        if ($checkOnly) {
            return $this->checkStatus($io, $namespace);
        }

        // Mode update repos
        if ($updateRepos) {
            return $this->updateRepositories($io, $namespace, $dryRun);
        }

        // Mode génération
        if ($generateAll) {
            return $this->generateAll($io, $namespace, $withRepositories, $dryRun, $force);
        }

        // Si ni --check ni --all ni --update-repos, afficher l'aide
        $io->note('Utilisez --check pour vérifier le statut, --all pour générer ou --update-repos pour mettre à jour.');

        return Command::SUCCESS;
    }

    /**
     * Met à jour les repositories existants.
     */
    private function updateRepositories(SymfonyStyle $io, string $namespace, bool $dryRun): int
    {
        $io->section('Mise à jour des repositories');

        if ($dryRun) {
            $io->warning('Mode DRY-RUN : Aucun fichier ne sera modifié');
        }

        $results = $this->generatorService->updateRepositories($namespace, $dryRun);

        if (empty($results)) {
            $io->success('Tous les repositories sont déjà à jour ou aucun repository trouvé.');

            return Command::SUCCESS;
        }

        foreach ($results as $result) {
            $icon = match ($result['status']) {
                'updated' => $dryRun ? '📝' : '✅',
                'skipped' => '⏭️',
                default => '❓'
            };

            $io->writeln(sprintf(
                '%s <info>%s</info> : %s',
                $icon,
                $result['repository'],
                $result['message']
            ));
        }

        $io->success('Opération terminée.');

        return Command::SUCCESS;
    }

    /**
     * Affiche le statut de toutes les entités potentielles.
     */
    private function checkStatus(SymfonyStyle $io, string $namespace): int
    {
        $io->section('Statut des entités DAPLOS');

        $status = $this->generatorService->checkStatus($namespace);

        if (empty($status)) {
            $io->warning('Aucun référentiel DAPLOS disponible');

            return Command::SUCCESS;
        }

        // Créer un tableau de statut
        $table = new Table($io);
        $table->setHeaders([
            'ID',
            'Référentiel',
            'Entité',
            'Existe',
            'Repository',
            'Trait',
        ]);

        foreach ($status as $item) {
            $table->addRow([
                $item['referential_id'],
                $item['referential_name'],
                $item['entity_name'],
                $item['entity_exists'] ? '<info>✓</info>' : '<comment>✗</comment>',
                $item['repository_exists'] ? '<info>✓</info>' : '<comment>✗</comment>',
                $item['trait_name'],
            ]);
        }

        $table->render();

        // Statistiques
        $existing = count(array_filter($status, fn ($s) => $s['entity_exists']));
        $missing = count($status) - $existing;

        $io->newLine();
        $io->text([
            sprintf('<info>✓</info> %d entités existantes', $existing),
            sprintf('<comment>✗</comment> %d entités manquantes', $missing),
        ]);

        if ($missing > 0) {
            $io->note('Utilisez --all pour générer les entités manquantes');
        }

        return Command::SUCCESS;
    }

    /**
     * Génère toutes les entités.
     */
    private function generateAll(
        SymfonyStyle $io,
        string $namespace,
        bool $withRepositories,
        bool $dryRun,
        bool $force
    ): int {
        $io->section('Génération des entités');

        $io->text([
            sprintf('Namespace : <info>%s</info>', $namespace),
            sprintf('Repositories : <info>%s</info>', $withRepositories ? 'Oui' : 'Non'),
            sprintf('Force : <info>%s</info>', $force ? 'Oui' : 'Non'),
        ]);

        $io->newLine();

        // Génération
        $results = $this->generatorService->generateAllEntities(
            namespace: $namespace,
            withRepositories: $withRepositories,
            dryRun: $dryRun,
            force: $force
        );

        // Afficher les résultats
        $succeeded = [];
        $failed = [];

        foreach ($results as $result) {
            if ($result['success']) {
                $succeeded[] = $result;
                $icon = $dryRun ? '📝' : '✅';
                $io->writeln(sprintf(
                    '%s <info>%s</info> : %s',
                    $icon,
                    $result['entity_name'],
                    $result['message']
                ));
            } else {
                $failed[] = $result;
                $io->writeln(sprintf(
                    '❌ <error>%s</error> : %s',
                    $result['entity_name'],
                    $result['message']
                ));
            }
        }

        // Résumé
        $io->newLine();

        if (0 === count($succeeded)) {
            $io->error('Aucune entité générée avec succès');

            return Command::FAILURE;
        }

        $successCount = count($succeeded);
        $failureCount = count($failed);

        $io->success(sprintf(
            '%d entité%s générée%s%s',
            $successCount,
            $successCount > 1 ? 's' : '',
            $successCount > 1 ? 's' : '',
            $dryRun ? ' (simulation)' : ''
        ));

        if ($failureCount > 0) {
            $io->warning(sprintf(
                '%d échec%s (utilisez --force pour écraser les entités existantes)',
                $failureCount,
                $failureCount > 1 ? 's' : ''
            ));
        }

        // Prochaines étapes
        if (!$dryRun) {
            $io->section('Prochaines étapes');
            $io->listing([
                'Créer les migrations : php bin/console make:migration',
                'Appliquer les migrations : php bin/console doctrine:migrations:migrate',
                'Synchroniser les données : Utilisez ReferentialSyncService',
            ]);
        }

        return Command::SUCCESS;
    }
}
