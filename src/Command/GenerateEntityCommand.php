<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use YoanBernabeu\DaplosBundle\Service\EntityGeneratorServiceInterface;

#[AsCommand(
    name: 'daplos:generate:entity',
    description: 'Génère l\'entité DaplosReferential et son repository'
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
                'Namespace de l\'entité à générer',
                'App\\Entity'
            )
            ->addOption(
                'no-repository',
                null,
                InputOption::VALUE_NONE,
                'Ne pas générer le repository'
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
                'Force la recréation de l\'entité existante'
            )
            ->addOption(
                'check',
                'c',
                InputOption::VALUE_NONE,
                'Vérifie le statut de l\'entité sans la générer'
            )
            ->setHelp(
                <<<'HELP'
                    Cette commande génère automatiquement l'entité DaplosReferential et son repository
                    pour stocker tous les référentiels DAPLOS dans une seule table.
                    
                    <info>Exemples d'utilisation :</info>
                    
                      # Vérifier le statut de l'entité
                      <comment>php bin/console daplos:generate:entity --check</comment>

                      # Générer l'entité et le repository
                      <comment>php bin/console daplos:generate:entity</comment>

                      # Simuler la génération (dry-run)
                      <comment>php bin/console daplos:generate:entity --dry-run</comment>

                      # Générer dans un namespace personnalisé
                      <comment>php bin/console daplos:generate:entity --namespace="App\Domain\Daplos"</comment>

                      # Générer sans repository
                      <comment>php bin/console daplos:generate:entity --no-repository</comment>

                      # Force la recréation de l'entité existante
                      <comment>php bin/console daplos:generate:entity --force</comment>

                    <info>Architecture :</info>

                      Cette commande génère une seule entité DaplosReferential qui stocke
                      tous les référentiels DAPLOS. Le champ referentialType (enum) permet
                      de discriminer les différents types de référentiels.

                    HELP
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Générateur d\'entité DAPLOS');

        $namespace = $input->getOption('namespace');
        $withRepository = !$input->getOption('no-repository');
        $dryRun = $input->getOption('dry-run');
        $force = $input->getOption('force');
        $checkOnly = $input->getOption('check');

        if ($dryRun) {
            $io->warning('Mode DRY-RUN : Aucun fichier ne sera créé');
        }

        // Mode check : afficher le statut
        if ($checkOnly) {
            return $this->checkStatus($io, $namespace);
        }

        // Mode génération
        return $this->generate($io, $namespace, $withRepository, $dryRun, $force);
    }

    /**
     * Affiche le statut de l'entité.
     */
    private function checkStatus(SymfonyStyle $io, string $namespace): int
    {
        $io->section('Statut de l\'entité DaplosReferential');

        $status = $this->generatorService->checkStatus($namespace);

        $io->definitionList(
            ['Namespace' => $namespace],
            ['Entité' => $status['entity_exists'] ? '<info>✓ Existe</info>' : '<comment>✗ Non générée</comment>'],
            ['Repository' => $status['repository_exists'] ? '<info>✓ Existe</info>' : '<comment>✗ Non généré</comment>'],
            ['Chemin entité' => $status['entity_path']],
            ['Chemin repository' => $status['repository_path']],
        );

        if (!$status['entity_exists']) {
            $io->note('Utilisez la commande sans --check pour générer l\'entité');
        }

        return Command::SUCCESS;
    }

    /**
     * Génère l'entité et le repository.
     */
    private function generate(
        SymfonyStyle $io,
        string $namespace,
        bool $withRepository,
        bool $dryRun,
        bool $force
    ): int {
        $io->section('Génération de l\'entité');

        $io->text([
            sprintf('Namespace : <info>%s</info>', $namespace),
            sprintf('Repository : <info>%s</info>', $withRepository ? 'Oui' : 'Non'),
            sprintf('Force : <info>%s</info>', $force ? 'Oui' : 'Non'),
        ]);

        $io->newLine();

        // Génération
        $result = $this->generatorService->generateEntity(
            namespace: $namespace,
            withRepository: $withRepository,
            dryRun: $dryRun,
            force: $force
        );

        if ($result['success']) {
            $icon = $dryRun ? '📝' : '✅';
            $io->writeln(sprintf('%s %s', $icon, $result['message']));

            if ($result['entity_path']) {
                $io->writeln(sprintf('   Entité : <info>%s</info>', $result['entity_path']));
            }
            if ($result['repository_path']) {
                $io->writeln(sprintf('   Repository : <info>%s</info>', $result['repository_path']));
            }

            $io->newLine();
            $io->success($dryRun ? 'Simulation terminée' : 'Génération terminée avec succès');

            // Prochaines étapes
            if (!$dryRun) {
                $io->section('Prochaines étapes');
                $io->listing([
                    'Créer la migration : php bin/console make:migration',
                    'Appliquer la migration : php bin/console doctrine:migrations:migrate',
                    'Synchroniser les données : php bin/console daplos:sync --all',
                ]);
            }

            return Command::SUCCESS;
        }

        $io->error($result['message']);

        return Command::FAILURE;
    }
}
