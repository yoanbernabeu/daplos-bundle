<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Document\DocumentHeader;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DELineParser;

class DELineParserTest extends TestCase
{
    private DELineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new DELineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('DE', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('DE'));
        $this->assertFalse($this->parser->supports('EI'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG DE p. 9),
     * tous les champs renseignés, positions exactes (longueur totale 54).
     */
    public function testParseFullLine(): void
    {
        $line = 'DE'
            .str_pad('REF-DOC-2025-001', 35) // 3-37  référence du document (an35)
            .'7'                             // 38    fonction en code (an1) — 7 duplicata / 9 original
            .'20251007'                      // 39-46 date du document (n8) SSAAMMJJ
            .'0041'                          // 47-50 nombre de fiches parcellaires (n4)
            .'0.95';                         // 51-54 n° de version du message (an4)

        $this->assertSame(54, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(DocumentHeader::class, $result);
        $this->assertSame('REF-DOC-2025-001', $result->referenceDocument);
        $this->assertSame('7', $result->codeFonction);
        $this->assertSame('20251007', $result->dateHeureDocument?->format('Ymd'));
        $this->assertSame(41, $result->nombreFichesParcellaires);
        $this->assertSame('0.95', $result->versionFormat);

        // Champs fictifs hors guide v0.95 : plus jamais remplis
        $this->assertNull($result->codeTypeMessage);
        $this->assertNull($result->codeStatutMessage);
        $this->assertNull($result->dateDebutPeriode);
        $this->assertNull($result->dateFinPeriode);
    }

    /**
     * Ligne issue d'un fichier réel (fonction « 9 » = original).
     */
    public function testParseRealWorldLine(): void
    {
        $line = 'DE                                   92025100700410.95';

        $this->assertSame(54, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertNull($result->referenceDocument);
        $this->assertSame('9', $result->codeFonction);
        $this->assertSame('20251007', $result->dateHeureDocument?->format('Ymd'));
        $this->assertSame(41, $result->nombreFichesParcellaires);
        $this->assertSame('0.95', $result->versionFormat);
    }

    /**
     * Ligne issue d'un fichier réel (fonction vide, version 0.94).
     */
    public function testParseRealWorldLineWithoutFonction(): void
    {
        $line = 'DE                                    2025102700880.94';

        $this->assertSame(54, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertNull($result->referenceDocument);
        $this->assertNull($result->codeFonction);
        $this->assertSame('20251027', $result->dateHeureDocument?->format('Ymd'));
        $this->assertSame(88, $result->nombreFichesParcellaires);
        $this->assertSame('0.94', $result->versionFormat);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        $line = 'DE'.str_pad('REF-COURTE', 35);

        $result = $this->parser->parse($line, 1);

        $this->assertSame('REF-COURTE', $result->referenceDocument);
        $this->assertNull($result->codeFonction);
        $this->assertNull($result->dateHeureDocument);
        $this->assertNull($result->nombreFichesParcellaires);
        $this->assertNull($result->versionFormat);
    }
}
