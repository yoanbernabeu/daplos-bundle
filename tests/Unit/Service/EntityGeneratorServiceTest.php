<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\Service\EntityGeneratorService;

/**
 * Tests unitaires pour EntityGeneratorService.
 *
 * Ce service génère l'entité unique DaplosReferential et son repository
 * dans l'application utilisateur.
 *
 * Structure AAA (Arrange-Act-Assert) appliquée systématiquement.
 */
class EntityGeneratorServiceTest extends TestCase
{
    private string $projectDir;
    private EntityGeneratorService $service;

    protected function setUp(): void
    {
        $this->projectDir = sys_get_temp_dir().'/daplos_test_'.uniqid();

        // Créer la structure de test
        mkdir($this->projectDir.'/src/Entity', 0o755, true);
        mkdir($this->projectDir.'/src/Repository', 0o755, true);

        $this->service = new EntityGeneratorService($this->projectDir);
    }

    protected function tearDown(): void
    {
        // Nettoyer les fichiers de test
        if (is_dir($this->projectDir)) {
            $this->deleteDirectory($this->projectDir);
        }
    }

    /**
     * @test
     */
    public function testCheckStatusWithNoExistingEntity(): void
    {
        // Act
        $status = $this->service->checkStatus();

        // Assert
        $this->assertIsArray($status);
        $this->assertFalse($status['entity_exists']);
        $this->assertFalse($status['repository_exists']);
        $this->assertStringContainsString('DaplosReferential.php', $status['entity_path']);
        $this->assertStringContainsString('DaplosReferentialRepository.php', $status['repository_path']);
    }

    /**
     * @test
     */
    public function testCheckStatusWithExistingEntity(): void
    {
        // Arrange
        file_put_contents(
            $this->projectDir.'/src/Entity/DaplosReferential.php',
            '<?php namespace App\\Entity; class DaplosReferential {}'
        );

        // Act
        $status = $this->service->checkStatus();

        // Assert
        $this->assertTrue($status['entity_exists']);
        $this->assertFalse($status['repository_exists']);
    }

    /**
     * @test
     */
    public function testCheckStatusWithExistingEntityAndRepository(): void
    {
        // Arrange
        file_put_contents(
            $this->projectDir.'/src/Entity/DaplosReferential.php',
            '<?php namespace App\\Entity; class DaplosReferential {}'
        );
        file_put_contents(
            $this->projectDir.'/src/Repository/DaplosReferentialRepository.php',
            '<?php namespace App\\Repository; class DaplosReferentialRepository {}'
        );

        // Act
        $status = $this->service->checkStatus();

        // Assert
        $this->assertTrue($status['entity_exists']);
        $this->assertTrue($status['repository_exists']);
    }

    /**
     * @test
     *
     * @testdox Génère une entité avec le trait DaplosReferentialTrait
     */
    public function testGenerateEntityCreatesFileWithCorrectContent(): void
    {
        // Act
        $result = $this->service->generateEntity(
            namespace: 'App\\Entity',
            withRepository: true,
            dryRun: false
        );

        // Assert
        $this->assertTrue($result['success']);
        $this->assertFileExists($this->projectDir.'/src/Entity/DaplosReferential.php');

        $content = file_get_contents($this->projectDir.'/src/Entity/DaplosReferential.php');
        $this->assertStringContainsString('namespace App\\Entity', $content);
        $this->assertStringContainsString('class DaplosReferential', $content);
        $this->assertStringContainsString('use DaplosReferentialTrait', $content);
        $this->assertStringContainsString('implements DaplosEntityInterface', $content);
        $this->assertStringContainsString('UniqueConstraint', $content);
    }

    /**
     * @test
     *
     * @testdox En mode dry-run, ne crée pas de fichiers
     */
    public function testGenerateEntityInDryRunDoesNotCreateFiles(): void
    {
        // Act
        $result = $this->service->generateEntity(
            namespace: 'App\\Entity',
            withRepository: false,
            dryRun: true
        );

        // Assert
        $this->assertTrue($result['success']);
        $this->assertTrue($result['dry_run']);
        $this->assertFileDoesNotExist($this->projectDir.'/src/Entity/DaplosReferential.php');
    }

