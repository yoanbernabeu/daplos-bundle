<?php

namespace YoanBernabeu\DaplosBundle\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use YoanBernabeu\DaplosBundle\Exporter\DaplosFileExporter;
use YoanBernabeu\DaplosBundle\YoanBernabeuDaplosBundle;

class YoanBernabeuDaplosBundleTest extends TestCase
{
    public function testBundleCanBeInstantiated(): void
    {
        $bundle = new YoanBernabeuDaplosBundle();
        $this->assertInstanceOf(YoanBernabeuDaplosBundle::class, $bundle);
    }

    public function testGetPath(): void
    {
        $bundle = new YoanBernabeuDaplosBundle();
        $path = $bundle->getPath();

        $this->assertDirectoryExists($path);
    }

    public function testExporterIsNotStrictByDefault(): void
    {
        $container = $this->loadBundle([]);

        $this->assertFalse($container->getParameter('yoanbernabeu_daplos.exporter.fail_on_truncation'));
        $this->assertSame(
            '%yoanbernabeu_daplos.exporter.fail_on_truncation%',
            $container->getDefinition(DaplosFileExporter::class)->getArgument(2),
        );
    }

    public function testExporterCanFailOnTruncation(): void
    {
        $container = $this->loadBundle(['fail_on_truncation' => true]);

        $this->assertTrue($container->getParameter('yoanbernabeu_daplos.exporter.fail_on_truncation'));
    }

    /**
     * @param array<string, mixed> $exporterConfig
     */
    private function loadBundle(array $exporterConfig): ContainerBuilder
    {
        $container = new ContainerBuilder(new ParameterBag([
            'kernel.environment' => 'test',
            'kernel.build_dir' => sys_get_temp_dir(),
            'kernel.debug' => false,
            'kernel.project_dir' => sys_get_temp_dir(),
        ]));
        $extension = (new YoanBernabeuDaplosBundle())->getContainerExtension();
        $this->assertNotNull($extension);
        $extension->load([[
            'api' => ['login' => 'test', 'apikey' => 'test'],
            'exporter' => $exporterConfig,
        ]], $container);

        return $container;
    }
}
