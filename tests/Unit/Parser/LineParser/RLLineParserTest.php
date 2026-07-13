<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Recolte\LotRecolte;
use YoanBernabeu\DaplosBundle\Parser\LineParser\RLLineParser;

class RLLineParserTest extends TestCase
{
    private RLLineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new RLLineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('RL', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('RL'));
        $this->assertFalse($this->parser->supports('VR'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG RL p. 47),
     * tous les champs renseignés, positions exactes (longueur totale 125).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(125, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(LotRecolte::class, $result);

        // Positions 3-10 : identifiant composite (n° ordre 3-6 + réf parcelle 7-10)
        $this->assertSame('000178', $result->identifiantParcelle);
        // Positions 11-14 : année prévue de récolte
        $this->assertSame(2025, $result->annee);
        // Positions 15-46 : référence de l'événement (GUID)
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $result->refIntervention);
        // Positions 47-81 : n° de lot OS (Organisme Stockeur)
        $this->assertSame('LOT-OS-2025-001', $result->numeroLot);
        // Positions 82-116 : n° de lot Agriculteur
        $this->assertSame('LOT-FERME-42', $result->numeroLotAgriculteur);
        // Positions 117-125 : quantité du lot (en tonnes)
        $this->assertSame(123.456, $result->quantite);

        // Champ hors guide v0.95 (pas d'unité dans le FLAG RL) : plus jamais rempli
        $this->assertNull($result->codeUnite);
    }

    /**
     * Ligne issue d'un fichier réel : tous les champs facultatifs vides
     * (longueur 125, uniquement les identifiants).
     */
    public function testParseRealWorldLine(): void
    {
        $line = 'RL000266  202573FF44DFEB25A3CCB28E157FAD771041'
            .str_repeat(' ', 79);

        $this->assertSame(125, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('000266', $result->identifiantParcelle);
        $this->assertSame(2025, $result->annee);
        $this->assertSame('73FF44DFEB25A3CCB28E157FAD771041', $result->refIntervention);
        $this->assertNull($result->numeroLot);
        $this->assertNull($result->numeroLotAgriculteur);
        $this->assertNull($result->quantite);
        $this->assertNull($result->codeUnite);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        $line = 'RL000178  2025A1B2C3D4E5F60718293A4B5C6D7E8F90'
            .str_pad('LOT-OS-2025-001', 35);

        $result = $this->parser->parse($line, 1);

        $this->assertSame('LOT-OS-2025-001', $result->numeroLot);
        $this->assertNull($result->numeroLotAgriculteur);
        $this->assertNull($result->quantite);
    }

    private function buildFullLine(): string
    {
        return 'RL'
            .'0001'                                 // 3-6     n° ordre parcelle
            .'78  '                                 // 7-10    réf parcelle culturale
            .'2025'                                 // 11-14   année
            .'A1B2C3D4E5F60718293A4B5C6D7E8F90'     // 15-46   GUID
            .str_pad('LOT-OS-2025-001', 35)         // 47-81   n° de lot OS
            .str_pad('LOT-FERME-42', 35)            // 82-116  n° de lot Agriculteur
            .'00123.456';                           // 117-125 quantité du lot
    }
}
