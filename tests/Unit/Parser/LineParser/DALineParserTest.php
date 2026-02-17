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

    public function testParseExtractsFullPacageNumber(): void
    {
        // Construction d'une ligne DA réaliste (272 chars comme dans les vrais fichiers)
        $line = 'DA' // 1-2: FLAG
            .'TF' // 3-4: Type intervenant
            .' ' // 5: Espace
            .'79238844900011   ' // 6-22: SIRET (17 an)
            .'107' // 23-25: Type identification
            .str_pad('SCEA DES VILLENEUVE', 35) // 26-60: Raison sociale 1
            .str_repeat(' ', 35) // 61-95: Raison sociale 2
            .str_pad('LES QUATRE VENTS', 35) // 96-130: Adresse rue 1
            .str_repeat(' ', 35) // 131-165: Adresse rue 2
            .str_pad('Rousson', 35) // 166-200: Ville
            .str_pad('89500', 9) // 201-209: Code postal
            .'FR' // 210-211: Code pays
            .str_repeat(' ', 9) // 212-220: Code commune
            .str_pad('089161019', 20, ' ', STR_PAD_LEFT) // 221-240: Numero package (20 an)
            .str_repeat(' ', 32); // 241-272: Padding

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(Intervenant::class, $result);
        $this->assertSame('TF', $result->typeIntervenant);
        $this->assertSame('79238844900011', $result->identification);
        $this->assertSame('107', $result->typeIdentification);
        $this->assertSame('SCEA DES VILLENEUVE', $result->raisonSociale1);
        $this->assertSame('LES QUATRE VENTS', $result->adresseRue1);
        $this->assertSame('Rousson', $result->ville);
        $this->assertSame('89500', $result->codePostal);
        $this->assertSame('FR', $result->codePays);
        $this->assertNull($result->codeCommune);
        $this->assertSame('089161019', $result->numeroPackage);
        $this->assertTrue($result->isExploitant());
    }

    public function testParseWithDifferentPacageNumbers(): void
    {
        $pacageNumbers = ['089012052', '089010194', '089153656'];

        foreach ($pacageNumbers as $pacage) {
            $line = 'DA'
                .'TF'
                .' '
                .str_pad('12345678901234', 17)
                .'107'
                .str_pad('Test Exploitation', 35)
                .str_repeat(' ', 35)
                .str_repeat(' ', 35)
                .str_repeat(' ', 35)
                .str_pad('Ville', 35)
                .str_pad('89000', 9)
                .'FR'
                .str_repeat(' ', 9)
                .str_pad($pacage, 20, ' ', STR_PAD_LEFT)
                .str_repeat(' ', 32);

            $result = $this->parser->parse($line, 1);

            $this->assertSame($pacage, $result->numeroPackage, "Le numéro de pacage $pacage devrait être extrait en entier");
        }
    }

    public function testParseWithNullPacage(): void
    {
        $line = 'DA'
            .'FR'
            .' '
            .str_pad('43040691800028', 17)
            .'107'
            .str_pad('Maferme', 35)
            .str_repeat(' ', 35)
            .str_repeat(' ', 35)
            .str_repeat(' ', 35)
            .str_repeat(' ', 35)
            .str_repeat(' ', 9)
            .'FR'
            .str_repeat(' ', 9)
            .str_repeat(' ', 20)
            .str_repeat(' ', 32);

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(Intervenant::class, $result);
        $this->assertSame('FR', $result->typeIntervenant);
        $this->assertNull($result->numeroPackage);
        $this->assertTrue($result->isFournisseur());
    }
}
