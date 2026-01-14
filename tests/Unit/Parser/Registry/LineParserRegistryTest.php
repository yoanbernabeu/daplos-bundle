<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\Registry;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\Parser\Contract\LineParserInterface;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DPLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\EILineParser;
use YoanBernabeu\DaplosBundle\Parser\Registry\LineParserRegistry;

class LineParserRegistryTest extends TestCase
{
    public function testRegisterAndGet(): void
    {
        $eiParser = new EILineParser();
        $dpParser = new DPLineParser();

        $registry = new LineParserRegistry([$eiParser, $dpParser]);

        $this->assertTrue($registry->has('EI'));
        $this->assertTrue($registry->has('DP'));
        $this->assertFalse($registry->has('XX'));

        $this->assertSame($eiParser, $registry->get('EI'));
        $this->assertSame($dpParser, $registry->get('DP'));
    }

    public function testGetUnknownFlagThrowsException(): void
    {
        $registry = new LineParserRegistry([new EILineParser()]);

        $this->expectException(\YoanBernabeu\DaplosBundle\Parser\Exception\InvalidFlagException::class);
        $registry->get('XX');
    }

    public function testFindParserForLineReturnsNullForUnknownFlag(): void
    {
        $registry = new LineParserRegistry([new EILineParser()]);

        $this->assertNull($registry->findParserForLine('XX unknown'));
    }

    public function testGetSupportedFlags(): void
    {
        $eiParser = new EILineParser();
        $dpParser = new DPLineParser();

        $registry = new LineParserRegistry([$eiParser, $dpParser]);

        $flags = $registry->getSupportedFlags();

        $this->assertContains('EI', $flags);
        $this->assertContains('DP', $flags);
        $this->assertCount(2, $flags);
    }

    public function testRegisterMultipleParsers(): void
    {
        $parsers = [
            new EILineParser(),
            new DPLineParser(),
        ];

        $registry = new LineParserRegistry($parsers);

        $this->assertCount(2, $registry->getSupportedFlags());
    }

    public function testRegisterWithCustomParser(): void
    {
        $customParser = $this->createMock(LineParserInterface::class);
        $customParser->expects($this->once())
            ->method('getFlag')
            ->willReturn('XX');

        $registry = new LineParserRegistry([$customParser]);

        $this->assertTrue($registry->has('XX'));
        $this->assertSame($customParser, $registry->get('XX'));
    }
}
