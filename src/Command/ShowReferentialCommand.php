<?php

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
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncServiceInterface;

#[AsCommand(
    name: 'daplos:referentials:show',
    description: 'Affiche les détails d\'un référentiel DAPLOS spécifique'
)]
class ShowReferentialCommand extends Command
{
    public function __construct(
        private readonly ReferentialSyncServiceInterface $syncService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'ID du référentiel')
            ->addOption('limit', 'l', InputOption::VALUE_OPTIONAL, 'Nombre maximum d\'items à afficher', 20)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $referentialId = (int) $input->getArgument('id');
        $limit = (int) $input->getOption('limit');

        try {
            $data = $this->syncService->getReferentialDetails($referentialId);
            $referential = $data['referential'];
            $references = $data['references'];

            $io->title(sprintf('Référentiel: %s', $referential['name']));

            $io->section('Informations générales');
            $io->definitionList(
                ['ID' => $referential['id']],
                ['Nom' => $referential['name']],
                ['Repository Code' => $referential['repository_code']],
                ['Nombre total d\'items' => count($references)]
            );

            if (!empty($references)) {
                $io->section(sprintf('Items (affichage des %d premiers)', min($limit, count($references))));

                $table = new Table($output);
                $table->setHeaders(['ID', 'Title', 'Reference Code']);

                $displayed = 0;
                foreach ($references as $ref) {
                    if ($displayed >= $limit) {
                        break;
                    }
                    $table->addRow([
                        $ref['id'],
                        $ref['title'],
                        $ref['reference_code'],
                    ]);
                    ++$displayed;
                }

                $table->render();

                if (count($references) > $limit) {
                    $io->note(sprintf('... et %d items supplémentaires (utilisez --limit pour en afficher plus)', count($references) - $limit));
                }
            } else {
                $io->warning('Ce référentiel ne contient aucun item');
            }
        } catch (DaplosApiException $e) {
            $io->error('Erreur lors de la récupération du référentiel : '.$e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
