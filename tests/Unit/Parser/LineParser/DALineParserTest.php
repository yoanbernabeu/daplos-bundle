<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Document\Intervenant;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DALineParser;

class DALineParserTest extends TestCase
{
    private DALineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new DALineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('DA', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('DA'));
        $this->assertFalse($this->parser->supports('DP'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG DA p. 10-11),
     * tous les champs renseignés, positions exactes (longueur totale 271).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(271, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(Intervenant::class, $result);
        // Positions 3-5 : qualifiant intervenant (an3)
        $this->assertSame('TF', $result->typeIntervenant);
        // Positions 6-22 : identification de l'intervenant (an17)
        $this->assertSame('79238844900011', $result->identification);
        // Positions 23-25 : type d'identification en code (an3)
        $this->assertSame('107', $result->typeIdentification);
        // Positions 26-60 / 61-95 : raisons sociales (an35)
        $this->assertSame('SCEA DES VILLENEUVE', $result->raisonSociale1);
        $this->assertSame('EXPLOITATION BIS', $result->raisonSociale2);
        // Positions 96-130 / 131-165 : adresses rue (an35)
        $this->assertSame('LES QUATRE VENTS', $result->adresseRue1);
        $this->assertSame('LIEU-DIT LE BAS', $result->adresseRue2);
        // Positions 166-200 : ville (an35)
        $this->assertSame('Rousson', $result->ville);
        // Positions 201-209 : code postal (an9)
        $this->assertSame('89500', $result->codePostal);
        // Positions 210-211 : pays (an2)
        $this->assertSame('FR', $result->codePays);
        // Positions 212-231 : 1ère référence complémentaire exploitation (an20)
        $this->assertSame('REF-EXPLOIT-001', $result->referenceComplementaire1);
        // Positions 232-251 : n° Pacage (an20)
        $this->assertSame('089161019', $result->numeroPackage);
        // Positions 252-271 : code MSA (an20)
        $this->assertSame('MSA-1234567', $result->codeMSA);

        // Champ fictif hors guide v0.95 : plus jamais rempli
        $this->assertNull($result->codeCommune);

        $this->assertTrue($result->isExploitant());
    }

    /**
     * Ligne issue d'un fichier réel (Export Geofolia, pacage à gauche du champ 232-251).
     */
    public function testParseRealWorldLine(): void
    {
        $line = 'DA'
            .'TF '
            .'38176508000027   '
            .'107'
            .str_pad('SCEA DE LA PLANTE JACQUES', 35)
            .str_repeat(' ', 35)
            .str_pad('BOUY NEUF', 35)
            .str_repeat(' ', 35)
            .str_pad('BRIENON-SUR-ARMANCON', 35)
            .str_pad('89210', 9)
            .'FR'
            .str_repeat(' ', 20)          // 212-231 : 1ère référence complémentaire (vide)
            .str_pad('089153656', 20)     // 232-251 : n° Pacage
            .str_repeat(' ', 20);         // 252-271 : code MSA (vide)

        $this->assertSame(271, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('TF', $result->typeIntervenant);
        $this->assertSame('38176508000027', $result->identification);
        $this->assertSame('107', $result->typeIdentification);
        $this->assertSame('SCEA DE LA PLANTE JACQUES', $result->raisonSociale1);
        $this->assertSame('BOUY NEUF', $result->adresseRue1);
        $this->assertSame('BRIENON-SUR-ARMANCON', $result->ville);
        $this->assertSame('89210', $result->codePostal);
        $this->assertSame('FR', $result->codePays);
        $this->assertNull($result->referenceComplementaire1);
        $this->assertSame('089153656', $result->numeroPackage);
        $this->assertNull($result->codeMSA);
        $this->assertNull($result->codeCommune);
        $this->assertTrue($result->isExploitant());
    }

    public function testParseWithDifferentPacageNumbers(): void
    {
        $pacageNumbers = ['089012052', '089010194', '089153656'];

        foreach ($pacageNumbers as $pacage) {
            $line = substr_replace($this->buildFullLine(), str_pad($pacage, 20), 231, 20);

            $result = $this->parser->parse($line, 1);

            $this->assertSame($pacage, $result->numeroPackage, "Le numéro de pacage $pacage devrait être extrait en entier");
        }
    }

    public function testParseWithNullPacage(): void
    {
        $line = 'DA'
            .'FR '
            .str_pad('43040691800028', 17)
            .'107'
            .str_pad('Maferme', 35)
            .str_repeat(' ', 35)
            .str_repeat(' ', 35)
            .str_repeat(' ', 35)
            .str_repeat(' ', 35)
            .str_repeat(' ', 9)
            .'FR'
            .str_repeat(' ', 20)
            .str_repeat(' ', 20)
            .str_repeat(' ', 20);

        $this->assertSame(271, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(Intervenant::class, $result);
        $this->assertSame('FR', $result->typeIntervenant);
        $this->assertNull($result->numeroPackage);
        $this->assertNull($result->referenceComplementaire1);
        $this->assertNull($result->codeMSA);
        $this->assertTrue($result->isFournisseur());
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        $line = 'DAMR '.str_pad('30254061900094', 17).'107';

        $result = $this->parser->parse($line, 1);

        $this->assertSame('MR', $result->typeIntervenant);
        $this->assertSame('30254061900094', $result->identification);
        $this->assertSame('107', $result->typeIdentification);
        $this->assertNull($result->raisonSociale1);
        $this->assertNull($result->numeroPackage);
        $this->assertTrue($result->isMandataire());
    }

    private function buildFullLine(): string
    {
        return 'DA'
            .'TF '                                    // 3-5     qualifiant intervenant
            .str_pad('79238844900011', 17)            // 6-22    identification (SIRET)
            .'107'                                    // 23-25   type d'identification
            .str_pad('SCEA DES VILLENEUVE', 35)       // 26-60   raison sociale 1
            .str_pad('EXPLOITATION BIS', 35)          // 61-95   raison sociale 2
            .str_pad('LES QUATRE VENTS', 35)          // 96-130  adresse rue 1
            .str_pad('LIEU-DIT LE BAS', 35)           // 131-165 adresse rue 2
            .str_pad('Rousson', 35)                   // 166-200 ville
            .str_pad('89500', 9)                      // 201-209 code postal
            .'FR'                                     // 210-211 pays
            .str_pad('REF-EXPLOIT-001', 20)           // 212-231 1ère référence complémentaire
            .str_pad('089161019', 20)                 // 232-251 n° Pacage
            .str_pad('MSA-1234567', 20);              // 252-271 code MSA
    }
}
