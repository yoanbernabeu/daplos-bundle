<?php

namespace YoanBernabeu\DaplosBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use YoanBernabeu\DaplosBundle\Client\DaplosApiClient;
use YoanBernabeu\DaplosBundle\Client\DaplosApiClientInterface;
use YoanBernabeu\DaplosBundle\Command\GenerateEntityCommand;
use YoanBernabeu\DaplosBundle\Command\ListReferentialsCommand;
use YoanBernabeu\DaplosBundle\Command\ParseDaplosFileCommand;
use YoanBernabeu\DaplosBundle\Command\ShowReferentialCommand;
use YoanBernabeu\DaplosBundle\Command\SyncReferentialCommand;
use YoanBernabeu\DaplosBundle\Exporter\Contract\FileExporterInterface;
use YoanBernabeu\DaplosBundle\Exporter\DaplosFileExporter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\CCLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\DALineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\DELineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\DPLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\DTLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\EILineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\HALineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\IALineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\ICLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\ILLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\LCLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\PALineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\PCLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\PELineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\PHLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\PSLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\PVLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\RLLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\SCLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\VBLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\VCLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\VHLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\VILineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\VRLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\Registry\LineWriterRegistry;
use YoanBernabeu\DaplosBundle\Parser\Contract\FileParserInterface;
use YoanBernabeu\DaplosBundle\Parser\DaplosFileParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\CCLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DALineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DELineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DPLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DTLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\EILineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\HALineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\IALineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\ICLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\ILLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\LCLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PALineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PCLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PELineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PHLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PSLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PVLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\RLLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\SCLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\VBLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\VCLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\VHLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\VILineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\VRLineParser;
use YoanBernabeu\DaplosBundle\Parser\Registry\LineParserRegistry;
use YoanBernabeu\DaplosBundle\Service\EntityGeneratorService;
use YoanBernabeu\DaplosBundle\Service\EntityGeneratorServiceInterface;
use YoanBernabeu\DaplosBundle\Service\ReferentialCodeResolver;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncService;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncServiceInterface;
use YoanBernabeu\DaplosBundle\Validator\ReferentialValidatorInterface;
use YoanBernabeu\DaplosBundle\Validator\StrictReferentialValidator;

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
                ->arrayNode('database')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('schema')
                            ->defaultNull()
                            ->info('Schéma de base de données (pour PostgreSQL)')
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
                ->arrayNode('parser')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('encoding')
                            ->defaultValue('auto')
                            ->info('Encodage des fichiers DAPLOS (auto, UTF-8, ISO-8859-1)')
                        ->end()
                        ->booleanNode('ignore_unknown_flags')
                            ->defaultFalse()
                            ->info('Ignorer les FLAGS inconnus au lieu de lever une exception')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('exporter')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('encoding')
                            ->defaultValue('ISO-8859-1')
                            ->info('Encodage des fichiers DAPLOS exportés (ISO-8859-1 recommandé, les positions du guide sont en octets)')
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
            ->set('yoanbernabeu_daplos.database.schema', $config['database']['schema'])
            ->set('yoanbernabeu_daplos.cache.enabled', $config['cache']['enabled'])
            ->set('yoanbernabeu_daplos.cache.ttl', $config['cache']['ttl'])
            ->set('yoanbernabeu_daplos.parser.encoding', $config['parser']['encoding'])
            ->set('yoanbernabeu_daplos.parser.ignore_unknown_flags', $config['parser']['ignore_unknown_flags'])
            ->set('yoanbernabeu_daplos.exporter.encoding', $config['exporter']['encoding'])
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
                    '%kernel.project_dir%',
                    '%yoanbernabeu_daplos.database.schema%',
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

            ->set(SyncReferentialCommand::class)
                ->args([
                    service(ReferentialSyncServiceInterface::class),
                    service(EntityGeneratorServiceInterface::class),
                ])
                ->tag('console.command')

            // ============================================
            // Parser DAPLOS
            // ============================================

            // Line Parsers (tous taggés pour auto-registration)
            ->set(EILineParser::class)->tag('daplos.line_parser')
            ->set(DELineParser::class)->tag('daplos.line_parser')
            ->set(DALineParser::class)->tag('daplos.line_parser')
            ->set(DTLineParser::class)->tag('daplos.line_parser')
            ->set(DPLineParser::class)->tag('daplos.line_parser')
            ->set(PSLineParser::class)->tag('daplos.line_parser')
            ->set(SCLineParser::class)->tag('daplos.line_parser')
            ->set(PCLineParser::class)->tag('daplos.line_parser')
            ->set(CCLineParser::class)->tag('daplos.line_parser')
            ->set(PELineParser::class)->tag('daplos.line_parser')
            ->set(PHLineParser::class)->tag('daplos.line_parser')
            ->set(HALineParser::class)->tag('daplos.line_parser')
            ->set(PALineParser::class)->tag('daplos.line_parser')
            ->set(PVLineParser::class)->tag('daplos.line_parser')
            ->set(VBLineParser::class)->tag('daplos.line_parser')
            ->set(VHLineParser::class)->tag('daplos.line_parser')
            ->set(VCLineParser::class)->tag('daplos.line_parser')
            ->set(VILineParser::class)->tag('daplos.line_parser')
            ->set(ICLineParser::class)->tag('daplos.line_parser')
            ->set(ILLineParser::class)->tag('daplos.line_parser')
            ->set(IALineParser::class)->tag('daplos.line_parser')
            ->set(VRLineParser::class)->tag('daplos.line_parser')
            ->set(RLLineParser::class)->tag('daplos.line_parser')
            ->set(LCLineParser::class)->tag('daplos.line_parser')

            // Registry des Line Parsers
            ->set(LineParserRegistry::class)
                ->args([
                    tagged_iterator('daplos.line_parser'),
                ])
                ->public()

            // Parser principal
            ->set(DaplosFileParser::class)
                ->args([
                    service(LineParserRegistry::class),
                    '%yoanbernabeu_daplos.parser.encoding%',
                    '%yoanbernabeu_daplos.parser.ignore_unknown_flags%',
                ])
                ->public()

            // Alias pour l'interface du parser
            ->alias(FileParserInterface::class, DaplosFileParser::class)
                ->public()

            // Alias nommé pour le parser
            ->alias('yoanbernabeu_daplos.file_parser', FileParserInterface::class)
                ->public()

            // ============================================
            // Exporter DAPLOS
            // ============================================

            // Line Writers (tous taggés pour auto-registration)
            ->set(EILineWriter::class)->tag('daplos.line_writer')
            ->set(DELineWriter::class)->tag('daplos.line_writer')
            ->set(DALineWriter::class)->tag('daplos.line_writer')
            ->set(DTLineWriter::class)->tag('daplos.line_writer')
            ->set(DPLineWriter::class)->tag('daplos.line_writer')
            ->set(PSLineWriter::class)->tag('daplos.line_writer')
            ->set(SCLineWriter::class)->tag('daplos.line_writer')
            ->set(PCLineWriter::class)->tag('daplos.line_writer')
            ->set(CCLineWriter::class)->tag('daplos.line_writer')
            ->set(PELineWriter::class)->tag('daplos.line_writer')
            ->set(PHLineWriter::class)->tag('daplos.line_writer')
            ->set(HALineWriter::class)->tag('daplos.line_writer')
            ->set(PALineWriter::class)->tag('daplos.line_writer')
            ->set(PVLineWriter::class)->tag('daplos.line_writer')
            ->set(VBLineWriter::class)->tag('daplos.line_writer')
            ->set(VHLineWriter::class)->tag('daplos.line_writer')
            ->set(VCLineWriter::class)->tag('daplos.line_writer')
            ->set(VILineWriter::class)->tag('daplos.line_writer')
            ->set(ICLineWriter::class)->tag('daplos.line_writer')
            ->set(ILLineWriter::class)->tag('daplos.line_writer')
            ->set(IALineWriter::class)->tag('daplos.line_writer')
            ->set(VRLineWriter::class)->tag('daplos.line_writer')
            ->set(RLLineWriter::class)->tag('daplos.line_writer')
            ->set(LCLineWriter::class)->tag('daplos.line_writer')

            // Registry des Line Writers
            ->set(LineWriterRegistry::class)
                ->args([
                    tagged_iterator('daplos.line_writer'),
                ])
                ->public()

            // Exporter principal
            ->set(DaplosFileExporter::class)
                ->args([
                    service(LineWriterRegistry::class),
                    '%yoanbernabeu_daplos.exporter.encoding%',
                ])
                ->public()

            // Alias pour l'interface de l'exporter
            ->alias(FileExporterInterface::class, DaplosFileExporter::class)
                ->public()

            // Alias nommé pour l'exporter
            ->alias('yoanbernabeu_daplos.file_exporter', FileExporterInterface::class)
                ->public()

            // ============================================
            // Validation et résolution des codes
            // ============================================

            // Validateur strict des codes
            ->set(StrictReferentialValidator::class)
                ->args([
                    service('doctrine.orm.entity_manager'),
                ])
                ->public()

            // Alias pour l'interface du validateur
            ->alias(ReferentialValidatorInterface::class, StrictReferentialValidator::class)
                ->public()

            // Alias nommé pour le validateur
            ->alias('yoanbernabeu_daplos.validator', ReferentialValidatorInterface::class)
                ->public()

            // Résolveur de codes référentiels
            ->set(ReferentialCodeResolver::class)
                ->args([
                    service('doctrine.orm.entity_manager'),
                ])
                ->public()

            // Alias nommé pour le résolveur
            ->alias('yoanbernabeu_daplos.code_resolver', ReferentialCodeResolver::class)
                ->public()

            // Commande de parsing
            ->set(ParseDaplosFileCommand::class)
                ->args([service(FileParserInterface::class)])
                ->tag('console.command')
        ;
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
