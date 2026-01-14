<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\DaplosDocument;
use YoanBernabeu\DaplosBundle\Parser\DaplosFileParser;
use YoanBernabeu\DaplosBundle\Parser\Exception\InvalidFlagException;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DALineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DELineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DPLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DTLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\EILineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PVLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\VILineParser;
use YoanBernabeu\DaplosBundle\Parser\Registry\LineParserRegistry;

class DaplosFileParserTest extends TestCase
{
    private DaplosFileParser $parser;

    protected function setUp(): void
    {
        $registry = new LineParserRegistry([
            new EILineParser(),
            new DELineParser(),
            new DALineParser(),
            new DTLineParser(),
            new DPLineParser(),
            new PVLineParser(),
            new VILineParser(),
        ]);

        $this->parser = new DaplosFileParser($registry);
    }

    public function testParseEmptyString(): void
    {
        $result = $this->parser->parseString('');

        $this->assertInstanceOf(DaplosDocument::class, $result);
        $this->assertCount(0, $result->parcelles);
        $this->assertNull($result->interchange);
        $this->assertNull($result->header);
    }

    public function testParseMinimalDocument(): void
    {
        // Version à la fin de la ligne pour être detectée par extractVersionFromEnd
        $content = "EI\nDE                                   0.95";

        $result = $this->parser->parseString($content);

        $this->assertInstanceOf(DaplosDocument::class, $result);
        $this->assertNotNull($result->interchange);
        $this->assertNotNull($result->header);
        $this->assertSame('0.95', $result->getVersion());
    }

    public function testParseWithParcelle(): void
    {
        // Ligne DP avec code espèce à la position 47-49 (après 32 espaces pour pos 15-46)
        $dpLine = 'DP00001   2024'.str_repeat(' ', 32).'ZDH'.str_repeat(' ', 91);
        $content = "EI\nDE                                   0.95\n".$dpLine;

        $result = $this->parser->parseString($content);

        $this->assertCount(1, $result->parcelles);
        $parcelle = $result->parcelles[0];
        $this->assertSame('00001', $parcelle->identifiant);
        $this->assertSame(2024, $parcelle->annee);
        $this->assertSame('ZDH', $parcelle->codeEspeceBotanique);
    }

    public function testParseWithMultipleParcelles(): void
    {
        $dpLine1 = 'DP00001   2024'.str_repeat(' ', 32).'ZDH'.str_repeat(' ', 91);
        $dpLine2 = 'DP00002   2024'.str_repeat(' ', 32).'ZAR'.str_repeat(' ', 91);
        $content = "EI\nDE                                   0.95\n".$dpLine1."\n".$dpLine2;

        $result = $this->parser->parseString($content);

        $this->assertCount(2, $result->parcelles);
        $this->assertSame('00001', $result->parcelles[0]->identifiant);
        $this->assertSame('00002', $result->parcelles[1]->identifiant);
    }

    public function testParseWithUnknownFlagThrowsException(): void
    {
        $content = <<<DAPLOS
            EI
            XX Invalid line
            DAPLOS;

        $this->expectException(InvalidFlagException::class);
        $this->expectExceptionMessage('XX');

        $this->parser->parseString($content);
    }

    public function testParseWithIgnoreUnknownFlags(): void
    {
        $registry = new LineParserRegistry([
            new EILineParser(),
            new DELineParser(),
        ]);

        $parser = new DaplosFileParser($registry, 'auto', true);

        $content = <<<DAPLOS
            EI
            DE0.95    TEST
            XX Unknown flag line
            DAPLOS;

        $result = $parser->parseString($content);

        $this->assertInstanceOf(DaplosDocument::class, $result);
        $this->assertNotNull($result->interchange);
    }

    public function testParseIgnoresEmptyLines(): void
    {
        $content = "EI\n\nDE                                   0.95\n\n";

        $result = $this->parser->parseString($content);

        $this->assertInstanceOf(DaplosDocument::class, $result);
        $this->assertNotNull($result->interchange);
        $this->assertNotNull($result->header);
    }

    public function testCountInterventions(): void
    {
        $dpLine = 'DP00001   2024'.str_repeat(' ', 24).'ZDH'.str_repeat(' ', 99);
        // PV: pos 3-10 identifiant, 11-14 annee, 15-46 refIntervention (32), 47-49 codeIntervention
        $pvLine1 = 'PV00001   2024ABCD1234567890ABCD1234567890ABZG7';
        $pvLine2 = 'PV00001   2024EFGH5678901234EFGH5678901234EFZF8';
        $content = "EI\nDE                                   0.95\n".$dpLine."\n".$pvLine1."\n".$pvLine2;

        $result = $this->parser->parseString($content);

        $this->assertSame(2, $result->countInterventions());
    }
}
