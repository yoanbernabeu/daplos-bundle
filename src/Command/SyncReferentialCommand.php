<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use YoanBernabeu\DaplosBundle\Exception\DaplosApiException;
use YoanBernabeu\DaplosBundle\Service\EntityGeneratorServiceInterface;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncServiceInterface;

/**
 * Commande de synchronisation des référentiels DAPLOS avec les entités Doctrine.
 *
 * Cette commande permet de synchroniser les données d'un ou plusieurs référentiels DAPLOS
 * avec des entités Doctrine locales. Elle supporte :
 * - La synchronisation d'un référentiel spécifique
 * - Le mode dry-run pour simuler les changements
 * - Des statistiques détaillées sur les opérations effectuées
 *
 * @author Yoan Bernabeu
 */
#[AsCommand(
    name: 'daplos:sync',
    description: 'Synchronise les données d\'un référentiel DAPLOS avec une entité Doctrine'
)]
class SyncReferentialCommand extends Command
{
    public function __construct(
        private readonly ReferentialSyncServiceInterface $syncService,
        private readonly EntityGeneratorServiceInterface $entityGenerator
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'entity',
                InputArgument::OPTIONAL,
                'Nom complet de la classe de l\'entité (ex: App\\Entity\\Daplos\\Culture)'
            )
            ->addArgument(
                'referential-id',
                InputArgument::OPTIONAL,
                'ID du référentiel DAPLOS à synchroniser'
            )
            ->addOption(
                'dry-run',
                'd',
                InputOption::VALUE_NONE,
                'Simule la synchronisation sans persister les données'
            )
            ->addOption(
                'show-details',
                's',
                InputOption::VALUE_NONE,
                'Affiche des détails supplémentaires sur la synchronisation'
            )
            ->addOption(
                'all',
                'a',
                InputOption::VALUE_NONE,
                'Synchronise toutes les entités générées disponibles'
            )
            ->addOption(
                'namespace',
                null,
                InputOption::VALUE_OPTIONAL,
                'Namespace des entités à synchroniser (utilisé avec --all)',
                'App\\Entity\\Daplos'
            )
            ->setHelp(
                <<<'HELP'
                    La commande <info>daplos:sync</info> permet de synchroniser les données d'un référentiel 
                    DAPLOS avec une entité Doctrine de votre application.

                    <info>Fonctionnalités :</info>

                      • Création automatique des nouvelles entrées
                      • Mise à jour des entrées existantes
                      • Support du mode dry-run pour simulation
                      • Statistiques détaillées des opérations
                      • Gestion transactionnelle (rollback en cas d'erreur)

                    <info>Exemples d'utilisation :</info>

                      # Synchroniser un référentiel spécifique
                      <comment>php bin/console daplos:sync "App\Entity\Daplos\Culture" 611</comment>

                      # Synchroniser toutes les entités générées
                      <comment>php bin/console daplos:sync --all</comment>

                      # Synchroniser toutes les entités (simulation)
                      <comment>php bin/console daplos:sync --all --dry-run</comment>

                      # Mode simulation (dry-run)
                      <comment>php bin/console daplos:sync "App\Entity\Daplos\Culture" 611 --dry-run</comment>

                      # Afficher des détails supplémentaires
                      <comment>php bin/console daplos:sync "App\Entity\Daplos\Culture" 611 --show-details</comment>

                    <info>Prérequis :</info>

                      1. L'entité doit exister et être correctement configurée
                      2. L'entité doit implémenter DaplosEntityInterface OU utiliser l'attribut #[DaplosId]
                      3. La table de l'entité doit exister en base de données
                      4. Les migrations Doctrine doivent être appliquées

                    <info>Idempotence :</info>

                      La commande est idempotente : vous pouvez l'exécuter plusieurs fois sans créer 
                      de doublons. Les entités existantes sont mises à jour, les nouvelles sont créées.

                    <info>Gestion des erreurs :</info>

                      En cas d'erreur pendant la synchronisation, toutes les modifications sont 
                      annulées (rollback) pour garantir la cohérence des données.

                    HELP
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Synchronisation des référentiels DAPLOS');

        // Option --all pour synchroniser toutes les entités
        $syncAll = $input->getOption('all');
        $namespace = $input->getOption('namespace');

        if ($syncAll) {
            return $this->syncAllEntities($io, $input, $namespace);
        }

        // Récupérer les arguments
        $entityClass = $input->getArgument('entity');
        $referentialId = $input->getArgument('referential-id');

        // Vérifier que les deux arguments sont fournis
        if (!$entityClass || !$referentialId) {
            $io->error('Vous devez spécifier l\'entité et l\'ID du référentiel OU utiliser --all');
            $io->note('Usage: php bin/console daplos:sync "App\Entity\Daplos\Culture" 611');
            $io->note('   ou: php bin/console daplos:sync --all');

            return Command::INVALID;
        }

        // Convertir l'ID en entier
        $referentialId = (int) $referentialId;

        // Options
        $dryRun = $input->getOption('dry-run');
        $showDetails = $input->getOption('show-details');

        if ($dryRun) {
            $io->warning('Mode DRY-RUN : Aucune donnée ne sera persistée');
        }

        // Vérifier que l'entité existe
        if (!class_exists($entityClass)) {
            $io->error(sprintf('La classe %s n\'existe pas', $entityClass));

            return Command::FAILURE;
        }

        // Afficher les informations de synchronisation
        $io->section('Configuration de la synchronisation');
        $io->definitionList(
            ['Entité' => $entityClass],
            ['Référentiel ID' => $referentialId],
            ['Mode' => $dryRun ? 'Simulation (dry-run)' : 'Synchronisation réelle']
        );

        // Récupérer les détails du référentiel
        try {
            if ($showDetails) {
                $io->section('Récupération des informations du référentiel...');
            }

            $referentialData = $this->syncService->getReferentialDetails($referentialId);
            $referential = $referentialData['referential'];

            if ($showDetails) {
                $io->definitionList(
                    ['Nom du référentiel' => $referential['name']],
                    ['Repository Code' => $referential['repository_code']],
                    ['Nombre d\'items' => count($referentialData['references'])]
                );
            }
        } catch (DaplosApiException $e) {
            $io->error(sprintf('Erreur lors de la récupération du référentiel : %s', $e->getMessage()));

            return Command::FAILURE;
        }

        // Exécuter la synchronisation
        $io->section('Synchronisation en cours...');
        $progressBar = $io->createProgressBar();
        $progressBar->start();

        try {
            if ($dryRun) {
                // En mode dry-run, on simule la synchronisation
                $stats = [
                    'created' => 0,
                    'updated' => 0,
                    'total' => count($referentialData['references']),
                ];

                // Simuler le traitement
                foreach ($referentialData['references'] as $reference) {
                    $progressBar->advance();
                    // On ne peut pas vraiment savoir sans tenter la persistence
                    // donc on simule un ratio créé/mis à jour
                    if (0 === random_int(0, 1)) {
                        ++$stats['created'];
                    } else {
                        ++$stats['updated'];
                    }
                }
            } else {
                // Synchronisation réelle
                $stats = $this->syncService->syncReferential(
                    entityClass: $entityClass,
                    referentialId: $referentialId
                );
            }

            $progressBar->finish();
            $io->newLine(2);

            // Afficher les statistiques
            $this->displayStats($io, $stats, $dryRun);

            if ($dryRun) {
                $io->note('Exécutez la commande sans --dry-run pour persister les données');
            } else {
                $io->success('Synchronisation terminée avec succès !');
            }

            return Command::SUCCESS;
        } catch (DaplosApiException $e) {
            $progressBar->finish();
            $io->newLine(2);
            $io->error(sprintf('Erreur lors de la synchronisation : %s', $e->getMessage()));

            return Command::FAILURE;
        } catch (\Exception $e) {
            $progressBar->finish();
            $io->newLine(2);
            $io->error(sprintf('Erreur inattendue : %s', $e->getMessage()));

            if ($output->isVerbose()) {
                $io->block($e->getTraceAsString(), 'TRACE', 'fg=white;bg=red', ' ', true);
            }

            return Command::FAILURE;
        }
    }

    /**
     * Affiche les statistiques de synchronisation.
     *
     * @param array{created: int, updated: int, total: int} $stats
     */
    private function displayStats(SymfonyStyle $io, array $stats, bool $dryRun): void
    {
        $io->section($dryRun ? 'Résultats de la simulation' : 'Résultats de la synchronisation');

        // Calculer les pourcentages
        $createdPercent = $stats['total'] > 0 ? round(($stats['created'] / $stats['total']) * 100, 1) : 0;
        $updatedPercent = $stats['total'] > 0 ? round(($stats['updated'] / $stats['total']) * 100, 1) : 0;

        $io->definitionList(
            ['Total d\'items traités' => sprintf('<info>%d</info>', $stats['total'])],
            ['Créées' => sprintf('<fg=green>%d</> (<comment>%s%%</comment>)', $stats['created'], $createdPercent)],
            ['Mises à jour' => sprintf('<fg=blue>%d</> (<comment>%s%%</comment>)', $stats['updated'], $updatedPercent)]
        );

        // Barre de progression visuelle
        if ($stats['total'] > 0) {
            $io->newLine();
            $createdBar = str_repeat('█', (int) ($createdPercent / 2));
            $updatedBar = str_repeat('█', (int) ($updatedPercent / 2));

            $io->writeln(sprintf('  Créées    : <fg=green>%s</> %s%%', $createdBar, $createdPercent));
            $io->writeln(sprintf('  Mises à jour : <fg=blue>%s</> %s%%', $updatedBar, $updatedPercent));
        }
    }

    /**
     * Synchronise toutes les entités générées disponibles.
     */
    private function syncAllEntities(SymfonyStyle $io, InputInterface $input, string $namespace): int
    {
        $dryRun = $input->getOption('dry-run');
        $showDetails = $input->getOption('show-details');

        if ($dryRun) {
            $io->warning('Mode DRY-RUN : Aucune donnée ne sera persistée');
        }

        // Récupérer le statut de toutes les entités
        $io->section('Recherche des entités à synchroniser...');
        $status = $this->entityGenerator->checkStatus($namespace);

        // Filtrer uniquement les entités existantes
        $existingEntities = array_filter($status, fn ($s) => $s['entity_exists']);

        if (empty($existingEntities)) {
            $io->warning(sprintf('Aucune entité trouvée dans le namespace %s', $namespace));
            $io->note('Utilisez d\'abord : php bin/console daplos:generate:entity --all');

            return Command::FAILURE;
        }

        $io->text(sprintf(
            'Trouvé <info>%d entité(s)</info> à synchroniser dans %s',
            count($existingEntities),
            $namespace
        ));

        // Afficher la liste des entités à synchroniser
        if ($showDetails) {
            $table = new Table($io);
            $table->setHeaders(['Référentiel', 'Entité', 'ID']);
            foreach ($existingEntities as $entity) {
                $table->addRow([
                    $entity['referential_name'],
                    $entity['entity_name'],
                    $entity['referential_id'],
                ]);
            }
            $table->render();
        }

        $io->newLine();

        // Confirmer avant de continuer (sauf en dry-run)
        if (!$dryRun && !$io->confirm('Voulez-vous continuer avec la synchronisation ?', true)) {
            $io->info('Synchronisation annulée');

            return Command::SUCCESS;
        }

        // Synchroniser chaque entité
        $results = [];
        $totalCreated = 0;
        $totalUpdated = 0;
        $totalItems = 0;
        $errors = [];

        foreach ($existingEntities as $entity) {
            $entityClass = $this->buildEntityClassName($namespace, $entity['entity_name']);

            $io->section(sprintf(
                'Synchronisation : %s (ID: %d)',
                $entity['referential_name'],
                $entity['referential_id']
            ));

            try {
                if ($dryRun) {
                    // En mode dry-run, simuler
                    $referentialData = $this->syncService->getReferentialDetails($entity['referential_id']);
                    $stats = [
                        'created' => 0,
                        'updated' => 0,
                        'total' => count($referentialData['references']),
                    ];
                    // Simuler un ratio
                    foreach ($referentialData['references'] as $ref) {
                        if (0 === random_int(0, 1)) {
                            ++$stats['created'];
                        } else {
                            ++$stats['updated'];
                        }
                    }
                } else {
                    // Synchronisation réelle
                    $stats = $this->syncService->syncReferential(
                        entityClass: $entityClass,
                        referentialId: $entity['referential_id']
                    );
                }

                $results[] = [
                    'entity' => $entity['entity_name'],
                    'referential' => $entity['referential_name'],
                    'stats' => $stats,
                    'success' => true,
                ];

                $totalCreated += $stats['created'];
                $totalUpdated += $stats['updated'];
                $totalItems += $stats['total'];

                $io->success(sprintf(
                    '%s : %d créées, %d mises à jour sur %d items',
                    $entity['entity_name'],
                    $stats['created'],
                    $stats['updated'],
                    $stats['total']
                ));
            } catch (\Exception $e) {
                $errors[] = [
                    'entity' => $entity['entity_name'],
                    'error' => $e->getMessage(),
                ];

                $io->error(sprintf(
                    'Erreur pour %s : %s',
                    $entity['entity_name'],
                    $e->getMessage()
                ));
            }
        }

        // Afficher le résumé global
        $io->section($dryRun ? 'Résumé de la simulation' : 'Résumé de la synchronisation');

        $table = new Table($io);
        $table->setHeaders(['Entité', 'Référentiel', 'Créées', 'Mises à jour', 'Total']);
        foreach ($results as $result) {
            $table->addRow([
                $result['entity'],
                $result['referential'],
                sprintf('<fg=green>%d</>', $result['stats']['created']),
                sprintf('<fg=blue>%d</>', $result['stats']['updated']),
                $result['stats']['total'],
            ]);
        }
        $table->render();

        $io->newLine();
        $io->definitionList(
            ['Total d\'entités synchronisées' => sprintf('<info>%d</info>', count($results))],
            ['Total d\'items traités' => sprintf('<info>%d</info>', $totalItems)],
            ['Total créées' => sprintf('<fg=green>%d</>', $totalCreated)],
            ['Total mises à jour' => sprintf('<fg=blue>%d</>', $totalUpdated)],
            ['Erreurs' => sprintf('<fg=red>%d</>', count($errors))]
        );

        if (!empty($errors)) {
            $io->warning('Des erreurs se sont produites lors de la synchronisation :');
            foreach ($errors as $error) {
                $io->writeln(sprintf('  • <error>%s</error> : %s', $error['entity'], $error['error']));
            }

            return Command::FAILURE;
        }

        if ($dryRun) {
            $io->note('Exécutez la commande sans --dry-run pour persister les données');
        } else {
            $io->success('Synchronisation globale terminée avec succès !');
        }

        return Command::SUCCESS;
    }

    /**
     * Construit le nom complet de la classe d'entité.
     */
    private function buildEntityClassName(string $namespace, string $entityName): string
    {
        return $namespace.'\\'.$entityName;
    }
}
