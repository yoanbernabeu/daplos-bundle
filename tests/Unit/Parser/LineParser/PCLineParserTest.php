<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCadastrale;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PCLineParser;

class PCLineParserTest extends TestCase
{
    private PCLineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new PCLineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('PC', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('PC'));
        $this->assertFalse($this->parser->supports('CC'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG PC p. 19-20),
     * tous les champs renseignés, positions exactes (longueur totale 39).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(39, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(ParcelleCadastrale::class, $result);

        // Positions 3-10 : identifiant composite (n° ordre 3-6 + réf parcelle 7-10)
        $this->assertSame('000178', $result->identifiantParcelle);
        // Positions 11-14 : année prévue de récolte
        $this->assertSame(2025, $result->annee);
        // Positions 15-30 : n° parcelle cadastrale (an 16, bloc complet)
        $this->assertSame('077210AB00012301', $result->numeroParcelleCadastrale);
        // Positions 15-20 : département (999) + commune (999) = code INSEE 6 caractères
        $this->assertSame('077210', $result->codeCommune);
        // Positions 21-22 : section (alpha 2)
        $this->assertSame('AB', $result->section);
        // Positions 23-28 : n° de la parcelle dans la section (numérique 6)
        $this->assertSame('000123', $result->numero);
        // Positions 29-30 : subdivision fiscale (alpha 2)
        $this->assertSame('01', $result->subdivisionFiscale);
        // Positions 31-39 : surface de la parcelle cadastrale (n 9, hectares)
        $this->assertSame(12.5, $result->surface);

        // Champ hors guide : plus jamais rempli
        $this->assertNull($result->prefixe);
    }

    /**
     * Ligne réaliste : subdivision fiscale et surface non renseignées.
     */
    public function testParseLineWithOptionalFieldsEmpty(): void
    {
        $line = 'PC'
            .'0002'                 // 3-6   n° ordre parcelle
            .'66  '                 // 7-10  réf parcelle culturale
            .'2024'                 // 11-14 année
            .'089055ZC001234  '     // 15-30 n° parcelle cadastrale sans subdivision
            .str_repeat(' ', 9);    // 31-39 surface absente

        $this->assertSame(39, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('000266', $result->identifiantParcelle);
        $this->assertSame(2024, $result->annee);
        $this->assertSame('089055ZC001234', $result->numeroParcelleCadastrale);
        $this->assertSame('089055', $result->codeCommune);
        $this->assertSame('ZC', $result->section);
        $this->assertSame('001234', $result->numero);
        $this->assertNull($result->subdivisionFiscale);
        $this->assertNull($result->surface);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        $line = 'PC000178  2025';

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(ParcelleCadastrale::class, $result);
        $this->assertSame('000178', $result->identifiantParcelle);
        $this->assertSame(2025, $result->annee);
        $this->assertNull($result->numeroParcelleCadastrale);
        $this->assertNull($result->codeCommune);
        $this->assertNull($result->section);
        $this->assertNull($result->numero);
        $this->assertNull($result->subdivisionFiscale);
        $this->assertNull($result->surface);
    }

    private function buildFullLine(): string
    {
        return 'PC'
            .'0001'                 // 3-6   n° ordre parcelle
            .'78  '                 // 7-10  réf parcelle culturale
            .'2025'                 // 11-14 année prévue de récolte
            .'077210AB00012301'     // 15-30 n° parcelle cadastrale (dept 077, commune 210, section AB, n° 000123, subdivision 01)
            .'0000012.5';           // 31-39 surface (ha)
    }
}
