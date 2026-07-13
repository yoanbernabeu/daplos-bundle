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

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG EI p. 8),
     * tous les champs renseignés, positions exactes (longueur totale 40).
     */
    public function testParseFullLine(): void
    {
        $line = 'EI'
            .'38176508000027'  // 3-16  identification émetteur (an14)
            .'005'             // 17-19 type codification émetteur (an3)
            .'43040691800028'  // 20-33 identification destinataire (an14)
            .'5  '             // 34-36 type codification destinataire (an3)
            .'0012';           // 37-40 nombre de documents dans l'envoi (n4)

        $this->assertSame(40, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(InterchangeHeader::class, $result);
        $this->assertSame('38176508000027', $result->identificationEmetteur);
        $this->assertSame('005', $result->typeCodificationEmetteur);
        $this->assertSame('43040691800028', $result->identificationDestinataire);
        $this->assertSame('5', $result->typeCodificationDestinataire);
        $this->assertSame(12, $result->nombreDocuments);

        // Champs fictifs hors guide v0.95 : plus jamais remplis
        $this->assertNull($result->dateHeurePreparation);
        $this->assertNull($result->referenceInterchange);
    }

    /**
     * Ligne issue d'un fichier réel (Export Geofolia).
     */
    public function testParseRealWorldLine(): void
    {
        $line = 'EI38176508000027005381765080000270050001';

        $this->assertSame(40, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('38176508000027', $result->identificationEmetteur);
        $this->assertSame('005', $result->typeCodificationEmetteur);
        $this->assertSame('38176508000027', $result->identificationDestinataire);
        $this->assertSame('005', $result->typeCodificationDestinataire);
        $this->assertSame(1, $result->nombreDocuments);
        $this->assertNull($result->dateHeurePreparation);
        $this->assertNull($result->referenceInterchange);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        $line = 'EI43040691800028';

        $result = $this->parser->parse($line, 1);

        $this->assertSame('43040691800028', $result->identificationEmetteur);
        $this->assertNull($result->typeCodificationEmetteur);
        $this->assertNull($result->identificationDestinataire);
        $this->assertNull($result->typeCodificationDestinataire);
        $this->assertNull($result->nombreDocuments);
    }

    public function testParseWithMinimalData(): void
    {
        $line = 'EI'.str_repeat(' ', 38);

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(InterchangeHeader::class, $result);
        $this->assertNull($result->identificationEmetteur);
        $this->assertNull($result->identificationDestinataire);
        $this->assertNull($result->nombreDocuments);
    }
}
