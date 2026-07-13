<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Intrant\AnalyseEffluent;
use YoanBernabeu\DaplosBundle\Parser\LineParser\IALineParser;

class IALineParserTest extends TestCase
{
    private IALineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new IALineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('IA', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('IA'));
        $this->assertFalse($this->parser->supports('VI'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG IA p. 44),
     * tous les champs renseignés, positions exactes (longueur totale 292).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(292, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(AnalyseEffluent::class, $result);

        // Positions 3-10 : identifiant composite (n° ordre 3-6 + réf parcelle 7-10)
        $this->assertSame('000178', $result->identifiantParcelle);
        // Positions 11-14 : année prévue de récolte
        $this->assertSame(2025, $result->annee);
        // Positions 15-46 : référence de l'événement (GUID)
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $result->refIntervention);
        // Positions 47-81 : n° de bordereau d'analyse
        $this->assertSame('BORD-2025-000123', $result->numeroBordereau);
        // Positions 82-90 : identification du laboratoire d'analyse (SIREN)
        $this->assertSame('123456789', $result->identificationLaboratoire);
        // Positions 91-125 : raison sociale (1) du laboratoire
        $this->assertSame('Laboratoire Agro Ouest', $result->laboratoireRaisonSociale1);
        // Positions 126-160 : raison sociale (2) du laboratoire
        $this->assertSame('Service analyses effluents', $result->laboratoireRaisonSociale2);
        // Positions 161-195 : adresse rue (1) du laboratoire
        $this->assertSame('12 rue des Lilas', $result->laboratoireAdresse1);
        // Positions 196-230 : adresse rue (2) du laboratoire
        $this->assertSame('BP 45', $result->laboratoireAdresse2);
        // Positions 231-265 : ville du laboratoire
        $this->assertSame('Rennes', $result->laboratoireVille);
        // Positions 266-274 : code postal du laboratoire
        $this->assertSame('35000', $result->laboratoireCodePostal);
        // Positions 275-276 : pays du laboratoire (ISO)
        $this->assertSame('FR', $result->laboratoirePays);
        // Positions 277-284 : date d'analyse (SSAAMMJJ)
        $this->assertSame('20250312', $result->dateAnalyse?->format('Ymd'));
        // Positions 285-292 : date de prélèvement (SSAAMMJJ)
        $this->assertSame('20250305', $result->datePrelevement?->format('Ymd'));

        // Champs hors guide v0.95 : plus jamais remplis par le parser
        $this->assertNull($result->typeAnalyse);
        $this->assertNull($result->codeElement);
        $this->assertNull($result->valeur);
        $this->assertNull($result->codeUnite);
    }

    /**
     * Ligne réaliste : seuls le bordereau (obligatoire) et le SIREN sont renseignés.
     */
    public function testParseLineWithOptionalFieldsEmpty(): void
    {
        $line = 'IA'
            .'0002'
            .'66  '
            .'2025'
            .'73FF44DFEB25A3CCB28E157FAD771041'
            .str_pad('BA-42', 35)
            .'987654321'
            .str_repeat(' ', 35 * 5) // raisons sociales, adresses, ville
            .str_repeat(' ', 9)      // code postal
            .str_repeat(' ', 2)      // pays
            .str_repeat(' ', 8)      // date d'analyse
            .str_repeat(' ', 8);     // date de prélèvement

        $this->assertSame(292, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('000266', $result->identifiantParcelle);
        $this->assertSame(2025, $result->annee);
        $this->assertSame('BA-42', $result->numeroBordereau);
        $this->assertSame('987654321', $result->identificationLaboratoire);
        $this->assertNull($result->laboratoireRaisonSociale1);
        $this->assertNull($result->laboratoireRaisonSociale2);
        $this->assertNull($result->laboratoireAdresse1);
        $this->assertNull($result->laboratoireAdresse2);
        $this->assertNull($result->laboratoireVille);
        $this->assertNull($result->laboratoireCodePostal);
        $this->assertNull($result->laboratoirePays);
        $this->assertNull($result->dateAnalyse);
        $this->assertNull($result->datePrelevement);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        $line = 'IA0001'
            .'78  '
            .'2025'
            .'A1B2C3D4E5F60718293A4B5C6D7E8F90'
            .str_pad('BORD-2025-000123', 35);

        $result = $this->parser->parse($line, 1);

        $this->assertSame('BORD-2025-000123', $result->numeroBordereau);
        $this->assertNull($result->identificationLaboratoire);
        $this->assertNull($result->dateAnalyse);
        $this->assertNull($result->datePrelevement);
    }

    private function buildFullLine(): string
    {
        return 'IA'
            .'0001'                                         // 3-6     n° ordre parcelle
            .'78  '                                         // 7-10    réf parcelle culturale
            .'2025'                                         // 11-14   année
            .'A1B2C3D4E5F60718293A4B5C6D7E8F90'             // 15-46   GUID
            .str_pad('BORD-2025-000123', 35)                // 47-81   n° bordereau d'analyse
            .'123456789'                                    // 82-90   SIREN laboratoire
            .str_pad('Laboratoire Agro Ouest', 35)          // 91-125  raison sociale 1
            .str_pad('Service analyses effluents', 35)      // 126-160 raison sociale 2
            .str_pad('12 rue des Lilas', 35)                // 161-195 adresse rue 1
            .str_pad('BP 45', 35)                           // 196-230 adresse rue 2
            .str_pad('Rennes', 35)                          // 231-265 ville
            .str_pad('35000', 9)                            // 266-274 code postal
            .'FR'                                           // 275-276 pays
            .'20250312'                                     // 277-284 date d'analyse
            .'20250305';                                    // 285-292 date de prélèvement
    }
}
