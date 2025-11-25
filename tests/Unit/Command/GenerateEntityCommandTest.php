<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Command;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use YoanBernabeu\DaplosBundle\Command\GenerateEntityCommand;
use YoanBernabeu\DaplosBundle\Service\EntityGeneratorServiceInterface;

/**
 * Tests unitaires pour GenerateEntityCommand.
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
        $this->assertStringContainsString('DaplosReferential', $this->command->getDescription());

        $definition = $this->command->getDefinition();
        $this->assertTrue($definition->hasOption('namespace'));
        $this->assertTrue($definition->hasOption('no-repository'));
        $this->assertTrue($definition->hasOption('dry-run'));
        $this->assertTrue($definition->hasOption('force'));
        $this->assertTrue($definition->hasOption('check'));
    }

    /**
     * @test
     *
     * @testdox Mode check affiche le statut de l'entité
     */
    public function testCheckModeDisplaysStatus(): void
    {
        // Arrange
        $status = [
            'entity_exists' => true,
            'repository_exists' => true,
            'entity_path' => '/path/to/DaplosReferential.php',
            'repository_path' => '/path/to/DaplosReferentialRepository.php',
        ];

        $this->generatorService
            ->expects($this->once())
            ->method('checkStatus')
            ->with('App\\Entity')
            ->willReturn($status);

        // Act
        $exitCode = $this->commandTester->execute(['--check' => true]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);
        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Existe', $output);
        $this->assertStringContainsString('DaplosReferential', $output);
    }

    /**
     * @test
     *
     * @testdox Mode check avec entité non générée
     */
    public function testCheckModeWithNoEntity(): void
    {
        // Arrange
        $status = [
            'entity_exists' => false,
            'repository_exists' => false,
            'entity_path' => '/path/to/DaplosReferential.php',
            'repository_path' => '/path/to/DaplosReferentialRepository.php',
        ];

        $this->generatorService
            ->expects($this->once())
            ->method('checkStatus')
            ->willReturn($status);

        // Act
        $exitCode = $this->commandTester->execute(['--check' => true]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);
        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Non générée', $output);
    }

    /**
     * @test
     *
     * @testdox Génère l'entité avec succès
     */
    public function testGenerateEntitySuccess(): void
    {
        // Arrange
        $result = [
            'success' => true,
            'message' => 'Entité DaplosReferential créée avec succès',
            'entity_path' => '/path/to/DaplosReferential.php',
            'repository_path' => '/path/to/DaplosReferentialRepository.php',
            'dry_run' => false,
        ];

        $this->generatorService
            ->expects($this->once())
            ->method('generateEntity')
            ->with('App\\Entity', true, false, false)
            ->willReturn($result);

        // Act
        $exitCode = $this->commandTester->execute([]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);
        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('DaplosReferential', $output);
        $this->assertStringContainsString('succès', $output);
    }

    /**
     * @test
     *
     * @testdox Mode dry-run affiche ce qui serait généré sans créer de fichiers
     */
    public function testDryRunMode(): void
    {
        // Arrange
        $result = [
            'success' => true,
            'message' => '[DRY-RUN] Entité DaplosReferential serait créée',
            'entity_path' => '/path/to/DaplosReferential.php',
            'repository_path' => '/path/to/DaplosReferentialRepository.php',
            'dry_run' => true,
        ];

        $this->generatorService
            ->expects($this->once())
            ->method('generateEntity')
            ->with('App\\Entity', true, true, false)
            ->willReturn($result);

        // Act
        $exitCode = $this->commandTester->execute(['--dry-run' => true]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);
        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('DRY-RUN', $output);
    }

    /**
     * @test
     *
     * @testdox Option --no-repository ne génère pas le repository
     */
    public function testNoRepositoryOption(): void
    {
        // Arrange
        $result = [
            'success' => true,
            'message' => 'Entité DaplosReferential créée avec succès',
            'entity_path' => '/path/to/DaplosReferential.php',
            'repository_path' => null,
            'dry_run' => false,
        ];

        $this->generatorService
            ->expects($this->once())
            ->method('generateEntity')
            ->with('App\\Entity', false, false, false) // withRepository = false
            ->willReturn($result);

        // Act
        $exitCode = $this->commandTester->execute(['--no-repository' => true]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);
    }

    /**
     * @test
     *
     * @testdox Option --force écrase l'entité existante
     */
    public function testForceOption(): void
    {
        // Arrange
        $result = [
            'success' => true,
            'message' => 'Entité DaplosReferential recréée',
            'entity_path' => '/path/to/DaplosReferential.php',
            'repository_path' => '/path/to/DaplosReferentialRepository.php',
            'dry_run' => false,
        ];

        $this->generatorService
            ->expects($this->once())
            ->method('generateEntity')
            ->with('App\\Entity', true, false, true) // force = true
            ->willReturn($result);

        // Act
        $exitCode = $this->commandTester->execute(['--force' => true]);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);
    }

    /**
     * @test
     *
     * @testdox Option --namespace permet de choisir le namespace
     */
    public function testCustomNamespaceOption(): void
    {
        // Arrange
        $result = [
            'success' => true,
            'message' => 'Entité créée',
            'entity_path' => '/path/to/DaplosReferential.php',
            'repository_path' => '/path/to/DaplosReferentialRepository.php',
            'dry_run' => false,
        ];

        $this->generatorService
            ->expects($this->once())
            ->method('generateEntity')
            ->with('App\\Domain\\Agriculture', true, false, false)
            ->willReturn($result);

        // Act
        $exitCode = $this->commandTester->execute(['--namespace' => 'App\\Domain\\Agriculture']);

        // Assert
        $this->assertEquals(Command::SUCCESS, $exitCode);
    }

    /**
     * @test
     *
     * @testdox Affiche une erreur si l'entité existe déjà sans --force
     */
    public function testDisplaysErrorWhenEntityExists(): void
    {
        // Arrange
        $result = [
            'success' => false,
            'message' => 'L\'entité DaplosReferential existe déjà (utilisez --force pour écraser)',
            'entity_path' => '/path/to/DaplosReferential.php',
            'repository_path' => null,
            'dry_run' => false,
        ];

        $this->generatorService
            ->expects($this->once())
            ->method('generateEntity')
            ->willReturn($result);

        // Act
        $exitCode = $this->commandTester->execute([]);

        // Assert
        $this->assertEquals(Command::FAILURE, $exitCode);
        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('existe déjà', $output);
    }
}
