<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DPLineParser;

class DPLineParserTest extends TestCase
{
    private DPLineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new DPLineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('DP', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('DP'));
        $this->assertFalse($this->parser->supports('DE'));
    }

    public function testParse(): void
    {
        // Format selon DPLineParser (positions exactes):
        // Position 1-2: FLAG "DP"
        // Position 3-10: identifiant (8 an)
        // Position 11-14: annee (4 n)
        // Position 15-46: dates et espaces (32 chars)
        // Position 47-49: code espece botanique (3 an)
        // Construisons une ligne avec le code espèce à la position 47
        $line = 'DP00027   2024'.str_repeat(' ', 32).'ZDH'.str_repeat(' ', 91);

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(ParcelleCulturale::class, $result);
        $this->assertSame('00027', $result->identifiant);
        $this->assertSame(2024, $result->annee);
        $this->assertSame('ZDH', $result->codeEspeceBotanique);
    }

    public function testParseWithMinimalData(): void
    {
        $line = 'DP00001   2024';

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(ParcelleCulturale::class, $result);
        $this->assertSame('00001', $result->identifiant);
        $this->assertSame(2024, $result->annee);
    }
}
