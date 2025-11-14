<?php

namespace YoanBernabeu\DaplosBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use YoanBernabeu\DaplosBundle\Exception\DaplosApiException;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncServiceInterface;

#[AsCommand(
    name: 'daplos:referentials:list',
    description: 'Liste tous les référentiels DAPLOS disponibles'
)]
class ListReferentialsCommand extends Command
{
    public function __construct(
        private readonly ReferentialSyncServiceInterface $syncService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Référentiels DAPLOS disponibles');

        try {
            $referentials = $this->syncService->getAvailableReferentials();

            if (empty($referentials)) {
                $io->warning('Aucun référentiel trouvé');

                return Command::SUCCESS;
            }

            $table = new Table($output);
            $table->setHeaders(['ID', 'Nom', 'Repository Code', 'Nombre d\'items']);

            foreach ($referentials as $ref) {
                $table->addRow([
                    $ref['id'],
                    $ref['name'],
                    $ref['repository_code'],
                    $ref['count'],
                ]);
            }

            $table->render();

            $io->success(sprintf('Total: %d référentiels disponibles', count($referentials)));
        } catch (DaplosApiException $e) {
            $io->error('Erreur lors de la récupération des référentiels : '.$e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
