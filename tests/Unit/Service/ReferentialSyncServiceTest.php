<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
use YoanBernabeu\DaplosBundle\Client\DaplosApiClientInterface;
use YoanBernabeu\DaplosBundle\Contract\DaplosEntityInterface;
use YoanBernabeu\DaplosBundle\Exception\DaplosApiException;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

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
        // Données de l'API
        $referentialData = [
            'referential' => ['id' => 611, 'name' => 'Cultures'],
            'references' => [
                ['id' => 1, 'title' => 'Blé', 'reference_code' => 'BLE'],
                ['id' => 2, 'title' => 'Maïs', 'reference_code' => 'MAI'],
            ]
        ];

        $this->apiClient->expects($this->once())
            ->method('getReferential')
            ->with(611)
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

        $stats = $this->service->syncReferential(
            TestDaplosEntity::class,
            611
        );

        $this->assertEquals(2, $stats['created']);
        $this->assertEquals(0, $stats['updated']);
        $this->assertEquals(2, $stats['total']);
    }

    public function testSyncReferentialWithExistingEntities(): void
    {
        $referentialData = [
            'referential' => ['id' => 611, 'name' => 'Cultures'],
            'references' => [
                ['id' => 1, 'title' => 'Blé Updated', 'reference_code' => 'BLE'],
            ]
        ];

        $this->apiClient->expects($this->once())
            ->method('getReferential')
            ->with(611)
            ->willReturn($referentialData);

        $existingEntity = new TestDaplosEntity();
        $existingEntity->setDaplosId(1);

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

        $stats = $this->service->syncReferential(
            TestDaplosEntity::class,
            611
        );

        $this->assertEquals(0, $stats['created']);
        $this->assertEquals(1, $stats['updated']);
        $this->assertEquals(1, $stats['total']);
    }

    public function testSyncReferentialWithCustomMapper(): void
    {
        $referentialData = [
            'referential' => ['id' => 611, 'name' => 'Cultures'],
            'references' => [
                ['id' => 1, 'title' => 'Blé', 'reference_code' => 'BLE', 'custom' => 'value'],
            ]
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

        $this->entityManager->expects($this->once())
            ->method('commit');

        $customMapperCalled = false;
        $customMapper = function ($entity, $reference) use (&$customMapperCalled) {
            $customMapperCalled = true;
            $this->assertEquals('value', $reference['custom']);
            return $entity;
        };

        $stats = $this->service->syncReferential(
            TestDaplosEntity::class,
            611,
            $customMapper
        );

        $this->assertTrue($customMapperCalled);
        $this->assertEquals(1, $stats['created']);
    }

    public function testSyncReferentialRollsBackOnError(): void
    {
        $referentialData = [
            'referential' => ['id' => 611, 'name' => 'Cultures'],
            'references' => [
                ['id' => 1, 'title' => 'Blé', 'reference_code' => 'BLE'],
            ]
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

        $this->expectException(DaplosApiException::class);
        $this->expectExceptionMessage('Erreur lors de la synchronisation du référentiel 611');

        $this->service->syncReferential(
            TestDaplosEntity::class,
            611
        );
    }

    public function testGetAvailableReferentials(): void
    {
        $expectedReferentials = [
            ['id' => 611, 'name' => 'Cultures', 'repository_code' => 'List_BotanicalSpecies_CodeType', 'count' => 716],
            ['id' => 633, 'name' => 'Amendements', 'repository_code' => 'List_SoilSupplement_CodeType', 'count' => 3],
        ];

        $this->apiClient->expects($this->once())
            ->method('getReferentials')
            ->willReturn($expectedReferentials);

        $result = $this->service->getAvailableReferentials();

        $this->assertEquals($expectedReferentials, $result);
    }

    public function testGetReferentialDetails(): void
    {
        $expectedData = [
            'referential' => ['id' => 611, 'name' => 'Cultures'],
            'references' => [
                ['id' => 1, 'title' => 'Blé', 'reference_code' => 'BLE'],
            ]
        ];

        $this->apiClient->expects($this->once())
            ->method('getReferential')
            ->with(611)
            ->willReturn($expectedData);

        $result = $this->service->getReferentialDetails(611);

        $this->assertEquals($expectedData, $result);
    }

    public function testSyncReferentialSkipsInvalidReferences(): void
    {
        $referentialData = [
            'referential' => ['id' => 611, 'name' => 'Cultures'],
            'references' => [
                ['title' => 'Sans ID'], // Pas d'ID
                ['id' => null, 'title' => 'ID null'], // ID null
                ['id' => 1, 'title' => 'Valide', 'reference_code' => 'VAL'], // Valide
            ]
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

        $stats = $this->service->syncReferential(
            TestDaplosEntity::class,
            611
        );

        $this->assertEquals(1, $stats['created']);
        $this->assertEquals(3, $stats['total']); // Total inclut toutes les références
    }
}

// Classe de test implémentant l'interface DaplosEntityInterface
class TestDaplosEntity implements DaplosEntityInterface
{
    private ?int $id = null;
    private ?int $daplosId = null;
    private ?string $daplosTitle = null;
    private ?string $daplosReferenceCode = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDaplosId(): ?int
    {
        return $this->daplosId;
    }

    public function setDaplosId(?int $id): self
    {
        $this->daplosId = $id;
        return $this;
    }

    public function getDaplosTitle(): ?string
    {
        return $this->daplosTitle;
    }

    public function setDaplosTitle(?string $title): self
    {
        $this->daplosTitle = $title;
        return $this;
    }

    public function getDaplosReferenceCode(): ?string
    {
        return $this->daplosReferenceCode;
    }

    public function setDaplosReferenceCode(?string $referenceCode): self
    {
        $this->daplosReferenceCode = $referenceCode;
        return $this;
    }
}

// Classe de test utilisant l'attribut #[DaplosId]
class TestDaplosEntityWithAttribute
{
    private ?int $id = null;

    #[DaplosId]
    private ?int $culturesId = null;
    private ?string $culturesTitle = null;
    private ?string $culturesReferenceCode = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCulturesId(): ?int
    {
        return $this->culturesId;
    }

    public function setCulturesId(?int $id): self
    {
        $this->culturesId = $id;
        return $this;
    }

    public function getCulturesTitle(): ?string
    {
        return $this->culturesTitle;
    }

    public function setCulturesTitle(?string $title): self
    {
        $this->culturesTitle = $title;
        return $this;
    }

    public function getCulturesReferenceCode(): ?string
    {
        return $this->culturesReferenceCode;
    }

    public function setCulturesReferenceCode(?string $referenceCode): self
    {
        $this->culturesReferenceCode = $referenceCode;
        return $this;
    }
}


