<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Command;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use YoanBernabeu\DaplosBundle\Command\GenerateEntityCommand;
use YoanBernabeu\DaplosBundle\Service\EntityGeneratorServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Tests unitaires pour GenerateEntityCommand
 * 
 * Tests suivant l'approche TDD avec structure AAA.
 * Couvre les cas nominaux et les cas d'erreur.
 */
class GenerateEntityCommandTest extends TestCase
{
    private EntityGeneratorServiceInterface|MockObject $generatorService;
    private GenerateEntityCommand $command;
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        // Arrange : Préparer les mocks
        $this->generatorService = $this->createMock(EntityGeneratorServiceInterface::class);
        $this->command = new GenerateEntityCommand($this->generatorService);
        $this->commandTester = new CommandTester($this->command);
    }

    /**
     * @test
     */
    public function testCommandIsProperlyConfigured(): void
    {
        // Assert
        $this->assertEquals('daplos:generate:entity', $this->command->getName());
        $this->assertStringContainsString('entités', $this->command->getDescription());
        
        $definition = $this->command->getDefinition();
        $this->assertTrue($definition->hasOption('namespace'));
        $this->assertTrue($definition->hasOption('no-repository'));
        $this->assertTrue($definition->hasOption('dry-run'));
        $this->assertTrue($definition->hasOption('force'));
        $this->assertTrue($definition->hasOption('all'));
        $this->assertTrue($definition->hasOption('check'));
    }

    /**
     * @test
     * @testdox Mode check affiche le statut de toutes les entités
     */
    public function testCheckModeDisplaysStatus(): void
    {
        // Arrange
        $status = [
            [
                'referential_name' => 'Cultures',
                'entity_name' => 'Culture',
                'entity_exists' => false,
                'repository_exists' => false,
                'referential_id' => 611,
                'trait_name' => 'CulturesTrait',
            ],
            [
                'referential_name' => 'Amendements',
                'entity_name' => 'Amendement',
                'entity_exists' => true,
                'repository_exists' => true,
                'referential_id' => 633,
                'trait_name' => 'AmendementsTrait',
            ],
        ];

        $this->generatorService
            ->expects($this->once())
            ->method('checkStatus')
            ->with('App\\Entity\\Daplos')
            ->willReturn($status);

        // Act
        $exitCode = $this->commandTester->execute(['--check' => true]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);
        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Cultures', $output);
        $this->assertStringContainsString('Amendements', $output);
        $this->assertStringContainsString('Culture', $output);
        $this->assertStringContainsString('✗', $output); // Culture n'existe pas
        $this->assertStringContainsString('✓', $output); // Amendement existe
    }

    /**
     * @test
     * @testdox Génère toutes les entités avec l'option --all
     */
    public function testGenerateAllEntitiesOption(): void
    {
        // Arrange
        $results = [
            [
                'success' => true,
                'message' => 'Entité Culture créée',
                'entity_name' => 'Culture',
                'entity_path' => '/path/to/Culture.php',
            ],
            [
                'success' => true,
                'message' => 'Entité Amendement créée',
                'entity_name' => 'Amendement',
                'entity_path' => '/path/to/Amendement.php',
            ],
        ];

        $this->generatorService
            ->expects($this->once())
            ->method('generateAllEntities')
            ->with('App\\Entity\\Daplos', true, false, false)
            ->willReturn($results);

        // Act
        $exitCode = $this->commandTester->execute(['--all' => true]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);
        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Culture', $output);
        $this->assertStringContainsString('Amendement', $output);
        $this->assertStringContainsString('2 entités générées', $output);
    }

    /**
     * @test
     * @testdox Mode dry-run affiche ce qui serait généré sans créer de fichiers
     */
    public function testDryRunMode(): void
    {
        // Arrange
        $results = [
            [
                'success' => true,
                'message' => '[DRY-RUN] Entité Culture serait créée',
                'entity_name' => 'Culture',
                'dry_run' => true,
            ],
        ];

        $this->generatorService
            ->expects($this->once())
            ->method('generateAllEntities')
            ->with('App\\Entity\\Daplos', true, true, false)
            ->willReturn($results);

        // Act
        $exitCode = $this->commandTester->execute(['--all' => true, '--dry-run' => true]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);
        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('DRY-RUN', $output);
        $this->assertStringContainsString('serait', $output);
    }

    /**
     * @test
     * @testdox Option --no-repository ne génère pas les repositories
     */
    public function testNoRepositoryOption(): void
    {
        // Arrange
        $results = [
            [
                'success' => true,
                'message' => 'Entité Culture créée',
                'entity_name' => 'Culture',
            ],
        ];

        $this->generatorService
            ->expects($this->once())
            ->method('generateAllEntities')
            ->with('App\\Entity\\Daplos', false, false, false) // withRepositories = false
            ->willReturn($results);

        // Act
        $exitCode = $this->commandTester->execute([
            '--all' => true,
            '--no-repository' => true,
        ]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);
    }

    /**
     * @test
     * @testdox Option --force écrase les entités existantes
     */
    public function testForceOption(): void
    {
        // Arrange
        $results = [
            [
                'success' => true,
                'message' => 'Entité Culture recréée',
                'entity_name' => 'Culture',
            ],
        ];

        $this->generatorService
            ->expects($this->once())
            ->method('generateAllEntities')
            ->with('App\\Entity\\Daplos', true, false, true) // force = true
            ->willReturn($results);

        // Act
        $exitCode = $this->commandTester->execute([
            '--all' => true,
            '--force' => true,
        ]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);
    }

    /**
     * @test
     * @testdox Option --namespace permet de choisir le namespace des entités
     */
    public function testCustomNamespaceOption(): void
    {
        // Arrange
        $results = [
            [
                'success' => true,
                'message' => 'Entité créée',
                'entity_name' => 'Culture',
            ],
        ];

        $this->generatorService
            ->expects($this->once())
            ->method('generateAllEntities')
            ->with('App\\Domain\\Agriculture', true, false, false)
            ->willReturn($results);

        // Act
        $exitCode = $this->commandTester->execute([
            '--all' => true,
            '--namespace' => 'App\\Domain\\Agriculture',
        ]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);
    }

    /**
     * @test
     * @testdox Affiche les échecs de génération
     */
    public function testDisplaysFailures(): void
    {
        // Arrange
        $results = [
            [
                'success' => false,
                'message' => 'L\'entité Culture existe déjà',
                'entity_name' => 'Culture',
            ],
            [
                'success' => true,
                'message' => 'Entité Amendement créée',
                'entity_name' => 'Amendement',
            ],
        ];

        $this->generatorService
            ->expects($this->once())
            ->method('generateAllEntities')
            ->willReturn($results);

        // Act
        $exitCode = $this->commandTester->execute(['--all' => true]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);
        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('existe déjà', $output);
        $this->assertStringContainsString('1 entité générée', $output);
        $this->assertStringContainsString('1 échec', $output);
    }

    /**
     * @test
     * @testdox Retourne un code d'erreur si aucune entité n'est générée
     */
    public function testReturnsFailureCodeWhenNoEntitiesGenerated(): void
    {
        // Arrange
        $results = [
            [
                'success' => false,
                'message' => 'Échec',
                'entity_name' => 'Culture',
            ],
        ];

        $this->generatorService
            ->expects($this->once())
            ->method('generateAllEntities')
            ->willReturn($results);

        // Act
        $exitCode = $this->commandTester->execute(['--all' => true]);

        // Assert
        $this->assertEquals(Command::FAILURE, $exitCode);
        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Aucune entité générée', $output);
    }

    /**
     * @test
     * @testdox Affiche un message si aucun référentiel n'est disponible en mode check
     */
    public function testCheckModeWithNoReferentials(): void
    {
        // Arrange
        $this->generatorService
            ->expects($this->once())
            ->method('checkStatus')
            ->willReturn([]);

        // Act
        $exitCode = $this->commandTester->execute(['--check' => true]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);
        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Aucun référentiel', $output);
    }
}

