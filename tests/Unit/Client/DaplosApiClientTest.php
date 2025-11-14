<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Client;

use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use YoanBernabeu\DaplosBundle\Client\DaplosApiClient;
use YoanBernabeu\DaplosBundle\Exception\DaplosApiException;

class DaplosApiClientTest extends TestCase
{
    private HttpClientInterface $httpClient;
    private CacheInterface $cache;
    private DaplosApiClient $client;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpClientInterface::class);
        $this->cache = $this->createMock(CacheInterface::class);

        $this->client = new DaplosApiClient(
            $this->httpClient,
            $this->cache,
            'https://api.test.fr',
            'test_login',
            'test_apikey',
            true,
            3600
        );
    }

    public function testGetReferentialsSuccess(): void
    {
        $expectedData = [
            [
                'id' => 611,
                'name' => 'Cultures',
                'repository_code' => 'List_BotanicalSpecies_CodeType',
                'count' => 716,
                'repository_explanation' => '',
            ],
        ];

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);
        $response->expects($this->once())
            ->method('toArray')
            ->willReturn($expectedData);

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', 'https://api.test.fr/referencials/?login=test_login&apikey=test_apikey')
            ->willReturn($response);

        $this->cache->expects($this->once())
            ->method('get')
            ->willReturnCallback(function ($key, $callback) {
                return $callback($this->createMock(\Symfony\Contracts\Cache\ItemInterface::class));
            });

        $result = $this->client->getReferentials();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals(611, $result[0]['id']);
        $this->assertEquals('Cultures', $result[0]['name']);
    }

    public function testGetReferentialsWithNon200StatusCode(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(404);

        $this->httpClient->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $this->cache->expects($this->once())
            ->method('get')
            ->willReturnCallback(function ($key, $callback) {
                return $callback($this->createMock(\Symfony\Contracts\Cache\ItemInterface::class));
            });

        $this->expectException(DaplosApiException::class);
        $this->expectExceptionMessage('Erreur API DAPLOS : code HTTP 404');

        $this->client->getReferentials();
    }

    public function testGetReferentialSuccess(): void
    {
        $referentialId = 611;
        $expectedData = [
            'referential' => [
                'id' => 611,
                'name' => 'Cultures',
                'repository_code' => 'List_BotanicalSpecies_CodeType',
            ],
            'references' => [
                ['id' => 1, 'title' => 'Blé', 'reference_code' => 'BLE'],
                ['id' => 2, 'title' => 'Maïs', 'reference_code' => 'MAI'],
            ],
        ];

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);
        $response->expects($this->once())
            ->method('toArray')
            ->willReturn($expectedData);

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', "https://api.test.fr/referencials/{$referentialId}/?login=test_login&apikey=test_apikey")
            ->willReturn($response);

        $this->cache->expects($this->once())
            ->method('get')
            ->willReturnCallback(function ($key, $callback) {
                return $callback($this->createMock(\Symfony\Contracts\Cache\ItemInterface::class));
            });

        $result = $this->client->getReferential($referentialId);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('referential', $result);
        $this->assertArrayHasKey('references', $result);
        $this->assertCount(2, $result['references']);
    }

    public function testGetReferentialWithInvalidStructure(): void
    {
        $referentialId = 611;
        $invalidData = ['some' => 'data']; // Manque 'referential' et 'references'

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);
        $response->expects($this->once())
            ->method('toArray')
            ->willReturn($invalidData);

        $this->httpClient->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $this->cache->expects($this->once())
            ->method('get')
            ->willReturnCallback(function ($key, $callback) {
                return $callback($this->createMock(\Symfony\Contracts\Cache\ItemInterface::class));
            });

        $this->expectException(DaplosApiException::class);
        $this->expectExceptionMessage("Structure de données invalide pour le référentiel {$referentialId}");

        $this->client->getReferential($referentialId);
    }

    public function testClearReferentialCache(): void
    {
        $referentialId = 611;

        $this->cache->expects($this->once())
            ->method('delete')
            ->with('daplos_referential_611');

        $this->client->clearReferentialCache($referentialId);
    }

    public function testClearAllCache(): void
    {
        $this->cache->expects($this->once())
            ->method('delete')
            ->with('daplos_referentials_list');

        $this->client->clearAllCache();
    }

    public function testGetReferentialsWithoutCache(): void
    {
        $clientWithoutCache = new DaplosApiClient(
            $this->httpClient,
            null, // Pas de cache
            'https://api.test.fr',
            'test_login',
            'test_apikey',
            false, // Cache désactivé
            3600
        );

        $expectedData = [
            ['id' => 611, 'name' => 'Cultures', 'repository_code' => 'List_BotanicalSpecies_CodeType', 'count' => 716, 'repository_explanation' => ''],
        ];

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);
        $response->expects($this->once())
            ->method('toArray')
            ->willReturn($expectedData);

        $this->httpClient->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $result = $clientWithoutCache->getReferentials();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
    }
}
