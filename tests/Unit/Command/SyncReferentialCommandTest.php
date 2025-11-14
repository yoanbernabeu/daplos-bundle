<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use YoanBernabeu\DaplosBundle\Command\SyncReferentialCommand;
use YoanBernabeu\DaplosBundle\Exception\DaplosApiException;
use YoanBernabeu\DaplosBundle\Service\EntityGeneratorServiceInterface;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncServiceInterface;

/**
 * Tests unitaires pour la commande de synchronisation.
 *
 * Couvre les cas suivants :
 * - Synchronisation réussie avec statistiques
 * - Mode dry-run
 * - Gestion des erreurs API
 * - Gestion des arguments manquants
 * - Classe d'entité inexistante
 * - Affichage détaillé
 */
class SyncReferentialCommandTest extends TestCase
{
    private ReferentialSyncServiceInterface $syncService;
    private EntityGeneratorServiceInterface $entityGenerator;
    private SyncReferentialCommand $command;
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $this->syncService = $this->createMock(ReferentialSyncServiceInterface::class);
        $this->entityGenerator = $this->createMock(EntityGeneratorServiceInterface::class);
        $this->command = new SyncReferentialCommand($this->syncService, $this->entityGenerator);
        $this->commandTester = new CommandTester($this->command);
    }

    public function testCommandIsProperlyConfigured(): void
    {
        $this->assertEquals('daplos:sync', $this->command->getName());
        $this->assertStringContainsString('Synchronise les données', $this->command->getDescription());
    }

    public function testExecuteWithMissingArguments(): void
    {
        $exitCode = $this->commandTester->execute([]);

        $this->assertEquals(Command::INVALID, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Vous devez spécifier l\'entité et l\'ID du référentiel', $output);
    }

    public function testExecuteWithMissingEntity(): void
    {
        $exitCode = $this->commandTester->execute([
            'referential-id' => 611,
        ]);

        $this->assertEquals(Command::INVALID, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Vous devez spécifier l\'entité et l\'ID du référentiel', $output);
    }

    public function testExecuteWithMissingReferentialId(): void
    {
        $exitCode = $this->commandTester->execute([
            'entity' => 'App\\Entity\\Culture',
        ]);

        $this->assertEquals(Command::INVALID, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Vous devez spécifier l\'entité et l\'ID du référentiel', $output);
    }

    public function testExecuteWithNonExistentEntityClass(): void
    {
        $exitCode = $this->commandTester->execute([
            'entity' => 'App\\Entity\\NonExistent',
            'referential-id' => 611,
        ]);

        $this->assertEquals(Command::FAILURE, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('n\'existe pas', $output);
    }

    public function testExecuteSuccessfully(): void
    {
        $referentialData = [
            'referential' => [
                'id' => 611,
                'name' => 'Cultures',
                'repository_code' => 'List_BotanicalSpecies_CodeType',
            ],
            'references' => array_fill(0, 100, ['id' => 1, 'title' => 'Test', 'reference_code' => 'TST']),
        ];

        $stats = [
            'created' => 30,
            'updated' => 70,
            'total' => 100,
        ];

        $this->syncService->expects($this->once())
            ->method('getReferentialDetails')
            ->with(611)
            ->willReturn($referentialData);

        $this->syncService->expects($this->once())
            ->method('syncReferential')
            ->with(
                $this->equalTo(\stdClass::class),
                $this->equalTo(611)
            )
            ->willReturn($stats);

        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class, // Utiliser stdClass car elle existe toujours
            'referential-id' => 611,
        ]);

        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Synchronisation terminée avec succès', $output);
        $this->assertStringContainsString('30', $output); // Créées
        $this->assertStringContainsString('70', $output); // Mises à jour
        $this->assertStringContainsString('100', $output); // Total
    }

    public function testExecuteWithShowDetailsOption(): void
    {
        $referentialData = [
            'referential' => [
                'id' => 611,
                'name' => 'Cultures',
                'repository_code' => 'List_BotanicalSpecies_CodeType',
            ],
            'references' => array_fill(0, 50, ['id' => 1, 'title' => 'Test', 'reference_code' => 'TST']),
        ];

        $stats = [
            'created' => 10,
            'updated' => 40,
            'total' => 50,
        ];

        $this->syncService->expects($this->once())
            ->method('getReferentialDetails')
            ->with(611)
            ->willReturn($referentialData);

        $this->syncService->expects($this->once())
            ->method('syncReferential')
            ->willReturn($stats);

        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class,
            'referential-id' => 611,
            '--show-details' => true,
        ]);

        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Cultures', $output);
        $this->assertStringContainsString('List_BotanicalSpecies_CodeType', $output);
        $this->assertStringContainsString('50', $output);
    }

    public function testExecuteWithDryRunOption(): void
    {
        $referentialData = [
            'referential' => [
                'id' => 611,
                'name' => 'Cultures',
                'repository_code' => 'List_BotanicalSpecies_CodeType',
            ],
            'references' => array_fill(0, 10, ['id' => 1, 'title' => 'Test', 'reference_code' => 'TST']),
        ];

        $this->syncService->expects($this->once())
            ->method('getReferentialDetails')
            ->with(611)
            ->willReturn($referentialData);

        // En mode dry-run, syncReferential ne doit PAS être appelé
        $this->syncService->expects($this->never())
            ->method('syncReferential');

        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class,
            'referential-id' => 611,
            '--dry-run' => true,
        ]);

        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Mode DRY-RUN', $output);
        $this->assertStringContainsString('Aucune donnée ne sera persistée', $output);
        $this->assertStringContainsString('Résultats de la simulation', $output);
        $this->assertStringContainsString('sans --dry-run pour persister les données', $output);
    }

    public function testExecuteWithApiExceptionOnGetReferential(): void
    {
        $this->syncService->expects($this->once())
            ->method('getReferentialDetails')
            ->with(611)
            ->willThrowException(new DaplosApiException('API connection failed'));

        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class,
            'referential-id' => 611,
        ]);

        $this->assertEquals(Command::FAILURE, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Erreur lors de la récupération du référentiel', $output);
        $this->assertStringContainsString('API connection failed', $output);
    }

    public function testExecuteWithApiExceptionOnSync(): void
    {
        $referentialData = [
            'referential' => [
                'id' => 611,
                'name' => 'Cultures',
                'repository_code' => 'List_BotanicalSpecies_CodeType',
            ],
            'references' => array_fill(0, 10, ['id' => 1, 'title' => 'Test', 'reference_code' => 'TST']),
        ];

        $this->syncService->expects($this->once())
            ->method('getReferentialDetails')
            ->with(611)
            ->willReturn($referentialData);

        $this->syncService->expects($this->once())
            ->method('syncReferential')
            ->willThrowException(new DaplosApiException('Sync failed'));

        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class,
            'referential-id' => 611,
        ]);

        $this->assertEquals(Command::FAILURE, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Erreur lors de la synchronisation', $output);
        $this->assertStringContainsString('Sync failed', $output);
    }

    public function testExecuteWithUnexpectedException(): void
    {
        $referentialData = [
            'referential' => [
                'id' => 611,
                'name' => 'Cultures',
                'repository_code' => 'List_BotanicalSpecies_CodeType',
            ],
            'references' => array_fill(0, 10, ['id' => 1, 'title' => 'Test', 'reference_code' => 'TST']),
        ];

        $this->syncService->expects($this->once())
            ->method('getReferentialDetails')
            ->with(611)
            ->willReturn($referentialData);

        $this->syncService->expects($this->once())
            ->method('syncReferential')
            ->willThrowException(new \RuntimeException('Unexpected error'));

        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class,
            'referential-id' => 611,
        ]);

        $this->assertEquals(Command::FAILURE, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Erreur inattendue', $output);
        $this->assertStringContainsString('Unexpected error', $output);
    }

    public function testExecuteWithZeroItems(): void
    {
        $referentialData = [
            'referential' => [
                'id' => 611,
                'name' => 'Empty Referential',
                'repository_code' => 'EMPTY',
            ],
            'references' => [],
        ];

        $stats = [
            'created' => 0,
            'updated' => 0,
            'total' => 0,
        ];

        $this->syncService->expects($this->once())
            ->method('getReferentialDetails')
            ->with(611)
            ->willReturn($referentialData);

        $this->syncService->expects($this->once())
            ->method('syncReferential')
            ->willReturn($stats);

        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class,
            'referential-id' => 611,
        ]);

        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Synchronisation terminée avec succès', $output);
        $this->assertStringContainsString('0', $output); // Total 0
    }

    public function testDisplayStatsShowsCorrectPercentages(): void
    {
        $referentialData = [
            'referential' => [
                'id' => 611,
                'name' => 'Cultures',
                'repository_code' => 'List_BotanicalSpecies_CodeType',
            ],
            'references' => array_fill(0, 200, ['id' => 1, 'title' => 'Test', 'reference_code' => 'TST']),
        ];

        $stats = [
            'created' => 50,  // 25%
            'updated' => 150, // 75%
            'total' => 200,
        ];

        $this->syncService->expects($this->once())
            ->method('getReferentialDetails')
            ->willReturn($referentialData);

        $this->syncService->expects($this->once())
            ->method('syncReferential')
            ->willReturn($stats);

        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class,
            'referential-id' => 611,
        ]);

        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('25', $output);  // 25%
        $this->assertStringContainsString('75', $output);  // 75%
    }

    public function testExecuteWithAllOption(): void
    {
        $status = [
            [
                'referential_id' => 611,
                'referential_name' => 'Cultures',
                'entity_name' => 'Cultures',
                'entity_exists' => true,
            ],
            [
                'referential_id' => 633,
                'referential_name' => 'Amendements',
                'entity_name' => 'Amendements',
                'entity_exists' => true,
            ],
        ];

        $stats1 = ['created' => 20, 'updated' => 30, 'total' => 50];
        $stats2 = ['created' => 10, 'updated' => 20, 'total' => 30];

        $this->entityGenerator->expects($this->once())
            ->method('checkStatus')
            ->with('App\\Entity\\Daplos')
            ->willReturn($status);

        // getReferentialDetails n'est appelé qu'en mode dry-run
        $this->syncService->expects($this->never())
            ->method('getReferentialDetails');

        $this->syncService->expects($this->exactly(2))
            ->method('syncReferential')
            ->willReturnCallback(function ($entityClass, $id) use ($stats1, $stats2) {
                return match ($id) {
                    611 => $stats1,
                    633 => $stats2,
                    default => throw new \RuntimeException('Unexpected referential ID'),
                };
            });

        $exitCode = $this->commandTester->execute(
            ['--all' => true],
            ['interactive' => false] // Désactiver le mode interactif pour éviter la confirmation
        );

        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Synchronisation globale terminée avec succès', $output);
        $this->assertStringContainsString('Cultures', $output);
        $this->assertStringContainsString('Amendements', $output);
        $this->assertStringContainsString('20', $output); // Stats entité 1 créées
        $this->assertStringContainsString('30', $output); // Stats entité 1 mises à jour ou total entité 2
    }

    public function testExecuteWithAllOptionDryRun(): void
    {
        $status = [
            [
                'referential_id' => 611,
                'referential_name' => 'Cultures',
                'entity_name' => 'Cultures',
                'entity_exists' => true,
            ],
        ];

        $referentialData = [
            'referential' => ['id' => 611, 'name' => 'Cultures', 'repository_code' => 'Test'],
            'references' => array_fill(0, 20, ['id' => 1, 'title' => 'Test', 'reference_code' => 'TST']),
        ];

        $this->entityGenerator->expects($this->once())
            ->method('checkStatus')
            ->willReturn($status);

        $this->syncService->expects($this->once())
            ->method('getReferentialDetails')
            ->with(611)
            ->willReturn($referentialData);

        // En mode dry-run, syncReferential ne doit PAS être appelé
        $this->syncService->expects($this->never())
            ->method('syncReferential');

        $exitCode = $this->commandTester->execute(['--all' => true, '--dry-run' => true]);

        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Mode DRY-RUN', $output);
        $this->assertStringContainsString('Résumé de la simulation', $output);
    }

    public function testExecuteWithAllOptionNoEntitiesFound(): void
    {
        $this->entityGenerator->expects($this->once())
            ->method('checkStatus')
            ->willReturn([]);

        $exitCode = $this->commandTester->execute(['--all' => true]);

        $this->assertEquals(Command::FAILURE, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Aucune entité trouvée', $output);
    }

    public function testExecuteWithAllOptionWithErrors(): void
    {
        $status = [
            [
                'referential_id' => 611,
                'referential_name' => 'Cultures',
                'entity_name' => 'Cultures',
                'entity_exists' => true,
            ],
            [
                'referential_id' => 633,
                'referential_name' => 'Amendements',
                'entity_name' => 'Amendements',
                'entity_exists' => true,
            ],
        ];

        $stats1 = ['created' => 5, 'updated' => 5, 'total' => 10];

        $this->entityGenerator->expects($this->once())
            ->method('checkStatus')
            ->willReturn($status);

        // getReferentialDetails n'est appelé qu'en mode dry-run
        $this->syncService->expects($this->never())
            ->method('getReferentialDetails');

        $this->syncService->expects($this->exactly(2))
            ->method('syncReferential')
            ->willReturnCallback(function ($entityClass, $id) use ($stats1) {
                if (611 === $id) {
                    return $stats1;
                }

                throw new DaplosApiException('Sync failed for 633');
            });

        $exitCode = $this->commandTester->execute(
            ['--all' => true],
            ['interactive' => false]
        );

        $this->assertEquals(Command::FAILURE, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Des erreurs se sont produites', $output);
        $this->assertStringContainsString('Amendements', $output);
    }

    public function testExecuteWithAllOptionCustomNamespace(): void
    {
        $status = [
            [
                'referential_id' => 611,
                'referential_name' => 'Cultures',
                'entity_name' => 'Cultures',
                'entity_exists' => true,
            ],
        ];

        $stats = ['created' => 5, 'updated' => 5, 'total' => 10];

        $this->entityGenerator->expects($this->once())
            ->method('checkStatus')
            ->with('App\\Domain\\Agriculture')
            ->willReturn($status);

        // getReferentialDetails n'est appelé qu'en mode dry-run
        $this->syncService->expects($this->never())
            ->method('getReferentialDetails');

        $this->syncService->expects($this->once())
            ->method('syncReferential')
            ->with(
                $this->equalTo('App\\Domain\\Agriculture\\Cultures'),
                $this->equalTo(611)
            )
            ->willReturn($stats);

        $exitCode = $this->commandTester->execute(
            [
                '--all' => true,
                '--namespace' => 'App\\Domain\\Agriculture',
            ],
            ['interactive' => false]
        );

        $this->assertEquals(Command::SUCCESS, $exitCode);
    }
}
