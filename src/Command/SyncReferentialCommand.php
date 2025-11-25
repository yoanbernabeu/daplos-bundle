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
use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;
use YoanBernabeu\DaplosBundle\Exception\DaplosApiException;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncServiceInterface;

/**
 * Commande de synchronisation des référentiels DAPLOS avec l'entité Doctrine.
 *
 * Cette commande permet de synchroniser les données d'un ou plusieurs référentiels DAPLOS
 * avec l'entité DaplosReferential. Elle supporte :
 * - La synchronisation d'un référentiel spécifique via --type
 * - La synchronisation de tous les référentiels via --all
 * - Le mode dry-run pour simuler les changements
 *
 * @author Yoan Bernabeu
 */
#[AsCommand(
    name: 'daplos:sync',
    description: 'Synchronise les données des référentiels DAPLOS avec l\'entité Doctrine'
)]
class SyncReferentialCommand extends Command
{
    public function __construct(
        private readonly ReferentialSyncServiceInterface $syncService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'entity',
                InputArgument::OPTIONAL,
                'Nom complet de la classe de l\'entité (ex: App\\Entity\\DaplosReferential)',
                'App\\Entity\\DaplosReferential'
            )
            ->addOption(
                'type',
                't',
                InputOption::VALUE_OPTIONAL,
                'Type de référentiel à synchroniser (ex: AMENDEMENTS_DU_SOL)'
            )
            ->addOption(
                'all',
                'a',
                InputOption::VALUE_NONE,
                'Synchronise tous les référentiels'
            )
            ->addOption(
                'dry-run',
                'd',
                InputOption::VALUE_NONE,
                'Simule la synchronisation sans persister les données'
            )
            ->addOption(
                'list',
                'l',
                InputOption::VALUE_NONE,
                'Liste tous les types de référentiels disponibles'
            )
            ->setHelp(
                <<<'HELP'
                    La commande <info>daplos:sync</info> permet de synchroniser les données des référentiels 
                    DAPLOS avec l'entité DaplosReferential de votre application.

                    <info>Fonctionnalités :</info>

                      • Synchronisation d'un référentiel spécifique via --type
                      • Synchronisation de tous les référentiels via --all
                      • Mode dry-run pour simulation
                      • Statistiques détaillées des opérations
                      • Gestion transactionnelle (rollback en cas d'erreur)

                    <info>Exemples d'utilisation :</info>

                      # Lister tous les types de référentiels disponibles
                      <comment>php bin/console daplos:sync --list</comment>

                      # Synchroniser un référentiel spécifique
                      <comment>php bin/console daplos:sync --type=AMENDEMENTS_DU_SOL</comment>

                      # Synchroniser tous les référentiels
                      <comment>php bin/console daplos:sync --all</comment>

                      # Synchroniser tous les référentiels (simulation)
                      <comment>php bin/console daplos:sync --all --dry-run</comment>

                      # Utiliser une entité personnalisée
                      <comment>php bin/console daplos:sync "App\Domain\DaplosReferential" --all</comment>

                    <info>Prérequis :</info>

                      1. L'entité doit exister (générer avec daplos:generate:entity)
                      2. La table doit exister en base de données
                      3. Les migrations Doctrine doivent être appliquées

                    <info>Idempotence :</info>

                      La commande est idempotente : vous pouvez l'exécuter plusieurs fois sans créer 
                      de doublons. Les entités existantes sont mises à jour, les nouvelles sont créées.

                    HELP
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Synchronisation des référentiels DAPLOS');

        // Option --list : afficher tous les types disponibles
        if ($input->getOption('list')) {
            return $this->listReferentialTypes($io);
        }

        $entityClass = $input->getArgument('entity');
        $typeName = $input->getOption('type');
        $syncAll = $input->getOption('all');
        $dryRun = $input->getOption('dry-run');

        if ($dryRun) {
            $io->warning('Mode DRY-RUN : Aucune donnée ne sera persistée');
        }

        // Vérifier que l'entité existe
        if (!class_exists($entityClass)) {
            $io->error(sprintf('La classe %s n\'existe pas', $entityClass));
            $io->note('Générez l\'entité avec : php bin/console daplos:generate:entity');

            return Command::FAILURE;
        }

        // Synchroniser un type spécifique
        if ($typeName) {
            return $this->syncSingleType($io, $entityClass, $typeName, $dryRun);
        }

        // Synchroniser tous les référentiels
        if ($syncAll) {
            return $this->syncAllTypes($io, $entityClass, $dryRun);
        }

        // Aucune option spécifiée
        $io->error('Vous devez spécifier --type=TYPE ou --all');
        $io->note('Utilisez --list pour voir tous les types disponibles');

        return Command::INVALID;
    }

    /**
     * Liste tous les types de référentiels disponibles.
     */
    private function listReferentialTypes(SymfonyStyle $io): int
    {
        $io->section('Types de référentiels disponibles');

        $table = new Table($io);
        $table->setHeaders(['Type (--type)', 'ID', 'Libellé']);

        foreach (DaplosReferentialType::cases() as $type) {
            $table->addRow([
                $type->name,
                $type->getId(),
                $type->getLabel(),
            ]);
        }

        $table->render();

        $io->newLine();
        $io->text(sprintf('<info>%d</info> types de référentiels disponibles', count(DaplosReferentialType::cases())));

        return Command::SUCCESS;
    }

    /**
     * Synchronise un seul type de référentiel.
     */
    private function syncSingleType(
        SymfonyStyle $io,
        string $entityClass,
        string $typeName,
        bool $dryRun
    ): int {
        // Trouver le type par son nom
        $type = null;
        foreach (DaplosReferentialType::cases() as $case) {
            if ($case->name === $typeName || $case->value === $typeName) {
                $type = $case;

                break;
            }
        }

        if (!$type) {
            $io->error(sprintf('Type de référentiel inconnu : %s', $typeName));
            $io->note('Utilisez --list pour voir tous les types disponibles');

            return Command::FAILURE;
        }

        $io->section(sprintf('Synchronisation : %s', $type->getLabel()));

        $io->definitionList(
            ['Type' => $type->name],
            ['ID API' => $type->getId()],
            ['Repository Code' => $type->getRepositoryCode()],
        );

        if ($dryRun) {
            // En mode dry-run, on récupère juste les infos
            try {
                $referentialData = $this->syncService->getReferentialDetails($type->getId());
                $io->success(sprintf(
                    '[DRY-RUN] %d items seraient synchronisés',
                    count($referentialData['references'])
                ));
            } catch (DaplosApiException $e) {
                $io->error(sprintf('Erreur API : %s', $e->getMessage()));

                return Command::FAILURE;
            }

            return Command::SUCCESS;
        }

        try {
            $stats = $this->syncService->syncReferential($entityClass, $type);
            $this->displayStats($io, $stats);
            $io->success('Synchronisation terminée avec succès !');

            return Command::SUCCESS;
        } catch (DaplosApiException $e) {
            $io->error(sprintf('Erreur lors de la synchronisation : %s', $e->getMessage()));

            return Command::FAILURE;
        }
    }

    /**
     * Synchronise tous les types de référentiels.
     */
    private function syncAllTypes(
        SymfonyStyle $io,
        string $entityClass,
        bool $dryRun
    ): int {
        $io->section('Synchronisation de tous les référentiels');

        $types = DaplosReferentialType::cases();
        $io->text(sprintf('<info>%d</info> types de référentiels à synchroniser', count($types)));
        $io->newLine();

        if ($dryRun) {
            $io->warning('Mode DRY-RUN : simulation uniquement');

            $totalItems = 0;
            foreach ($types as $type) {
                try {
                    $referentialData = $this->syncService->getReferentialDetails($type->getId());
                    $count = count($referentialData['references']);
                    $totalItems += $count;
                    $io->writeln(sprintf('  📝 %s : %d items', $type->getLabel(), $count));
                } catch (DaplosApiException $e) {
                    $io->writeln(sprintf('  ❌ %s : Erreur - %s', $type->getLabel(), $e->getMessage()));
                }
            }

            $io->newLine();
            $io->success(sprintf('[DRY-RUN] %d items seraient synchronisés au total', $totalItems));

            return Command::SUCCESS;
        }

        // Synchronisation réelle
        $results = [];
        $errors = [];
        $progressBar = $io->createProgressBar(count($types));
        $progressBar->start();

        foreach ($types as $type) {
            try {
                $stats = $this->syncService->syncReferential($entityClass, $type);
                $results[] = [
                    'type' => $type,
                    'stats' => $stats,
                ];
            } catch (DaplosApiException $e) {
                $errors[] = [
                    'type' => $type,
                    'error' => $e->getMessage(),
                ];
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $io->newLine(2);

        // Afficher le résumé
        $this->displaySummary($io, $results, $errors);

        if (!empty($errors)) {
            return Command::FAILURE;
        }

        $io->success('Synchronisation globale terminée avec succès !');

        return Command::SUCCESS;
    }

    /**
     * Affiche les statistiques de synchronisation.
     *
     * @param array{created: int, updated: int, total: int} $stats
     */
    private function displayStats(SymfonyStyle $io, array $stats): void
    {
        $io->section('Résultats de la synchronisation');

        $createdPercent = $stats['total'] > 0 ? round(($stats['created'] / $stats['total']) * 100, 1) : 0;
        $updatedPercent = $stats['total'] > 0 ? round(($stats['updated'] / $stats['total']) * 100, 1) : 0;

        $io->definitionList(
            ['Total d\'items traités' => sprintf('<info>%d</info>', $stats['total'])],
            ['Créés' => sprintf('<fg=green>%d</> (<comment>%s%%</comment>)', $stats['created'], $createdPercent)],
            ['Mis à jour' => sprintf('<fg=blue>%d</> (<comment>%s%%</comment>)', $stats['updated'], $updatedPercent)]
        );
    }

    /**
     * Affiche le résumé de la synchronisation globale.
     *
     * @param array<array{type: DaplosReferentialType, stats: array{created: int, updated: int, total: int}}> $results
     * @param array<array{type: DaplosReferentialType, error: string}>                                        $errors
     */
    private function displaySummary(SymfonyStyle $io, array $results, array $errors): void
    {
        $io->section('Résumé de la synchronisation');

        $totalCreated = 0;
        $totalUpdated = 0;
        $totalItems = 0;

        $table = new Table($io);
        $table->setHeaders(['Type', 'Créés', 'Mis à jour', 'Total']);

        foreach ($results as $result) {
            $stats = $result['stats'];
            $totalCreated += $stats['created'];
            $totalUpdated += $stats['updated'];
            $totalItems += $stats['total'];

            $table->addRow([
                $result['type']->getLabel(),
                sprintf('<fg=green>%d</>', $stats['created']),
                sprintf('<fg=blue>%d</>', $stats['updated']),
                $stats['total'],
            ]);
        }

        $table->render();

        $io->newLine();
        $io->definitionList(
            ['Types synchronisés' => sprintf('<info>%d</info>', count($results))],
            ['Total d\'items' => sprintf('<info>%d</info>', $totalItems)],
            ['Total créés' => sprintf('<fg=green>%d</>', $totalCreated)],
            ['Total mis à jour' => sprintf('<fg=blue>%d</>', $totalUpdated)],
            ['Erreurs' => sprintf('<fg=red>%d</>', count($errors))]
        );

        if (!empty($errors)) {
            $io->warning('Des erreurs se sont produites :');
            foreach ($errors as $error) {
                $io->writeln(sprintf('  • <error>%s</error> : %s', $error['type']->getLabel(), $error['error']));
            }
        }
    }
}
