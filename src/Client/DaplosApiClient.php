<?php

namespace YoanBernabeu\DaplosBundle\Client;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use YoanBernabeu\DaplosBundle\Exception\DaplosApiException;
use YoanBernabeu\DaplosBundle\Exception\DaplosAuthException;
use YoanBernabeu\DaplosBundle\Exception\DaplosNotFoundException;
use YoanBernabeu\DaplosBundle\Exception\DaplosRateLimitException;
use YoanBernabeu\DaplosBundle\Exception\DaplosServerException;

/**
 * Client pour l'API DAPLOS.
 */
class DaplosApiClient implements DaplosApiClientInterface
{
    private const CACHE_TAG = 'daplos_cache';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly ?CacheInterface $cache,
        private readonly string $baseUrl,
        private readonly string $login,
        private readonly string $apikey,
        private readonly bool $cacheEnabled,
        private readonly int $cacheTtl
    ) {
    }

    /**
     * Récupère la liste de tous les référentiels disponibles.
     *
     * @return array<int, array{id: int, count: int, name: string, repository_code: string, repository_explanation: string}>
     *
     * @throws DaplosApiException
     */
    public function getReferentials(): array
    {
        $cacheKey = 'daplos_referentials_list';

        if ($this->cacheEnabled && $this->cache) {
            return $this->cache->get($cacheKey, function (ItemInterface $item) {
                $item->expiresAfter($this->cacheTtl);
                if ($this->cache instanceof TagAwareCacheInterface) {
                    $item->tag(self::CACHE_TAG);
                }

                return $this->fetchReferentials();
            });
        }

        return $this->fetchReferentials();
    }

    /**
     * Récupère les détails d'un référentiel spécifique avec ses références.
     *
     * @param int $referentialId ID du référentiel
     *
     * @return array{referential: array<string, mixed>, references: array<int, array<string, mixed>>}
     *
     * @throws DaplosApiException
     */
    public function getReferential(int $referentialId): array
    {
        $cacheKey = sprintf('daplos_referential_%d', $referentialId);

        if ($this->cacheEnabled && $this->cache) {
            return $this->cache->get($cacheKey, function (ItemInterface $item) use ($referentialId) {
                $item->expiresAfter($this->cacheTtl);
                if ($this->cache instanceof TagAwareCacheInterface) {
                    $item->tag(self::CACHE_TAG);
                }

                return $this->fetchReferential($referentialId);
            });
        }

        return $this->fetchReferential($referentialId);
    }

    /**
     * Effectue l'appel API pour récupérer tous les référentiels.
     *
     * @return array<int, array<string, mixed>>
     *
     * @throws DaplosApiException
     */
    private function fetchReferentials(): array
    {
        try {
            $url = sprintf(
                '%s/referencials/?login=%s&apikey=%s',
                rtrim($this->baseUrl, '/'),
                urlencode($this->login),
                urlencode($this->apikey)
            );

            $response = $this->httpClient->request('GET', $url);
            $statusCode = $response->getStatusCode();

            if (200 !== $statusCode) {
                $this->throwHttpException($statusCode, 'Erreur API DAPLOS');
            }

            $data = $response->toArray();

            if (!is_array($data)) {
                throw new DaplosApiException('La réponse de l\'API n\'est pas un tableau valide');
            }

            return $data;
        } catch (TransportExceptionInterface $e) {
            throw new DaplosApiException(sprintf('Erreur de communication avec l\'API DAPLOS : %s', $e->getMessage()), 0, $e);
        } catch (\Exception $e) {
            if ($e instanceof DaplosApiException) {
                throw $e;
            }

            throw new DaplosApiException(sprintf('Erreur lors de la récupération des référentiels : %s', $e->getMessage()), 0, $e);
        }
    }

    /**
     * Effectue l'appel API pour récupérer un référentiel spécifique.
     *
     * @return array{referential: array<string, mixed>, references: array<int, array<string, mixed>>}
     *
     * @throws DaplosApiException
     */
    private function fetchReferential(int $referentialId): array
    {
        try {
            $url = sprintf(
                '%s/referencials/%d/?login=%s&apikey=%s',
                rtrim($this->baseUrl, '/'),
                $referentialId,
                urlencode($this->login),
                urlencode($this->apikey)
            );

            $response = $this->httpClient->request('GET', $url);
            $statusCode = $response->getStatusCode();

            if (200 !== $statusCode) {
                $this->throwHttpException(
                    $statusCode,
                    sprintf('Erreur API DAPLOS pour le référentiel %d', $referentialId)
                );
            }

            $data = $response->toArray();

            if (!is_array($data)) {
                throw new DaplosApiException(sprintf('Structure de données invalide pour le référentiel %d : la réponse n\'est pas un tableau. Type reçu: %s', $referentialId, get_debug_type($data)));
            }

            // L'API DAPLOS utilise "referencial" (sans 't') au lieu de "referential"
            // On normalise pour avoir toujours "referential" dans notre code
            if (isset($data['referencial']) && !isset($data['referential'])) {
                $data['referential'] = $data['referencial'];
                unset($data['referencial']);
            }

            // Vérification de la structure
            if (!isset($data['referential']) || !isset($data['references'])) {
                $keys = implode(', ', array_keys($data));
                $sample = json_encode(array_slice($data, 0, 3), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                throw new DaplosApiException(sprintf('Structure de données invalide pour le référentiel %d. Clés attendues : [referential, references]. Clés reçues : [%s]. Échantillon des données : %s', $referentialId, $keys, $sample));
            }

            return $data;
        } catch (TransportExceptionInterface $e) {
            throw new DaplosApiException(sprintf('Erreur de communication avec l\'API DAPLOS pour le référentiel %d : %s', $referentialId, $e->getMessage()), 0, $e);
        } catch (\Exception $e) {
            if ($e instanceof DaplosApiException) {
                throw $e;
            }

            throw new DaplosApiException(sprintf('Erreur lors de la récupération du référentiel %d : %s', $referentialId, $e->getMessage()), 0, $e);
        }
    }

    /**
     * Invalide le cache d'un référentiel spécifique.
     */
    public function clearReferentialCache(int $referentialId): void
    {
        if ($this->cache) {
            $cacheKey = sprintf('daplos_referential_%d', $referentialId);
            $this->cache->delete($cacheKey);
        }
    }

    /**
     * Invalide tout le cache des référentiels.
     */
    public function clearAllCache(): void
    {
        if ($this->cache instanceof TagAwareCacheInterface) {
            $this->cache->invalidateTags([self::CACHE_TAG]);
        } elseif ($this->cache) {
            // Fallback si le cache ne supporte pas les tags
            $this->cache->delete('daplos_referentials_list');
        }
    }

    /**
     * Lance l'exception appropriée selon le code HTTP.
     *
     * @throws DaplosApiException
     */
    private function throwHttpException(int $statusCode, string $message): never
    {
        $fullMessage = sprintf('%s : code HTTP %d', $message, $statusCode);

        throw match ($statusCode) {
            401, 403 => new DaplosAuthException($fullMessage),
            404 => new DaplosNotFoundException($fullMessage),
            429 => new DaplosRateLimitException($fullMessage),
            500, 502, 503 => new DaplosServerException($fullMessage),
            default => new DaplosApiException($fullMessage),
        };
    }
}
