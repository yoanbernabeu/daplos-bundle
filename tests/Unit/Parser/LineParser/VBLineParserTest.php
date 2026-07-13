<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Intervention\CibleEvenement;
use YoanBernabeu\DaplosBundle\Parser\LineParser\VBLineParser;

class VBLineParserTest extends TestCase
{
    private VBLineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new VBLineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('VB', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('VB'));
        $this->assertFalse($this->parser->supports('VC'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG VB p. 35),
     * tous les champs renseignés, positions exactes (longueur totale 61).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(61, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(CibleEvenement::class, $result);

        // Positions 3-10 : identifiant composite (n° ordre 3-6 + réf parcelle 7-10)
        $this->assertSame('000178', $result->identifiantParcelle);
        // Positions 11-14 : année prévue de récolte
        $this->assertSame(2025, $result->annee);
        // Positions 15-46 : référence de l'événement (GUID)
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $result->refIntervention);
        // Positions 47-49 : cible de l'intervention v0.94 (codification obsolète)
        $this->assertSame('ZB1', $result->codeOrganismeCible);
        // Positions 50-61 : cible de l'intervention v0.95 (codification prioritaire)
        $this->assertSame('ORGANISME012', $result->codeCibleV095);
        // Champ hors guide, plus jamais rempli
        $this->assertNull($result->codeSousTypeOrganisme);
    }

    /**
     * Ligne issue d'un fichier réel (cibles non renseignées, longueur 61).
     */
    public function testParseRealWorldLine(): void
    {
        $line = 'VB000778  202576F9B08E99A24994BC809AECECBE3FC3'.str_repeat(' ', 15);

        $this->assertSame(61, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('000778', $result->identifiantParcelle);
        $this->assertSame(2025, $result->annee);
        $this->assertSame('76F9B08E99A24994BC809AECECBE3FC3', $result->refIntervention);
        $this->assertNull($result->codeOrganismeCible);
        $this->assertNull($result->codeCibleV095);
        $this->assertNull($result->codeSousTypeOrganisme);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        // Ligne s'arrêtant à la cible v0.94 (position 49)
        $line = 'VB000178  2025A1B2C3D4E5F60718293A4B5C6D7E8F90ZB1';

        $result = $this->parser->parse($line, 1);

        $this->assertSame('ZB1', $result->codeOrganismeCible);
        $this->assertNull($result->codeCibleV095);
    }

    private function buildFullLine(): string
    {
        return 'VB'
            .'0001'                              // 3-6   n° ordre parcelle
            .'78  '                              // 7-10  réf parcelle culturale
            .'2025'                              // 11-14 année
            .'A1B2C3D4E5F60718293A4B5C6D7E8F90'  // 15-46 GUID
            .'ZB1'                               // 47-49 cible v0.94 (obsolète)
            .'ORGANISME012';                     // 50-61 cible v0.95 (prioritaire)
    }
}
