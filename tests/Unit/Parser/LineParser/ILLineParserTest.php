<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Intrant\LotFabricant;
use YoanBernabeu\DaplosBundle\Parser\LineParser\ILLineParser;

class ILLineParserTest extends TestCase
{
    private ILLineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new ILLineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('IL', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('IL'));
        $this->assertFalse($this->parser->supports('IC'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG IL p. 43),
     * tous les champs renseignés, positions exactes (longueur totale 140).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(140, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(LotFabricant::class, $result);

        // Positions 3-10 : identifiant composite (n° ordre 3-6 + réf parcelle 7-10)
        $this->assertSame('000178', $result->identifiantParcelle);
        // Positions 11-14 : année prévue de récolte
        $this->assertSame(2025, $result->annee);
        // Positions 15-46 : référence de l'événement (GUID)
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $result->refIntervention);
        // Positions 47-81 : code produit (idem enregistrement VI)
        $this->assertSame('580G491', $result->codeProduit);
        // Positions 82-116 : n° de lot du fabricant de l'intrant
        $this->assertSame('LOT-2025-0042', $result->numeroLot);
        // Positions 117-125 : quantité par lot (9 n)
        $this->assertSame(3970.7704, $result->quantite);
        // Positions 126-128 : unité de mesure
        $this->assertSame('LTR', $result->codeUnite);
        // Positions 129-137 : PMG, poids de mille grains (9 n)
        $this->assertSame(45.5, $result->pmg);
        // Positions 138-140 : unité de mesure du PMG
        $this->assertSame('KGM', $result->codeUnitePmg);
        // Champ hors guide, plus jamais rempli
        $this->assertNull($result->indexLot);
    }

    /**
     * Ligne issue d'un fichier réel (longueur 140) : code produit vide,
     * n° de lot « 0 », quantité + unité renseignées, PMG vide.
     */
    public function testParseRealWorldLine(): void
    {
        $line = 'IL000266  202561FF2E493F5AE091B344A27313DA1D43'
            .str_repeat(' ', 35)          // 47-81  code produit vide
            .str_pad('0', 35)             // 82-116 n° de lot
            .'3970.7704'                  // 117-125 quantité par lot
            .'LTR'                        // 126-128 unité
            .str_repeat(' ', 9)           // 129-137 PMG vide
            .str_repeat(' ', 3);          // 138-140 unité PMG vide

        $this->assertSame(140, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('000266', $result->identifiantParcelle);
        $this->assertSame(2025, $result->annee);
        $this->assertSame('61FF2E493F5AE091B344A27313DA1D43', $result->refIntervention);
        $this->assertNull($result->codeProduit);
        $this->assertSame('0', $result->numeroLot);
        $this->assertSame(3970.7704, $result->quantite);
        $this->assertSame('LTR', $result->codeUnite);
        $this->assertNull($result->pmg);
        $this->assertNull($result->codeUnitePmg);
        $this->assertNull($result->indexLot);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        // Ligne s'arrêtant au code produit (position 81)
        $line = 'IL000178  2025A1B2C3D4E5F60718293A4B5C6D7E8F90'.str_pad('580G491', 35);

        $result = $this->parser->parse($line, 1);

        $this->assertSame('580G491', $result->codeProduit);
        $this->assertNull($result->numeroLot);
        $this->assertNull($result->quantite);
        $this->assertNull($result->codeUnite);
        $this->assertNull($result->pmg);
        $this->assertNull($result->codeUnitePmg);
    }

    private function buildFullLine(): string
    {
        return 'IL'
            .'0001'                              // 3-6    n° ordre parcelle
            .'78  '                              // 7-10   réf parcelle culturale
            .'2025'                              // 11-14  année
            .'A1B2C3D4E5F60718293A4B5C6D7E8F90'  // 15-46  GUID
            .str_pad('580G491', 35)              // 47-81  code produit
            .str_pad('LOT-2025-0042', 35)        // 82-116 n° de lot fabricant
            .'3970.7704'                         // 117-125 quantité par lot
            .'LTR'                               // 126-128 unité de mesure
            .'000045.50'                         // 129-137 PMG
            .'KGM';                              // 138-140 unité de mesure PMG
    }
}
