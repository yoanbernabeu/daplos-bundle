<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Recolte\Recolte;
use YoanBernabeu\DaplosBundle\Parser\LineParser\VRLineParser;

class VRLineParserTest extends TestCase
{
    private VRLineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new VRLineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('VR', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('VR'));
        $this->assertFalse($this->parser->supports('RL'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG VR p. 45-46),
     * tous les champs renseignés, positions exactes (longueur totale 126).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(126, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(Recolte::class, $result);

        // Positions 3-10 : identifiant composite (n° ordre 3-6 + réf parcelle 7-10)
        $this->assertSame('000178', $result->identifiantParcelle);
        // Positions 11-14 : année prévue de récolte
        $this->assertSame(2025, $result->annee);
        // Positions 15-46 : référence de l'événement (GUID)
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $result->refIntervention);
        // Positions 47-49 : produit principal ou co-produit
        $this->assertSame('ZJH', $result->codeTypeProduitRecolte);
        // Positions 50-52 : code produit récolté (nomenclature espèce botanique)
        $this->assertSame('ZAR', $result->codeEspeceBotanique);
        // Positions 53-87 : libellé du produit
        $this->assertSame('Ble tendre', $result->libelleProduit);
        // Positions 88-90 : destination produit ou co-produit (en code)
        $this->assertSame('ZG1', $result->destinationProduit);
        // Positions 91-99 : quantité récoltée
        $this->assertSame(218.178, $result->quantite);
        // Positions 100-102 : unité de mesure
        $this->assertSame('TNE', $result->codeUnite);
        // Positions 103-111 : rendement calculé
        $this->assertSame(7.5, $result->rendementCalcule);
        // Positions 112-114 : unité de mesure du rendement calculé
        $this->assertSame('TNE', $result->codeUniteRendementCalcule);
        // Positions 115-123 : rendement estimé
        $this->assertSame(8.1, $result->rendementEstime);
        // Positions 124-126 : unité de mesure du rendement estimé
        $this->assertSame('TNE', $result->codeUniteRendementEstime);
    }

    /**
     * Ligne issue d'un fichier réel (champs facultatifs vides, longueur 126).
     */
    public function testParseRealWorldLine(): void
    {
        $line = 'VR000266  202573FF44DFEB25A3CCB28E157FAD771041ZJHZBE'
            .str_pad('Colza', 35)
            .'   '        // 88-90  destination (vide)
            .'00218.178'  // 91-99  quantité récoltée
            .'TNE'        // 100-102 unité
            .str_repeat(' ', 24); // 103-126 rendements (vides)

        $this->assertSame(126, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('000266', $result->identifiantParcelle);
        $this->assertSame(2025, $result->annee);
        $this->assertSame('73FF44DFEB25A3CCB28E157FAD771041', $result->refIntervention);
        $this->assertSame('ZJH', $result->codeTypeProduitRecolte);
        $this->assertSame('ZBE', $result->codeEspeceBotanique);
        $this->assertSame('Colza', $result->libelleProduit);
        $this->assertNull($result->destinationProduit);
        $this->assertSame(218.178, $result->quantite);
        $this->assertSame('TNE', $result->codeUnite);
        $this->assertNull($result->rendementCalcule);
        $this->assertNull($result->codeUniteRendementCalcule);
        $this->assertNull($result->rendementEstime);
        $this->assertNull($result->codeUniteRendementEstime);
    }

    /**
     * L'unité ne doit plus être devinée par regex : une occurrence de « TNE »
     * dans le libellé du produit ne doit pas polluer la quantité ni l'unité.
     */
    public function testParseDoesNotGuessQuantityFromLabel(): void
    {
        $line = 'VR000266  202573FF44DFEB25A3CCB28E157FAD771041ZJHZBE'
            .str_pad('Melange 10 TNE divers', 35)
            .'   '
            .str_repeat(' ', 9)
            .'   '
            .str_repeat(' ', 24);

        $this->assertSame(126, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('Melange 10 TNE divers', $result->libelleProduit);
        $this->assertNull($result->quantite);
        $this->assertNull($result->codeUnite);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        $line = 'VR000178  2025A1B2C3D4E5F60718293A4B5C6D7E8F90ZJHZAR'
            .str_pad('Ble tendre', 35);

        $result = $this->parser->parse($line, 1);

        $this->assertSame('Ble tendre', $result->libelleProduit);
        $this->assertNull($result->quantite);
        $this->assertNull($result->codeUnite);
        $this->assertNull($result->rendementCalcule);
        $this->assertNull($result->rendementEstime);
    }

    private function buildFullLine(): string
    {
        return 'VR'
            .'0001'                                 // 3-6     n° ordre parcelle
            .'78  '                                 // 7-10    réf parcelle culturale
            .'2025'                                 // 11-14   année
            .'A1B2C3D4E5F60718293A4B5C6D7E8F90'     // 15-46   GUID
            .'ZJH'                                  // 47-49   produit principal ou co-produit
            .'ZAR'                                  // 50-52   code produit récolté
            .str_pad('Ble tendre', 35)              // 53-87   libellé du produit
            .'ZG1'                                  // 88-90   destination produit
            .'00218.178'                            // 91-99   quantité récoltée
            .'TNE'                                  // 100-102 unité de mesure
            .'00007.500'                            // 103-111 rendement calculé
            .'TNE'                                  // 112-114 unité de mesure
            .'00008.100'                            // 115-123 rendement estimé
            .'TNE';                                 // 124-126 unité de mesure
    }
}
