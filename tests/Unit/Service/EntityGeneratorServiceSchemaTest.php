<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Service;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\Service\EntityGeneratorService;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncServiceInterface;

class EntityGeneratorServiceSchemaTest extends TestCase
{
    private MockObject&ReferentialSyncServiceInterface $syncService;
    private string $projectDir;

    protected function setUp(): void
    {
        $this->syncService = $this->createMock(ReferentialSyncServiceInterface::class);
        $this->projectDir = sys_get_temp_dir().'/daplos_test_'.uniqid();
        mkdir($this->projectDir, 0o777, true);
    }

    protected function tearDown(): void
    {
        $this->removeDirectory($this->projectDir);
    }

    public function testGenerateEntityWithSchema(): void
    {
        // Arrange
        $schema = 'my_schema';
        $service = new EntityGeneratorService($this->syncService, $this->projectDir, $schema);

        $referential = [
            'id' => 1,
            'name' => 'Cultures',
            'repository_code' => 'REF_CULTURES',
        ];

        // Act
        $result = $service->generateEntity($referential, 'App\\Entity\\Daplos', false, false, true);

        // Assert
        $this->assertTrue($result['success']);
        $this->assertFileExists($result['entity_path']);

        $content = file_get_contents($result['entity_path']);

        // On vérifie que l'attribut Table contient bien le schema
        $this->assertStringContainsString(
            "#[ORM\Table(name: 'daplos_cultures', schema: 'my_schema')]",
            $content,
            'L\'attribut Table devrait contenir le schéma configuré'
        );
    }

    public function testGenerateEntityWithoutSchema(): void
    {
        // Arrange
        $service = new EntityGeneratorService($this->syncService, $this->projectDir, null);

        $referential = [
            'id' => 1,
            'name' => 'Cultures',
            'repository_code' => 'REF_CULTURES',
        ];

        // Act
        $result = $service->generateEntity($referential, 'App\\Entity\\Daplos', false, false, true);

        // Assert
        $this->assertTrue($result['success']);

        $content = file_get_contents($result['entity_path']);

        // On vérifie que l'attribut Table ne contient pas de schema
        $this->assertStringContainsString(
            "#[ORM\Table(name: 'daplos_cultures')]",
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