    /**
     * @test
     *
     * @testdox Est idempotent : ne recrée pas une entité existante sans force
     */
    public function testGenerateEntityIsIdempotentWithoutForce(): void
    {
        // Arrange
        $existingContent = '<?php namespace App\\Entity; class DaplosReferential { /* existing */ }';
        file_put_contents($this->projectDir.'/src/Entity/DaplosReferential.php', $existingContent);

        // Act
        $result = $this->service->generateEntity(
            namespace: 'App\\Entity',
            withRepository: false,
            dryRun: false,
            force: false
        );

        // Assert
        $this->assertFalse($result['success']);
        $this->assertStringContainsString('existe déjà', $result['message']);

        // Vérifier que le fichier n'a pas été modifié
        $content = file_get_contents($this->projectDir.'/src/Entity/DaplosReferential.php');
        $this->assertEquals($existingContent, $content);
    }

    /**
     * @test
     *
     * @testdox Écrase une entité existante avec force=true
     */
    public function testGenerateEntityWithForceOverwritesExisting(): void
    {
        // Arrange
        file_put_contents($this->projectDir.'/src/Entity/DaplosReferential.php', '<?php // old');

        // Act
        $result = $this->service->generateEntity(
            namespace: 'App\\Entity',
            withRepository: false,
            dryRun: false,
            force: true
        );

        // Assert
        $this->assertTrue($result['success']);
        $content = file_get_contents($this->projectDir.'/src/Entity/DaplosReferential.php');
        $this->assertStringNotContainsString('// old', $content);
        $this->assertStringContainsString('class DaplosReferential', $content);
    }

    /**
     * @test
     */
    public function testGenerateEntityCreatesRepositoryWhenRequested(): void
    {
        // Act
        $result = $this->service->generateEntity(
            namespace: 'App\\Entity',
            withRepository: true,
            dryRun: false
        );

        // Assert
        $this->assertTrue($result['success']);
        $this->assertFileExists($this->projectDir.'/src/Repository/DaplosReferentialRepository.php');

        $content = file_get_contents($this->projectDir.'/src/Repository/DaplosReferentialRepository.php');
        $this->assertStringContainsString('namespace App\\Repository', $content);
        $this->assertStringContainsString('class DaplosReferentialRepository', $content);
        $this->assertStringContainsString('ServiceEntityRepository', $content);
        $this->assertStringContainsString('implements DaplosRepositoryInterface', $content);
        $this->assertStringContainsString('findOneByDaplosIdAndType', $content);
        $this->assertStringContainsString('findByReferentialType', $content);
    }

    /**
     * @test
     */
    public function testGenerateEntityWithCustomNamespace(): void
    {
        // Arrange
        mkdir($this->projectDir.'/src/Domain/Agriculture', 0o755, true);

        // Act
        $result = $this->service->generateEntity(
            namespace: 'App\\Domain\\Agriculture',
            withRepository: false,
            dryRun: false
        );

        // Assert
        $this->assertTrue($result['success']);
        $this->assertFileExists($this->projectDir.'/src/Domain/Agriculture/DaplosReferential.php');

        $content = file_get_contents($this->projectDir.'/src/Domain/Agriculture/DaplosReferential.php');
        $this->assertStringContainsString('namespace App\\Domain\\Agriculture', $content);
    }

    /**
     * @test
     */
    public function testGenerateEntityWithSchema(): void
    {
        // Arrange
        $serviceWithSchema = new EntityGeneratorService($this->projectDir, 'daplos_schema');

        // Act
        $result = $serviceWithSchema->generateEntity(
            namespace: 'App\\Entity',
            withRepository: false,
            dryRun: false
        );

        // Assert
        $this->assertTrue($result['success']);
        $content = file_get_contents($this->projectDir.'/src/Entity/DaplosReferential.php');
        $this->assertStringContainsString("schema: 'daplos_schema'", $content);
    }

    /**
     * Helper pour nettoyer les répertoires de test.
     */
    private function deleteDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir.'/'.$file;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
        rmdir($dir);
    }
}
