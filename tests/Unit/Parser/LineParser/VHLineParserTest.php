<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Intervention\HistoriqueDecision;
use YoanBernabeu\DaplosBundle\Parser\LineParser\VHLineParser;

class VHLineParserTest extends TestCase
{
    private VHLineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new VHLineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('VH', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('VH'));
        $this->assertFalse($this->parser->supports('PV'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG VH p. 49-50),
     * tous les champs renseignés, positions exactes (longueur totale 435).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(435, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(HistoriqueDecision::class, $result);

        // Positions 3-10 : identifiant composite (n° ordre 3-6 + réf parcelle 7-10)
        $this->assertSame('000178', $result->identifiantParcelle);
        // Positions 11-14 : année prévue de récolte
        $this->assertSame(2025, $result->annee);
        // Positions 15-46 : référence de l'événement (GUID)
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $result->refIntervention);
        // Positions 47-49 : type de lien (en code, nomenclature Nature du lien)
        $this->assertSame('ZL1', $result->codeTypeLien);
        // Positions 50-81 : référence de l'événement considéré
        $this->assertSame('B2C3D4E5F60718293A4B5C6D7E8F90A1', $result->refEvenementConsidere);
        // Positions 82-85 : n° de la parcelle antérieur
        $this->assertSame('0012', $result->numeroParcelleAnterieur);
        // Positions 86-89 : année de récolte (SSAA de l'événement antérieur)
        $this->assertSame(2024, $result->anneeRecolte);
        // Positions 90-106 : identification exploitation (SIRET ou code adhérent)
        $this->assertSame('12345678900012', $result->identificationExploitation);
        // Positions 107-109 : type d'identification (107 : SIRET, ZZZ : défini mutuellement)
        $this->assertSame('107', $result->codeTypeIdentification);
        // Positions 110-144 : raison sociale (1) de l'exploitation
        $this->assertSame('EARL des Champs', $result->exploitationRaisonSociale1);
        // Positions 145-179 : raison sociale (2) de l'exploitation
        $this->assertSame('Site principal', $result->exploitationRaisonSociale2);
        // Positions 180-214 : adresse rue (1) de l'exploitation
        $this->assertSame('1 route de la Plaine', $result->exploitationAdresse1);
        // Positions 215-249 : adresse rue (2) de l'exploitation
        $this->assertSame('Lieu-dit Les Noues', $result->exploitationAdresse2);
        // Positions 250-284 : ville de l'exploitation
        $this->assertSame('Chartres', $result->exploitationVille);
        // Positions 285-293 : code postal de l'exploitation
        $this->assertSame('28000', $result->exploitationCodePostal);
        // Positions 294-295 : pays de l'exploitation (ISO)
        $this->assertSame('FR', $result->exploitationPays);
        // Positions 296-365 : informations parcelle non EDI (1)
        $this->assertSame('Parcelle historique hors EDI premiere info', $result->infoParcelleNonEdi1);
        // Positions 366-435 : informations parcelle non EDI (2)
        $this->assertSame('Seconde information libre', $result->infoParcelleNonEdi2);

        // Champs hors guide v0.95 : plus jamais remplis par le parser
        $this->assertNull($result->decision);
        $this->assertNull($result->dateDecision);
    }

    /**
     * Ligne réaliste : seul le type de lien (obligatoire) et la référence
     * de l'événement considéré sont renseignés.
     */
    public function testParseLineWithOptionalFieldsEmpty(): void
    {
        $line = 'VH000266  202573FF44DFEB25A3CCB28E157FAD771041'
            .'ZL2'
            .'B2C3D4E5F60718293A4B5C6D7E8F90A1'
            .str_repeat(' ', 435 - 81);

        $this->assertSame(435, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('000266', $result->identifiantParcelle);
        $this->assertSame('ZL2', $result->codeTypeLien);
        $this->assertSame('B2C3D4E5F60718293A4B5C6D7E8F90A1', $result->refEvenementConsidere);
        $this->assertNull($result->numeroParcelleAnterieur);
        $this->assertNull($result->anneeRecolte);
        $this->assertNull($result->identificationExploitation);
        $this->assertNull($result->codeTypeIdentification);
        $this->assertNull($result->exploitationRaisonSociale1);
        $this->assertNull($result->exploitationVille);
        $this->assertNull($result->exploitationPays);
        $this->assertNull($result->infoParcelleNonEdi1);
        $this->assertNull($result->infoParcelleNonEdi2);
        $this->assertNull($result->decision);
        $this->assertNull($result->dateDecision);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        $line = 'VH000178  2025A1B2C3D4E5F60718293A4B5C6D7E8F90'
            .'ZL1'
            .'B2C3D4E5F60718293A4B5C6D7E8F90A1';

        $result = $this->parser->parse($line, 1);

        $this->assertSame('ZL1', $result->codeTypeLien);
        $this->assertSame('B2C3D4E5F60718293A4B5C6D7E8F90A1', $result->refEvenementConsidere);
        $this->assertNull($result->numeroParcelleAnterieur);
        $this->assertNull($result->infoParcelleNonEdi2);
    }

    private function buildFullLine(): string
    {
        return 'VH'
            .'0001'                                                 // 3-6     n° ordre parcelle
            .'78  '                                                 // 7-10    réf parcelle culturale
            .'2025'                                                 // 11-14   année
            .'A1B2C3D4E5F60718293A4B5C6D7E8F90'                     // 15-46   GUID
            .'ZL1'                                                  // 47-49   type de lien
            .'B2C3D4E5F60718293A4B5C6D7E8F90A1'                     // 50-81   réf événement considéré
            .'0012'                                                 // 82-85   n° parcelle antérieur
            .'2024'                                                 // 86-89   année de récolte
            .str_pad('12345678900012', 17)                          // 90-106  identification exploitation
            .'107'                                                  // 107-109 type d'identification
            .str_pad('EARL des Champs', 35)                         // 110-144 raison sociale 1
            .str_pad('Site principal', 35)                          // 145-179 raison sociale 2
            .str_pad('1 route de la Plaine', 35)                    // 180-214 adresse rue 1
            .str_pad('Lieu-dit Les Noues', 35)                      // 215-249 adresse rue 2
            .str_pad('Chartres', 35)                                // 250-284 ville
            .str_pad('28000', 9)                                    // 285-293 code postal
            .'FR'                                                   // 294-295 pays
            .str_pad('Parcelle historique hors EDI premiere info', 70) // 296-365 info parcelle non EDI 1
            .str_pad('Seconde information libre', 70);              // 366-435 info parcelle non EDI 2
    }
}
