<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Interchange\InterchangeHeader;
use YoanBernabeu\DaplosBundle\Parser\LineParser\EILineParser;

class EILineParserTest extends TestCase
{
    private EILineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new EILineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('EI', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('EI'));
        $this->assertFalse($this->parser->supports('DE'));
        $this->assertFalse($this->parser->supports('ei'));
    }

    public function testParse(): void
    {
        $line = 'EI1234567890123456789012345678901234567890EMIT123456  DEST654321  ';

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(InterchangeHeader::class, $result);
    }

    public function testParseWithMinimalData(): void
    {
        $line = 'EI                                                                  ';

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(InterchangeHeader::class, $result);
        $this->assertNull($result->identificationEmetteur);
        $this->assertNull($result->identificationDestinataire);
    }
}
