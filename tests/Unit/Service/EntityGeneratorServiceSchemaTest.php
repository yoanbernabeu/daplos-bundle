<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\Service\EntityGeneratorService;

class EntityGeneratorServiceSchemaTest extends TestCase
{
    private string $projectDir;

    protected function setUp(): void
    {
        $this->projectDir = sys_get_temp_dir().'/daplos_test_'.uniqid();
        mkdir($this->projectDir.'/src/Entity', 0o755, true);
    }

    protected function tearDown(): void
    {
        $this->removeDirectory($this->projectDir);
    }

    public function testGenerateEntityWithSchema(): void
    {
        // Arrange
        $schema = 'my_schema';
        $service = new EntityGeneratorService($this->projectDir, $schema);

        // Act
        $result = $service->generateEntity('App\\Entity', false, false, true);

        // Assert
        $this->assertTrue($result['success']);
        $this->assertFileExists($result['entity_path']);

        $content = file_get_contents($result['entity_path']);

        // On vérifie que l'attribut Table contient bien le schema
        $this->assertStringContainsString(
            "schema: 'my_schema'",
            $content,
            'L\'attribut Table devrait contenir le schéma configuré'
        );
    }

    public function testGenerateEntityWithoutSchema(): void
    {
        // Arrange
        $service = new EntityGeneratorService($this->projectDir, null);

        // Act
        $result = $service->generateEntity('App\\Entity', false, false, true);

        // Assert
        $this->assertTrue($result['success']);

        $content = file_get_contents($result['entity_path']);

        // On vérifie que l'attribut Table ne contient pas de schema
        $this->assertStringNotContainsString(
            'schema:',
            $content,
            'L\'attribut Table ne devrait pas contenir de schéma par défaut'
        );
    }

    private function removeDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->removeDirectory("$dir/$file") : unlink("$dir/$file");
        }
        rmdir($dir);
    }
}
