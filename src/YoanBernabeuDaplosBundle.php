<?php

namespace YoanBernabeu\DaplosBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use YoanBernabeu\DaplosBundle\Client\DaplosApiClient;
use YoanBernabeu\DaplosBundle\Client\DaplosApiClientInterface;
use YoanBernabeu\DaplosBundle\Command\GenerateEntityCommand;
use YoanBernabeu\DaplosBundle\Command\ListReferentialsCommand;
use YoanBernabeu\DaplosBundle\Command\ShowReferentialCommand;
use YoanBernabeu\DaplosBundle\Service\EntityGeneratorService;
use YoanBernabeu\DaplosBundle\Service\EntityGeneratorServiceInterface;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncService;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncServiceInterface;

/**
 * Bundle Daplos.
 */
class YoanBernabeuDaplosBundle extends AbstractBundle
{
    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
                ->arrayNode('api')
                    ->isRequired()
                    ->children()
                        ->scalarNode('base_url')
                            ->defaultValue('https://agroedieurope.fr/wp-json/hwc/v1')
                            ->info('URL de base de l\'API DAPLOS')
                        ->end()
                        ->scalarNode('login')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->info('Login pour l\'API DAPLOS')
                        ->end()
                        ->scalarNode('apikey')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->info('Clé API DAPLOS')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('cache')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultTrue()
                            ->info('Activer le cache des référentiels')
                        ->end()
                        ->integerNode('ttl')
                            ->defaultValue(3600)
                            ->info('Durée de vie du cache en secondes')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * @param array<string, mixed> $config
     */
    public function loadExtension(
        array $config,
        ContainerConfigurator $container,
        ContainerBuilder $builder
    ): void {
        // Paramètres
        $container->parameters()
            ->set('yoanbernabeu_daplos.api.base_url', $config['api']['base_url'])
            ->set('yoanbernabeu_daplos.api.login', $config['api']['login'])
            ->set('yoanbernabeu_daplos.api.apikey', $config['api']['apikey'])
            ->set('yoanbernabeu_daplos.cache.enabled', $config['cache']['enabled'])
            ->set('yoanbernabeu_daplos.cache.ttl', $config['cache']['ttl'])
        ;

        // Services
        $container->services()
            // Client API principal
            ->set(DaplosApiClient::class)
                ->args([
                    service('http_client'),
                    service('cache.app')->nullOnInvalid(),
                    '%yoanbernabeu_daplos.api.base_url%',
                    '%yoanbernabeu_daplos.api.login%',
                    '%yoanbernabeu_daplos.api.apikey%',
                    '%yoanbernabeu_daplos.cache.enabled%',
                    '%yoanbernabeu_daplos.cache.ttl%',
                ])
                ->public()

            // Alias pour l'interface du client
            ->alias(DaplosApiClientInterface::class, DaplosApiClient::class)
                ->public()

            // Alias nommé pour le client
            ->alias('yoanbernabeu_daplos.api_client', DaplosApiClientInterface::class)
                ->public()

            // Service de synchronisation
            ->set(ReferentialSyncService::class)
                ->args([
                    service(DaplosApiClientInterface::class),
                    service('doctrine.orm.entity_manager'),
                ])
                ->public()

            // Alias pour l'interface du service de sync
            ->alias(ReferentialSyncServiceInterface::class, ReferentialSyncService::class)
                ->public()

            // Alias nommé pour le service de sync
            ->alias('yoanbernabeu_daplos.sync_service', ReferentialSyncServiceInterface::class)
                ->public()

            // Entity Generator Service
            ->set(EntityGeneratorService::class)
                ->args([
                    service(ReferentialSyncServiceInterface::class),
                    '%kernel.project_dir%',
                ])
                ->public()

            // Alias pour l'interface du service de génération d'entités
            ->alias(EntityGeneratorServiceInterface::class, EntityGeneratorService::class)
                ->public()

            // Alias nommé pour le service de génération d'entités
            ->alias('yoanbernabeu_daplos.entity_generator', EntityGeneratorServiceInterface::class)
                ->public()

            // Commands
            ->set(ListReferentialsCommand::class)
                ->args([service(ReferentialSyncServiceInterface::class)])
                ->tag('console.command')

            ->set(ShowReferentialCommand::class)
                ->args([service(ReferentialSyncServiceInterface::class)])
                ->tag('console.command')

            ->set(GenerateEntityCommand::class)
                ->args([service(EntityGeneratorServiceInterface::class)])
                ->tag('console.command')
        ;
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
