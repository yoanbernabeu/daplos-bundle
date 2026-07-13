<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Analyse;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PALineParser;

class PALineParserTest extends TestCase
{
    private PALineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new PALineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('PA', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('PA'));
        $this->assertFalse($this->parser->supports('PV'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG PA p. 29),
     * tous les champs renseignés, positions exactes (longueur totale 260).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(260, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(Analyse::class, $result);

        // Positions 3-10 : identifiant composite (n° ordre 3-6 + réf parcelle 7-10)
        $this->assertSame('000266', $result->identifiantParcelle);
        // Positions 11-14 : année prévue de récolte
        $this->assertSame(2025, $result->annee);
        // Positions 15-49 : n° de bordereau d'analyse de sol
        $this->assertSame('BORD-2025-000123', $result->numeroBordereau);
        // Positions 50-58 : identification du laboratoire d'analyse (SIREN)
        $this->assertSame('123456789', $result->identificationLaboratoire);
        // Positions 59-93 : raison sociale (1) — laboratoire
        $this->assertSame('Laboratoire AgroSol', $result->laboratoireRaisonSociale1);
        // Positions 94-128 : raison sociale (2)
        $this->assertSame('Departement analyses', $result->laboratoireRaisonSociale2);
        // Positions 129-163 : adresse rue (1)
        $this->assertSame('5 avenue des Sciences', $result->laboratoireAdresseRue1);
        // Positions 164-198 : adresse rue (2)
        $this->assertSame('ZI du Parc', $result->laboratoireAdresseRue2);
        // Positions 199-233 : ville
        $this->assertSame('Dijon', $result->laboratoireVille);
        // Positions 234-242 : code postal
        $this->assertSame('21000', $result->laboratoireCodePostal);
        // Positions 243-244 : pays (code ISO)
        $this->assertSame('FR', $result->laboratoirePays);
        // Positions 245-252 : date d'analyse (SSAAMMJJ)
        $this->assertSame('20250320', $result->dateAnalyse?->format('Ymd'));
        // Positions 253-260 : date de prélèvement (SSAAMMJJ)
        $this->assertSame('20250305', $result->datePrelevement?->format('Ymd'));

        // Champ hors guide v0.95 : plus jamais rempli
        $this->assertNull($result->typeAnalyse);
    }

    /**
     * Ligne issue d'un fichier réel (seuls le n° de bordereau et les dates
     * sont renseignés).
     */
    public function testParseRealWorldLine(): void
    {
        $line = 'PA000266  2025'
            .str_pad('9', 35)
            .str_repeat(' ', 195)
            .'20090821'
            .'20090715';

        $this->assertSame(260, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('000266', $result->identifiantParcelle);
        $this->assertSame(2025, $result->annee);
        $this->assertSame('9', $result->numeroBordereau);
        $this->assertNull($result->identificationLaboratoire);
        $this->assertNull($result->laboratoireRaisonSociale1);
        $this->assertNull($result->laboratoirePays);
        $this->assertSame('20090821', $result->dateAnalyse?->format('Ymd'));
        $this->assertSame('20090715', $result->datePrelevement?->format('Ymd'));
        $this->assertNull($result->typeAnalyse);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        $line = 'PA000266  2025'.str_pad('BORD-1', 35);

        $result = $this->parser->parse($line, 1);

        $this->assertSame('BORD-1', $result->numeroBordereau);
        $this->assertNull($result->identificationLaboratoire);
        $this->assertNull($result->dateAnalyse);
        $this->assertNull($result->datePrelevement);
    }

    private function buildFullLine(): string
    {
        return 'PA'
            .'0002'                                     // 3-6    n° ordre parcelle
            .'66  '                                     // 7-10   réf parcelle culturale
            .'2025'                                     // 11-14  année prévue de récolte
            .str_pad('BORD-2025-000123', 35)            // 15-49  n° de bordereau
            .'123456789'                                // 50-58  identification du laboratoire
            .str_pad('Laboratoire AgroSol', 35)         // 59-93  raison sociale (1)
            .str_pad('Departement analyses', 35)        // 94-128 raison sociale (2)
            .str_pad('5 avenue des Sciences', 35)       // 129-163 adresse rue (1)
            .str_pad('ZI du Parc', 35)                  // 164-198 adresse rue (2)
            .str_pad('Dijon', 35)                       // 199-233 ville
            .str_pad('21000', 9)                        // 234-242 code postal
            .'FR'                                       // 243-244 pays
            .'20250320'                                 // 245-252 date d'analyse
            .'20250305';                                // 253-260 date de prélèvement
    }
}
