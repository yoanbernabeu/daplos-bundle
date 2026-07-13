<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Coordonnee;
use YoanBernabeu\DaplosBundle\Parser\LineParser\VCLineParser;

class VCLineParserTest extends TestCase
{
    private VCLineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new VCLineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('VC', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('VC'));
        $this->assertFalse($this->parser->supports('VB'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG VC p. 34),
     * tous les champs renseignés, positions exactes (longueur totale 88).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(88, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(Coordonnee::class, $result);

        // Positions 3-10 : identifiant composite (n° ordre 3-6 + réf parcelle 7-10)
        $this->assertSame('000178', $result->identifiantParcelle);
        // Positions 11-14 : année prévue de récolte
        $this->assertSame(2025, $result->annee);
        // Positions 15-46 : référence de l'événement (GUID)
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $result->refIntervention);
        // Positions 47-49 : qualifiant de la position géographique (4 = WGS84)
        $this->assertSame('4', $result->systemeCoordonnees);
        // Positions 50-60 : longitude (an 11, 7 entiers « . » 3 décimales)
        $this->assertSame(2345.678, $result->x);
        // Positions 61-70 : latitude (an 10, 7 entiers « . » 2 décimales)
        $this->assertSame(48762.98, $result->y);
        // Positions 71-88 : altitude (n..18, 7 entiers « . » 3 décimales)
        $this->assertSame(123.456, $result->altitude);
        // Champ propre au FLAG CC, jamais rempli par VC
        $this->assertNull($result->numeroParcelleCadastrale);
    }

    /**
     * Ligne réaliste sans altitude (champ facultatif).
     */
    public function testParseLineWithoutAltitude(): void
    {
        $line = substr($this->buildFullLine(), 0, 70).str_repeat(' ', 18);

        $this->assertSame(88, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame(2345.678, $result->x);
        $this->assertSame(48762.98, $result->y);
        $this->assertNull($result->altitude);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        // Ligne s'arrêtant au qualifiant (position 49)
        $line = 'VC000178  2025A1B2C3D4E5F60718293A4B5C6D7E8F90  4';

        $result = $this->parser->parse($line, 1);

        $this->assertSame('4', $result->systemeCoordonnees);
        $this->assertNull($result->x);
        $this->assertNull($result->y);
        $this->assertNull($result->altitude);
    }

    private function buildFullLine(): string
    {
        return 'VC'
            .'0001'                              // 3-6   n° ordre parcelle
            .'78  '                              // 7-10  réf parcelle culturale
            .'2025'                              // 11-14 année
            .'A1B2C3D4E5F60718293A4B5C6D7E8F90'  // 15-46 GUID
            .'  4'                               // 47-49 qualifiant position géographique
            .'0002345.678'                       // 50-60 longitude (11 car.)
            .'0048762.98'                        // 61-70 latitude (10 car.)
            .'00000000000123.456';               // 71-88 altitude (18 car.)
    }
}
