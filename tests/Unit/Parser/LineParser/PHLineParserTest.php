<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Historique;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PHLineParser;

class PHLineParserTest extends TestCase
{
    private PHLineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new PHLineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('PH', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('PH'));
        $this->assertFalse($this->parser->supports('PE'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG PH p. 26-27),
     * tous les champs renseignés, positions exactes (longueur totale 79).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(79, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(Historique::class, $result);

        // Positions 3-10 : identifiant composite (n° ordre 3-6 + réf parcelle 7-10)
        $this->assertSame('000154', $result->identifiantParcelle);
        // Positions 11-14 : année prévue de récolte
        $this->assertSame(2025, $result->annee);
        // Positions 15-16 : n° d'ordre du précédent (-1 à -9)
        $this->assertSame(-1, $result->indexPrecedent);
        // Positions 17-20 : clé de la parcelle du précédent
        $this->assertSame('P154', $result->cleParcellePrecedent);
        // Positions 21-23 : espèce botanique
        $this->assertSame('ZOJ', $result->codeEspeceBotanique);
        // Positions 24-30 à 52-58 : variétés semées (1) à (5)
        $this->assertSame('BLE0001', $result->varieteSemee1);
        $this->assertSame('BLE0002', $result->varieteSemee2);
        $this->assertSame('BLE0003', $result->varieteSemee3);
        $this->assertSame('BLE0004', $result->varieteSemee4);
        $this->assertSame('BLE0005', $result->varieteSemee5);
        // Positions 59-61 : qualifiant d'espèce
        $this->assertSame('ZA1', $result->codeQualifiantEspece);
        // Positions 62-64 : période de semis
        $this->assertSame('ZB2', $result->codePeriodeSemis);
        // Positions 65-67 : destination
        $this->assertSame('ZC3', $result->codeDestination);
        // Positions 68-70 : gestion des résidus
        $this->assertSame('ZD4', $result->codeGestionResidus);
        // Positions 71-79 : quantité épandue (tonne/ha)
        $this->assertSame(3.5, $result->quantiteEpandue);

        // Champs hors guide v0.95 : plus jamais remplis
        $this->assertNull($result->anneePrecedent);
        $this->assertNull($result->codeTraitementResidus);
        $this->assertNull($result->codeModeProduction);
    }

    /**
     * Ligne issue d'un fichier réel (seuls le n° d'ordre du précédent
     * et l'espèce botanique sont renseignés).
     */
    public function testParseRealWorldLine(): void
    {
        $line = 'PH000154  2025-1    ZOJ'.str_repeat(' ', 56);

        $this->assertSame(79, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('000154', $result->identifiantParcelle);
        $this->assertSame(2025, $result->annee);
        $this->assertSame(-1, $result->indexPrecedent);
        $this->assertNull($result->cleParcellePrecedent);
        $this->assertSame('ZOJ', $result->codeEspeceBotanique);
        $this->assertNull($result->varieteSemee1);
        $this->assertNull($result->codeQualifiantEspece);
        $this->assertNull($result->codeGestionResidus);
        $this->assertNull($result->quantiteEpandue);
        $this->assertNull($result->anneePrecedent);
        $this->assertNull($result->codeTraitementResidus);
        $this->assertNull($result->codeModeProduction);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        $line = 'PH000154  2025-2P154ZDH';

        $result = $this->parser->parse($line, 1);

        $this->assertSame(-2, $result->indexPrecedent);
        $this->assertSame('P154', $result->cleParcellePrecedent);
        $this->assertSame('ZDH', $result->codeEspeceBotanique);
        $this->assertNull($result->varieteSemee1);
        $this->assertNull($result->quantiteEpandue);
    }

    private function buildFullLine(): string
    {
        return 'PH'
            .'0001'         // 3-6   n° ordre parcelle
            .'54  '         // 7-10  réf parcelle culturale
            .'2025'         // 11-14 année prévue de récolte
            .'-1'           // 15-16 n° d'ordre du précédent
            .'P154'         // 17-20 clé de la parcelle du précédent
            .'ZOJ'          // 21-23 espèce botanique
            .'BLE0001'      // 24-30 variété semée (1)
            .'BLE0002'      // 31-37 variété semée (2)
            .'BLE0003'      // 38-44 variété semée (3)
            .'BLE0004'      // 45-51 variété semée (4)
            .'BLE0005'      // 52-58 variété semée (5)
            .'ZA1'          // 59-61 qualifiant d'espèce
            .'ZB2'          // 62-64 période de semis
            .'ZC3'          // 65-67 destination
            .'ZD4'          // 68-70 gestion des résidus
            .'000003.50';   // 71-79 quantité épandue
    }
}
