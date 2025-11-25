<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\Client\DaplosApiClientInterface;
use YoanBernabeu\DaplosBundle\Contract\DaplosEntityInterface;
use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;
use YoanBernabeu\DaplosBundle\Exception\DaplosApiException;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncService;

class ReferentialSyncServiceTest extends TestCase
{
    private DaplosApiClientInterface $apiClient;
    private EntityManagerInterface $entityManager;
    private ReferentialSyncService $service;

    protected function setUp(): void
    {
        $this->apiClient = $this->createMock(DaplosApiClientInterface::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->service = new ReferentialSyncService($this->apiClient, $this->entityManager);
    }

    public function testSyncReferentialWithNewEntities(): void
    {
        // Arrange
        $type = DaplosReferentialType::AMENDEMENTS_DU_SOL;

        $referentialData = [
            'referential' => ['id' => $type->getId(), 'name' => $type->getLabel()],
            'references' => [
                ['id' => 1, 'title' => 'Calcaire', 'reference_code' => 'CAL'],
                ['id' => 2, 'title' => 'Chaux', 'reference_code' => 'CHX'],
            ],
        ];

        $this->apiClient->expects($this->once())
            ->method('getReferential')
            ->with($type->getId())
            ->willReturn($referentialData);

        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')->willReturn(null); // Pas d'entité existante

        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($repository);

        $this->entityManager->expects($this->once())
            ->method('beginTransaction');

        $this->entityManager->expects($this->exactly(2))
            ->method('persist');

        $this->entityManager->expects($this->atLeastOnce())
            ->method('flush');

        $this->entityManager->expects($this->once())
            ->method('commit');

        // Act
        $stats = $this->service->syncReferential(
            TestDaplosEntity::class,
            $type
        );

        // Assert
        $this->assertEquals(2, $stats['created']);
        $this->assertEquals(0, $stats['updated']);
        $this->assertEquals(2, $stats['total']);
    }

    public function testSyncReferentialWithExistingEntities(): void
    {
        // Arrange
        $type = DaplosReferentialType::AMENDEMENTS_DU_SOL;

        $referentialData = [
            'referential' => ['id' => $type->getId(), 'name' => $type->getLabel()],
            'references' => [
                ['id' => 1, 'title' => 'Calcaire Updated', 'reference_code' => 'CAL'],
            ],
        ];

        $this->apiClient->expects($this->once())
            ->method('getReferential')
            ->with($type->getId())
            ->willReturn($referentialData);

        $existingEntity = new TestDaplosEntity();
        $existingEntity->setDaplosId(1);
        $existingEntity->setReferentialType($type);

        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')
            ->willReturn($existingEntity);

        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($repository);

        $this->entityManager->expects($this->once())
            ->method('beginTransaction');

        $this->entityManager->expects($this->once())
            ->method('persist');

        $this->entityManager->expects($this->atLeastOnce())
            ->method('flush');

        $this->entityManager->expects($this->once())
            ->method('commit');

        // Act
        $stats = $this->service->syncReferential(
            TestDaplosEntity::class,
            $type
        );

        // Assert
        $this->assertEquals(0, $stats['created']);
        $this->assertEquals(1, $stats['updated']);
        $this->assertEquals(1, $stats['total']);
    }

    public function testSyncReferentialRollsBackOnError(): void
    {
        // Arrange
        $type = DaplosReferentialType::AMENDEMENTS_DU_SOL;

        $referentialData = [
            'referential' => ['id' => $type->getId(), 'name' => $type->getLabel()],
            'references' => [
                ['id' => 1, 'title' => 'Calcaire', 'reference_code' => 'CAL'],
            ],
        ];

        $this->apiClient->expects($this->once())
            ->method('getReferential')
            ->willReturn($referentialData);

        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')->willReturn(null);

        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($repository);

        $this->entityManager->expects($this->once())
            ->method('beginTransaction');

        // Simuler une erreur lors du flush
        $this->entityManager->expects($this->atLeastOnce())
            ->method('flush')
            ->willThrowException(new \Exception('Database error'));

        $this->entityManager->expects($this->once())
            ->method('rollback');

        // Assert
        $this->expectException(DaplosApiException::class);
        $this->expectExceptionMessage('Erreur lors de la synchronisation du référentiel');

        // Act
        $this->service->syncReferential(
            TestDaplosEntity::class,
            $type
        );
    }

    public function testGetAvailableReferentials(): void
    {
        // Arrange
        $expectedReferentials = [
            ['id' => 633, 'name' => 'Amendements du sol', 'repository_code' => 'List_SpecifiedSoilSupplement_CodeType', 'count' => 3],
            ['id' => 635, 'name' => 'Caractéristique technique', 'repository_code' => 'List_TechnicalCharacteristic_CodeType', 'count' => 10],
        ];

        $this->apiClient->expects($this->once())
            ->method('getReferentials')
            ->willReturn($expectedReferentials);

        // Act
        $result = $this->service->getAvailableReferentials();

        // Assert
        $this->assertEquals($expectedReferentials, $result);
    }

    public function testGetReferentialDetails(): void
    {
        // Arrange
        $apiData = [
            'referential' => ['id' => 633, 'name' => 'Amendements du sol'],
            'references' => [
                ['id' => 1, 'title' => 'Calcaire', 'reference_code' => 'CAL'],
            ],
        ];

        $this->apiClient->expects($this->once())
            ->method('getReferential')
            ->with(633)
            ->willReturn($apiData);

        // Act
        $result = $this->service->getReferentialDetails(633);

        // Assert
        $this->assertEquals($apiData, $result);
        $this->assertArrayHasKey('referential', $result);
        $this->assertArrayHasKey('references', $result);
    }

    public function testSyncReferentialSkipsInvalidReferences(): void
    {
        // Arrange
        $type = DaplosReferentialType::AMENDEMENTS_DU_SOL;

        $referentialData = [
            'referential' => ['id' => $type->getId(), 'name' => $type->getLabel()],
            'references' => [
                ['title' => 'Sans ID'], // Pas d'ID
                ['id' => null, 'title' => 'ID null'], // ID null
                ['id' => 1, 'title' => 'Valide', 'reference_code' => 'VAL'], // Valide
            ],
        ];

        $this->apiClient->expects($this->once())
            ->method('getReferential')
            ->willReturn($referentialData);

        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')->willReturn(null);

        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($repository);

        $this->entityManager->expects($this->once())
            ->method('beginTransaction');

        // Seulement 1 persist pour la référence valide
        $this->entityManager->expects($this->once())
            ->method('persist');

        $this->entityManager->expects($this->once())
            ->method('commit');

        // Act
        $stats = $this->service->syncReferential(
            TestDaplosEntity::class,
            $type
        );

        // Assert
        $this->assertEquals(1, $stats['created']);
        $this->assertEquals(3, $stats['total']); // Total inclut toutes les références
    }

    public function testSyncAllReferentials(): void
    {
        // Arrange - Préparer les données pour chaque type de référentiel
        $this->apiClient->expects($this->exactly(count(DaplosReferentialType::cases())))
            ->method('getReferential')
            ->willReturnCallback(function (int $id) {
                return [
                    'referential' => ['id' => $id, 'name' => 'Test'],
                    'references' => [
                        ['id' => 1, 'title' => 'Item 1', 'reference_code' => 'IT1'],
                    ],
                ];
            });

        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')->willReturn(null);

        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($repository);

        $this->entityManager->expects($this->exactly(count(DaplosReferentialType::cases())))
            ->method('beginTransaction');

        $this->entityManager->expects($this->exactly(count(DaplosReferentialType::cases())))
            ->method('commit');

        // Act
        $stats = $this->service->syncAllReferentials(TestDaplosEntity::class);

        // Assert
        $this->assertEquals(count(DaplosReferentialType::cases()), $stats['types_synced']);
        $this->assertEquals(count(DaplosReferentialType::cases()), $stats['created']); // 1 item par type
        $this->assertEquals(0, $stats['updated']);
    }
}

/**
 * Classe de test implémentant l'interface DaplosEntityInterface.
 */
class TestDaplosEntity implements DaplosEntityInterface
{
    private ?int $id = null;
    private ?int $daplosId = null;
    private ?string $daplosTitle = null;
    private ?string $daplosReferenceCode = null;
    private ?DaplosReferentialType $referentialType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDaplosId(): ?int
    {
        return $this->daplosId;
    }

    public function setDaplosId(?int $id): static
    {
        $this->daplosId = $id;

        return $this;
    }

    public function getDaplosTitle(): ?string
    {
        return $this->daplosTitle;
    }

    public function setDaplosTitle(?string $title): static
    {
        $this->daplosTitle = $title;

        return $this;
    }

    public function getDaplosReferenceCode(): ?string
    {
        return $this->daplosReferenceCode;
    }

    public function setDaplosReferenceCode(?string $referenceCode): static
    {
        $this->daplosReferenceCode = $referenceCode;

        return $this;
    }

    public function getReferentialType(): ?DaplosReferentialType
    {
        return $this->referentialType;
    }

    public function setReferentialType(?DaplosReferentialType $type): static
    {
        $this->referentialType = $type;

        return $this;
    }
}
