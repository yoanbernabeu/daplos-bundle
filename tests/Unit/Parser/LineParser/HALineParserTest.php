<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Amendement;
use YoanBernabeu\DaplosBundle\Parser\LineParser\HALineParser;

class HALineParserTest extends TestCase
{
    private HALineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new HALineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('HA', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('HA'));
        $this->assertFalse($this->parser->supports('PH'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG HA p. 27-28),
     * tous les champs renseignés, positions exactes (longueur totale 258).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(258, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(Amendement::class, $result);

        // Positions 3-10 : identifiant composite (n° ordre 3-6 + réf parcelle 7-10)
        $this->assertSame('000154', $result->identifiantParcelle);
        // Positions 11-14 : année prévue de récolte
        $this->assertSame(2025, $result->annee);
        // Positions 15-17 : type d'amendement
        $this->assertSame('ZA5', $result->codeAmendement);
        // Positions 18-52 : complément information sur type amendement
        $this->assertSame('Compost de fumier de bovins', $result->complementTypeAmendement);
        // Positions 53-60 : date de l'amendement (SSAAMMJJ)
        $this->assertSame('20250210', $result->dateAmendement?->format('Ymd'));
        // Positions 61-69 : quantité épandue
        $this->assertSame(12.5, $result->quantite);
        // Positions 70-72 : unité de mesure de la quantité épandue
        $this->assertSame('TNE', $result->codeUnite);
        // Positions 73-107 : raison sociale (1) — origine de l'amendement
        $this->assertSame('EARL des Prairies', $result->origineRaisonSociale1);
        // Positions 108-142 : raison sociale (2)
        $this->assertSame('Atelier compostage', $result->origineRaisonSociale2);
        // Positions 143-177 : adresse rue (1)
        $this->assertSame('3 chemin des Pres', $result->origineAdresseRue1);
        // Positions 178-212 : adresse rue (2)
        $this->assertSame('Lieu-dit Le Bourg', $result->origineAdresseRue2);
        // Positions 213-247 : ville
        $this->assertSame('Toucy', $result->origineVille);
        // Positions 248-256 : code postal
        $this->assertSame('89130', $result->origineCodePostal);
        // Positions 257-258 : pays (code ISO)
        $this->assertSame('FR', $result->originePays);
    }

    /**
     * Ligne réaliste avec champs facultatifs vides (le FLAG HA est absent
     * des fichiers réels disponibles : ligne synthétique).
     */
    public function testParseLineWithOptionalFieldsEmpty(): void
    {
        $line = 'HA000154  2025ZA5'
            .str_repeat(' ', 35)  // complément type amendement
            .str_repeat(' ', 8)   // date de l'amendement
            .'000012.50'
            .'TNE'
            .str_repeat(' ', 186);

        $this->assertSame(258, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('ZA5', $result->codeAmendement);
        $this->assertNull($result->complementTypeAmendement);
        $this->assertNull($result->dateAmendement);
        $this->assertSame(12.5, $result->quantite);
        $this->assertSame('TNE', $result->codeUnite);
        $this->assertNull($result->origineRaisonSociale1);
        $this->assertNull($result->origineVille);
        $this->assertNull($result->originePays);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        $line = 'HA000154  2025ZA5';

        $result = $this->parser->parse($line, 1);

        $this->assertSame('ZA5', $result->codeAmendement);
        $this->assertNull($result->quantite);
        $this->assertNull($result->codeUnite);
        $this->assertNull($result->originePays);
    }

    private function buildFullLine(): string
    {
        return 'HA'
            .'0001'                                        // 3-6    n° ordre parcelle
            .'54  '                                        // 7-10   réf parcelle culturale
            .'2025'                                        // 11-14  année prévue de récolte
            .'ZA5'                                         // 15-17  type d'amendement
            .str_pad('Compost de fumier de bovins', 35)    // 18-52  complément information
            .'20250210'                                    // 53-60  date de l'amendement
            .'000012.50'                                   // 61-69  quantité épandue
            .'TNE'                                         // 70-72  unité de mesure
            .str_pad('EARL des Prairies', 35)              // 73-107 raison sociale (1)
            .str_pad('Atelier compostage', 35)             // 108-142 raison sociale (2)
            .str_pad('3 chemin des Pres', 35)              // 143-177 adresse rue (1)
            .str_pad('Lieu-dit Le Bourg', 35)              // 178-212 adresse rue (2)
            .str_pad('Toucy', 35)                          // 213-247 ville
            .str_pad('89130', 9)                           // 248-256 code postal
            .'FR';                                         // 257-258 pays
    }
}
