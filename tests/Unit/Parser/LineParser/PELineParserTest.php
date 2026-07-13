<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Engagement;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PELineParser;

class PELineParserTest extends TestCase
{
    private PELineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new PELineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('PE', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('PE'));
        $this->assertFalse($this->parser->supports('PH'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG PE p. 24),
     * tous les champs renseignés, positions exactes (longueur totale 298).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(298, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(Engagement::class, $result);

        // Positions 3-10 : identifiant composite (n° ordre 3-6 + réf parcelle 7-10)
        $this->assertSame('000178', $result->identifiantParcelle);
        // Positions 11-14 : année prévue de récolte
        $this->assertSame(2025, $result->annee);
        // Positions 15-17 : code engagement (en code)
        $this->assertSame('TPA', $result->codeEngagement);
        // Positions 18-52 : libellé autre contrat
        $this->assertSame('Contrat agriculture durable', $result->libelle);
        // Positions 53-87 : n° de contrat
        $this->assertSame('CTR-2025-00042', $result->numeroContrat);
        // Positions 88-95 : date du contrat (SSAAMMJJ)
        $this->assertSame('20250115', $result->dateContrat?->format('Ymd'));
        // Positions 96-109 : identification du contractant (EAN ou SIRET)
        $this->assertSame('12345678901234', $result->identificationContractant);
        // Positions 110-112 : type d'identification (en code)
        $this->assertSame('107', $result->typeIdentificationContractant);
        // Positions 113-147 : raison sociale (1)
        $this->assertSame('Cooperative AgriValley', $result->contractantRaisonSociale1);
        // Positions 148-182 : raison sociale (2)
        $this->assertSame('Service contrats', $result->contractantRaisonSociale2);
        // Positions 183-217 : adresse rue (1)
        $this->assertSame('12 rue des Champs', $result->contractantAdresseRue1);
        // Positions 218-252 : adresse rue (2)
        $this->assertSame('Batiment B', $result->contractantAdresseRue2);
        // Positions 253-287 : ville
        $this->assertSame('Auxerre', $result->contractantVille);
        // Positions 288-296 : code postal
        $this->assertSame('89000', $result->contractantCodePostal);
        // Positions 297-298 : pays (code ISO)
        $this->assertSame('FR', $result->contractantPays);
    }

    /**
     * Ligne issue d'un fichier réel (code engagement vide, libellé autre
     * contrat tronqué à 35 caractères par l'émetteur).
     */
    public function testParseRealWorldLine(): void
    {
        $line = 'PE000178  2024   '
            .str_pad('Mesures Agro-Environnementales et C', 35)
            .str_repeat(' ', 246);

        $this->assertSame(298, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('000178', $result->identifiantParcelle);
        $this->assertSame(2024, $result->annee);
        $this->assertNull($result->codeEngagement);
        $this->assertSame('Mesures Agro-Environnementales et C', $result->libelle);
        $this->assertNull($result->numeroContrat);
        $this->assertNull($result->dateContrat);
        $this->assertNull($result->identificationContractant);
        $this->assertNull($result->contractantRaisonSociale1);
        $this->assertNull($result->contractantPays);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        $line = 'PE000178  2025ZB1'.str_pad('Contrat HVE', 35);

        $result = $this->parser->parse($line, 1);

        $this->assertSame('ZB1', $result->codeEngagement);
        $this->assertSame('Contrat HVE', $result->libelle);
        $this->assertNull($result->numeroContrat);
        $this->assertNull($result->dateContrat);
        $this->assertNull($result->contractantPays);
    }

    private function buildFullLine(): string
    {
        return 'PE'
            .'0001'                                        // 3-6    n° ordre parcelle
            .'78  '                                        // 7-10   réf parcelle culturale
            .'2025'                                        // 11-14  année prévue de récolte
            .'TPA'                                         // 15-17  code engagement
            .str_pad('Contrat agriculture durable', 35)    // 18-52  libellé autre contrat
            .str_pad('CTR-2025-00042', 35)                 // 53-87  n° de contrat
            .'20250115'                                    // 88-95  date du contrat
            .'12345678901234'                              // 96-109 identification du contractant
            .'107'                                         // 110-112 type d'identification
            .str_pad('Cooperative AgriValley', 35)         // 113-147 raison sociale (1)
            .str_pad('Service contrats', 35)               // 148-182 raison sociale (2)
            .str_pad('12 rue des Champs', 35)              // 183-217 adresse rue (1)
            .str_pad('Batiment B', 35)                     // 218-252 adresse rue (2)
            .str_pad('Auxerre', 35)                        // 253-287 ville
            .str_pad('89000', 9)                           // 288-296 code postal
            .'FR';                                         // 297-298 pays
    }
}
