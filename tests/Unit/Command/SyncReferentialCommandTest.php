<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use YoanBernabeu\DaplosBundle\Command\SyncReferentialCommand;
use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;
use YoanBernabeu\DaplosBundle\Exception\DaplosApiException;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncServiceInterface;

/**
 * Tests unitaires pour la commande de synchronisation.
 *
 * Couvre les cas suivants :
 * - Synchronisation réussie avec statistiques
 * - Mode dry-run
 * - Gestion des erreurs API
 * - Liste des types de référentiels
 * - Synchronisation de tous les référentiels
 */
class SyncReferentialCommandTest extends TestCase
{
    private ReferentialSyncServiceInterface $syncService;
    private SyncReferentialCommand $command;
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $this->syncService = $this->createMock(ReferentialSyncServiceInterface::class);
        $this->command = new SyncReferentialCommand($this->syncService);
        $this->commandTester = new CommandTester($this->command);
    }

    public function testCommandIsProperlyConfigured(): void
    {
        $this->assertEquals('daplos:sync', $this->command->getName());
        $this->assertStringContainsString('Synchronise les données', $this->command->getDescription());

        $definition = $this->command->getDefinition();
        $this->assertTrue($definition->hasOption('type'));
        $this->assertTrue($definition->hasOption('all'));
        $this->assertTrue($definition->hasOption('dry-run'));
        $this->assertTrue($definition->hasOption('list'));
    }

    public function testListOption(): void
    {
        // Act
        $exitCode = $this->commandTester->execute(['--list' => true]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Types de référentiels disponibles', $output);
        $this->assertStringContainsString('AMENDEMENTS_DU_SOL', $output);
        $this->assertStringContainsString(count(DaplosReferentialType::cases()).' types', $output);
    }

    public function testExecuteWithMissingOptions(): void
    {
        // Act - L'entité par défaut existe (stdClass), mais ni --type ni --all n'est fourni
        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class,
        ]);

        // Assert
        $this->assertEquals(Command::INVALID, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('--type=TYPE ou --all', $output);
    }

    public function testExecuteWithNonExistentEntityClass(): void
    {
        // Act
        $exitCode = $this->commandTester->execute([
            'entity' => 'App\\Entity\\NonExistent',
            '--type' => 'AMENDEMENTS_DU_SOL',
        ]);

        // Assert
        $this->assertEquals(Command::FAILURE, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('n\'existe pas', $output);
    }

    public function testExecuteWithInvalidType(): void
    {
        // Act
        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class,
            '--type' => 'INVALID_TYPE',
        ]);

        // Assert
        $this->assertEquals(Command::FAILURE, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Type de référentiel inconnu', $output);
    }

    public function testExecuteWithTypeSuccessfully(): void
    {
        // Arrange
        $stats = [
            'created' => 2,
            'updated' => 1,
            'total' => 3,
        ];

        $this->syncService->expects($this->once())
            ->method('syncReferential')
            ->with(
                $this->equalTo(\stdClass::class),
                $this->equalTo(DaplosReferentialType::AMENDEMENTS_DU_SOL)
            )
            ->willReturn($stats);

        // Act
        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class,
            '--type' => 'AMENDEMENTS_DU_SOL',
        ]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Synchronisation terminée avec succès', $output);
        $this->assertStringContainsString('2', $output); // Créés
        $this->assertStringContainsString('1', $output); // Mis à jour
        $this->assertStringContainsString('3', $output); // Total
    }

    public function testExecuteWithTypeDryRun(): void
    {
        // Arrange
        $referentialData = [
            'referential' => ['id' => 633, 'name' => 'Amendements du sol', 'repository_code' => 'Test'],
            'references' => array_fill(0, 10, ['id' => 1, 'title' => 'Test', 'reference_code' => 'TST']),
        ];

        $this->syncService->expects($this->once())
            ->method('getReferentialDetails')
            ->with(633)
            ->willReturn($referentialData);

        // En mode dry-run, syncReferential ne doit PAS être appelé
        $this->syncService->expects($this->never())
            ->method('syncReferential');

        // Act
        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class,
            '--type' => 'AMENDEMENTS_DU_SOL',
            '--dry-run' => true,
        ]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Mode DRY-RUN', $output);
        $this->assertStringContainsString('10 items seraient synchronisés', $output);
    }

    public function testExecuteWithApiException(): void
    {
        // Arrange
        $this->syncService->expects($this->once())
            ->method('syncReferential')
            ->willThrowException(new DaplosApiException('API connection failed'));

        // Act
        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class,
            '--type' => 'AMENDEMENTS_DU_SOL',
        ]);

        // Assert
        $this->assertEquals(Command::FAILURE, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Erreur lors de la synchronisation', $output);
        $this->assertStringContainsString('API connection failed', $output);
    }

    public function testExecuteWithAllOption(): void
    {
        // Arrange - Le service sera appelé 53 fois (une fois par type)
        $stats = ['created' => 1, 'updated' => 0, 'total' => 1];

        $this->syncService->expects($this->exactly(count(DaplosReferentialType::cases())))
            ->method('syncReferential')
            ->willReturn($stats);

        // Act
        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class,
            '--all' => true,
        ]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Synchronisation globale terminée avec succès', $output);
    }

    public function testExecuteWithAllOptionDryRun(): void
    {
        // Arrange
        $referentialData = [
            'referential' => ['id' => 633, 'name' => 'Test', 'repository_code' => 'Test'],
            'references' => array_fill(0, 5, ['id' => 1, 'title' => 'Test', 'reference_code' => 'TST']),
        ];

        $this->syncService->expects($this->exactly(count(DaplosReferentialType::cases())))
            ->method('getReferentialDetails')
            ->willReturn($referentialData);

        // En mode dry-run, syncReferential ne doit PAS être appelé
        $this->syncService->expects($this->never())
            ->method('syncReferential');

        // Act
        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class,
            '--all' => true,
            '--dry-run' => true,
        ]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Mode DRY-RUN', $output);
    }

    public function testExecuteWithAllOptionWithErrors(): void
    {
        // Arrange - Premier type réussit, deuxième échoue
        $stats = ['created' => 1, 'updated' => 0, 'total' => 1];

        $callCount = 0;
        $this->syncService->expects($this->atLeast(2))
            ->method('syncReferential')
            ->willReturnCallback(function () use ($stats, &$callCount) {
                $callCount++;
                if ($callCount === 2) {
                    throw new DaplosApiException('Sync failed');
                }

                return $stats;
            });

        // Act
        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class,
            '--all' => true,
        ]);

        // Assert
        $this->assertEquals(Command::FAILURE, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Erreur', $output);
    }

    public function testDisplayStatsShowsCorrectPercentages(): void
    {
        // Arrange
        $stats = [
            'created' => 25,  // 25%
            'updated' => 75, // 75%
            'total' => 100,
        ];

        $this->syncService->expects($this->once())
            ->method('syncReferential')
            ->willReturn($stats);

        // Act
        $exitCode = $this->commandTester->execute([
            'entity' => \stdClass::class,
            '--type' => 'AMENDEMENTS_DU_SOL',
        ]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('25', $output);  // 25%
        $this->assertStringContainsString('75', $output);  // 75%
    }
}
