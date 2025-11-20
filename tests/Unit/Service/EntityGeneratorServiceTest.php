<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Service;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\Service\EntityGeneratorService;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncServiceInterface;

/**
 * Tests unitaires pour EntityGeneratorService.
 *
 * Ce service génère des entités et repositories dans l'application utilisateur
 * en utilisant les traits DAPLOS disponibles.
 *
 * Structure AAA (Arrange-Act-Assert) appliquée systématiquement.
 */
class EntityGeneratorServiceTest extends TestCase
{
    private ReferentialSyncServiceInterface|MockObject $syncService;
    private string $projectDir;
    private EntityGeneratorService $service;

    protected function setUp(): void
    {
        // Arrange : Préparer les mocks
        $this->syncService = $this->createMock(ReferentialSyncServiceInterface::class);
        $this->projectDir = sys_get_temp_dir().'/daplos_test_'.uniqid();

        // Créer la structure de test
        mkdir($this->projectDir.'/src/Entity/Daplos', 0o755, true);
        mkdir($this->projectDir.'/src/Repository', 0o755, true);

        $this->service = new EntityGeneratorService(
            $this->syncService,
            $this->projectDir
        );
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
    public function testCheckStatusWithNoExistingEntities(): void
    {
        // Arrange
        $referentials = [
            ['id' => 611, 'name' => 'Cultures', 'repository_code' => 'List_BotanicalSpecies_CodeType'],
            ['id' => 633, 'name' => 'Amendements', 'repository_code' => 'List_SoilSupplement_CodeType'],
        ];

        $this->syncService
            ->expects($this->once())
            ->method('getAvailableReferentials')
            ->willReturn($referentials);

        // Act
        $status = $this->service->checkStatus();

        // Assert
        $this->assertIsArray($status);
        $this->assertCount(2, $status);
        $this->assertEquals('Cultures', $status[0]['referential_name']);
        $this->assertEquals('Cultures', $status[0]['entity_name']); // Le nom de l'entité conserve le nom du trait
        $this->assertFalse($status[0]['entity_exists']);
        $this->assertFalse($status[0]['repository_exists']);
        $this->assertNull($status[0]['entity_path']);
    }

    /**
     * @test
     */
    public function testCheckStatusWithExistingEntities(): void
    {
        // Arrange
        $referentials = [
            ['id' => 611, 'name' => 'Cultures', 'repository_code' => 'List_BotanicalSpecies_CodeType'],
        ];

        // Créer une entité existante
        file_put_contents(
            $this->projectDir.'/src/Entity/Daplos/Cultures.php',
            '<?php namespace App\\Entity\\Daplos; class Cultures {}'
        );

        $this->syncService
            ->method('getAvailableReferentials')
            ->willReturn($referentials);

        // Act
        $status = $this->service->checkStatus();

        // Assert
        $this->assertTrue($status[0]['entity_exists']);
        $this->assertStringContainsString('Cultures.php', $status[0]['entity_path']);
    }

    /**
     * @test
     *
     * @testdox Génère une entité avec le trait approprié et l'attribut DaplosId
     */
    public function testGenerateEntityCreatesFileWithCorrectContent(): void
    {
        // Arrange
        $referential = [
            'id' => 611,
            'name' => 'Cultures',
            'repository_code' => 'List_BotanicalSpecies_CodeType',
        ];

        // Act
        $result = $this->service->generateEntity(
            referential: $referential,
            namespace: 'App\\Entity\\Daplos',
            withRepository: true,
            dryRun: false
        );

        // Assert
        $this->assertTrue($result['success']);
        $this->assertFileExists($this->projectDir.'/src/Entity/Daplos/Cultures.php');

        $content = file_get_contents($this->projectDir.'/src/Entity/Daplos/Cultures.php');
        $this->assertStringContainsString('namespace App\\Entity\\Daplos', $content);
        $this->assertStringContainsString('class Cultures', $content);
        $this->assertStringContainsString('use CulturesTrait', $content);
        // La propriété culturesId est définie dans le trait, pas dans l'entité elle-même
        $this->assertStringContainsString('culturesId est définie dans le trait avec l\'attribut #[DaplosId]', $content);
    }

    /**
     * @test
     *
     * @testdox En mode dry-run, ne crée pas de fichiers
     */
    public function testGenerateEntityInDryRunDoesNotCreateFiles(): void
    {
        // Arrange
        $referential = ['id' => 611, 'name' => 'Cultures', 'repository_code' => 'Test'];

        // Act
        $result = $this->service->generateEntity(
            referential: $referential,
            namespace: 'App\\Entity\\Daplos',
            withRepository: false,
            dryRun: true
        );

        // Assert
        $this->assertTrue($result['success']);
        $this->assertTrue($result['dry_run']);
        $this->assertFileDoesNotExist($this->projectDir.'/src/Entity/Daplos/Cultures.php');
    }

    /**
     * @test
     *
     * @testdox Est idempotent : ne recrée pas une entité existante sans force
     */
    public function testGenerateEntityIsIdempotentWithoutForce(): void
    {
        // Arrange
        $referential = ['id' => 611, 'name' => 'Cultures', 'repository_code' => 'Test'];

        // Créer une entité existante
        $existingContent = '<?php namespace App\\Entity\\Daplos; class Cultures { /* existing */ }';
        file_put_contents($this->projectDir.'/src/Entity/Daplos/Cultures.php', $existingContent);

        // Act
        $result = $this->service->generateEntity(
            referential: $referential,
            namespace: 'App\\Entity\\Daplos',
            withRepository: false,
            dryRun: false,
            force: false
        );

        // Assert
        $this->assertFalse($result['success']);
        $this->assertStringContainsString('existe déjà', $result['message']);

        // Vérifier que le fichier n'a pas été modifié
        $content = file_get_contents($this->projectDir.'/src/Entity/Daplos/Cultures.php');
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
        $referential = ['id' => 611, 'name' => 'Cultures', 'repository_code' => 'Test'];

        file_put_contents($this->projectDir.'/src/Entity/Daplos/Cultures.php', '<?php // old');

        // Act
        $result = $this->service->generateEntity(
            referential: $referential,
            namespace: 'App\\Entity\\Daplos',
            withRepository: false,
            dryRun: false,
            force: true
        );

        // Assert
        $this->assertTrue($result['success']);
        $content = file_get_contents($this->projectDir.'/src/Entity/Daplos/Cultures.php');
        $this->assertStringNotContainsString('// old', $content);
        $this->assertStringContainsString('class Cultures', $content);
    }

    /**
     * @test
     */
    public function testGenerateEntityCreatesRepositoryWhenRequested(): void
    {
        // Arrange
        $referential = ['id' => 611, 'name' => 'Cultures', 'repository_code' => 'Test'];

        // Act
        $result = $this->service->generateEntity(
            referential: $referential,
            namespace: 'App\\Entity',
            withRepository: true,
            dryRun: false
        );

        // Assert
        $this->assertTrue($result['success']);
        $this->assertFileExists($this->projectDir.'/src/Repository/CulturesRepository.php');

        $content = file_get_contents($this->projectDir.'/src/Repository/CulturesRepository.php');
        $this->assertStringContainsString('namespace App\\Repository', $content);
        $this->assertStringContainsString('class CulturesRepository', $content);
        $this->assertStringContainsString('ServiceEntityRepository', $content);
        $this->assertStringContainsString('implements DaplosRepositoryInterface', $content);
        $this->assertStringContainsString('use YoanBernabeu\DaplosBundle\Contract\DaplosRepositoryInterface;', $content);
    }

    /**
     * @test
     */
    public function testGenerateEntityWithCustomNamespace(): void
    {
        // Arrange
        mkdir($this->projectDir.'/src/Domain/Agriculture', 0o755, true);
        $referential = ['id' => 611, 'name' => 'Cultures', 'repository_code' => 'Test'];

        // Act
        $result = $this->service->generateEntity(
            referential: $referential,
            namespace: 'App\\Domain\\Agriculture',
            withRepository: false,
            dryRun: false
        );

        // Assert
        $this->assertTrue($result['success']);
        $this->assertFileExists($this->projectDir.'/src/Domain/Agriculture/Cultures.php');

        $content = file_get_contents($this->projectDir.'/src/Domain/Agriculture/Cultures.php');
        $this->assertStringContainsString('namespace App\\Domain\\Agriculture', $content);
    }

    /**
     * @test
     */
    public function testGenerateAllEntitiesCreatesAllReferentials(): void
    {
        // Arrange
        $referentials = [
            ['id' => 611, 'name' => 'Cultures', 'repository_code' => 'Test1'],
            ['id' => 633, 'name' => 'Amendements', 'repository_code' => 'Test2'],
        ];

        $this->syncService
            ->method('getAvailableReferentials')
            ->willReturn($referentials);

        // Act
        $results = $this->service->generateAllEntities(
            namespace: 'App\\Entity\\Daplos',
            withRepositories: true,
            dryRun: false,
            force: false
        );

        // Assert
        $this->assertCount(2, $results);
        $this->assertTrue($results[0]['success']);
        $this->assertTrue($results[1]['success']);
        $this->assertFileExists($this->projectDir.'/src/Entity/Daplos/Cultures.php');
        $this->assertFileExists($this->projectDir.'/src/Entity/Daplos/Amendements.php');
    }

    /**
     * @test
     *
     * @testdox GenerateAll est idempotent : skip les entités existantes
     */
    public function testGenerateAllIsIdempotent(): void
    {
        // Arrange
        $referentials = [
            ['id' => 611, 'name' => 'Cultures', 'repository_code' => 'Test1'],
            ['id' => 633, 'name' => 'Amendements', 'repository_code' => 'Test2'],
        ];

        $this->syncService
            ->method('getAvailableReferentials')
            ->willReturn($referentials);

        // Créer une entité existante
        file_put_contents(
            $this->projectDir.'/src/Entity/Daplos/Cultures.php',
            '<?php namespace App\\Entity\\Daplos; class Cultures {}'
        );

        // Act
        $results = $this->service->generateAllEntities(
            namespace: 'App\\Entity\\Daplos',
            withRepositories: false,
            dryRun: false,
            force: false
        );

        // Assert
        $this->assertFalse($results[0]['success']); // Cultures déjà existe
        $this->assertTrue($results[1]['success']);   // Amendements créé
        $this->assertFileExists($this->projectDir.'/src/Entity/Daplos/Amendements.php');
    }

    /**
     * @test
     *
     * @testdox Génère correctement les noms en CamelCase pour les référentiels avec espaces
     */
    public function testGenerateEntityWithSpacesInName(): void
    {
        // Arrange
        $referential = [
            'id' => 633,
            'name' => 'Amendements du sol (Type)',
            'repository_code' => 'List_SpecifiedSoilSupplement_CodeType',
        ];

        // Act
        $result = $this->service->generateEntity(
            referential: $referential,
            namespace: 'App\\Entity\\Daplos',
            withRepository: false,
            dryRun: false
        );

        // Assert
        $this->assertTrue($result['success']);
        $this->assertFileExists($this->projectDir.'/src/Entity/Daplos/AmendementsDuSolType.php');

        $content = file_get_contents($this->projectDir.'/src/Entity/Daplos/AmendementsDuSolType.php');
        $this->assertStringContainsString('class AmendementsDuSolType', $content);
        $this->assertStringContainsString('use AmendementsDuSolTypeTrait', $content);
    }

    /**
     * @test
     *
     * @testdox Génère correctement les noms en CamelCase pour les référentiels simples
     */
    public function testGenerateEntityWithSimpleName(): void
    {
        // Arrange
        $referential = [
            'id' => 611,
            'name' => 'Cultures',
            'repository_code' => 'List_BotanicalSpecies_CodeType',
        ];

        // Act
        $result = $this->service->generateEntity(
            referential: $referential,
            namespace: 'App\\Entity\\Daplos',
            withRepository: false,
            dryRun: false
        );

        // Assert
        $this->assertTrue($result['success']);
        $this->assertFileExists($this->projectDir.'/src/Entity/Daplos/Cultures.php');

        $content = file_get_contents($this->projectDir.'/src/Entity/Daplos/Cultures.php');
        $this->assertStringContainsString('class Cultures', $content);
        $this->assertStringContainsString('use CulturesTrait', $content);
    }

    /**
     * @test
     *
     * @testdox Génère correctement les noms en CamelCase pour les référentiels avec qualifiant
     */
    public function testGenerateEntityWithQualifier(): void
    {
        // Arrange
        $referential = [
            'id' => 100,
            'name' => 'Culture (Destination)',
            'repository_code' => 'Test_Code',
        ];

        // Act
        $result = $this->service->generateEntity(
            referential: $referential,
            namespace: 'App\\Entity\\Daplos',
            withRepository: false,
            dryRun: false
        );

        // Assert
        $this->assertTrue($result['success']);
        $this->assertFileExists($this->projectDir.'/src/Entity/Daplos/CultureDestination.php');

        $content = file_get_contents($this->projectDir.'/src/Entity/Daplos/CultureDestination.php');
        $this->assertStringContainsString('class CultureDestination', $content);
        $this->assertStringContainsString('use CultureDestinationTrait', $content);
    }

    /**
     * @test
     *
     * @testdox Génère correctement les noms en CamelCase pour les référentiels avec accents
     */
    public function testGenerateEntityWithAccents(): void
    {
        // Arrange
        $referential = [
            'id' => 200,
            'name' => 'Type de piège',
            'repository_code' => 'Test_Code',
        ];

        // Act
        $result = $this->service->generateEntity(
            referential: $referential,
            namespace: 'App\\Entity\\Daplos',
            withRepository: false,
            dryRun: false
        );

        // Assert
        $this->assertTrue($result['success']);
        $this->assertFileExists($this->projectDir.'/src/Entity/Daplos/TypeDePiege.php');

        $content = file_get_contents($this->projectDir.'/src/Entity/Daplos/TypeDePiege.php');
        $this->assertStringContainsString('class TypeDePiege', $content);
        $this->assertStringContainsString('use TypeDePiegeTrait', $content);
    }

    /**
     * @test
     *
     * @testdox Vérifie que checkStatus retourne les bons noms de traits en CamelCase
     */
    public function testCheckStatusWithCamelCaseNames(): void
    {
        // Arrange
        $referentials = [
            ['id' => 633, 'name' => 'Amendements du sol (Type)', 'repository_code' => 'List_SpecifiedSoilSupplement_CodeType'],
            ['id' => 611, 'name' => 'Cultures', 'repository_code' => 'List_BotanicalSpecies_CodeType'],
        ];

        $this->syncService
            ->expects($this->once())
            ->method('getAvailableReferentials')
            ->willReturn($referentials);

        // Act
        $status = $this->service->checkStatus();

        // Assert
        $this->assertIsArray($status);
        $this->assertCount(2, $status);
        $this->assertEquals('Amendements du sol (Type)', $status[0]['referential_name']);
        $this->assertEquals('AmendementsDuSolType', $status[0]['entity_name']);
        $this->assertEquals('AmendementsDuSolTypeTrait', $status[0]['trait_name']);
        $this->assertEquals('Cultures', $status[1]['entity_name']);
        $this->assertEquals('CulturesTrait', $status[1]['trait_name']);
    }

    /**
     * @test
     */
    public function testUpdateRepositories(): void
    {
        // Arrange
        $referentials = [
            ['id' => 611, 'name' => 'Cultures', 'repository_code' => 'List_BotanicalSpecies_CodeType'],
        ];

        $this->syncService
            ->method('getAvailableReferentials')
            ->willReturn($referentials);

        // Créer le répertoire manquant
        mkdir($this->projectDir.'/src/Repository/Daplos', 0o755, true);

        // Créer un repo ancien sans l'interface
        $oldRepoContent = <<<'PHP'
        <?php
        namespace App\Repository\Daplos;
        use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
        use Doctrine\Persistence\ManagerRegistry;
        class CulturesRepository extends ServiceEntityRepository
        {
            public function __construct(ManagerRegistry $registry)
            {
                parent::__construct($registry, Cultures::class);
            }
        }
        PHP;

        file_put_contents($this->projectDir.'/src/Repository/Daplos/CulturesRepository.php', $oldRepoContent);

        // Act
        $results = $this->service->updateRepositories(
            namespace: 'App\\Entity\\Daplos',
            dryRun: false
        );

        // Assert
        $this->assertCount(1, $results);
        $this->assertEquals('updated', $results[0]['status']);

        $newContent = file_get_contents($this->projectDir.'/src/Repository/Daplos/CulturesRepository.php');
        $this->assertStringContainsString('implements DaplosRepositoryInterface', $newContent);
        $this->assertStringContainsString('use YoanBernabeu\DaplosBundle\Contract\DaplosRepositoryInterface;', $newContent);
        $this->assertStringContainsString('function findOneByDaplosId', $newContent);
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
