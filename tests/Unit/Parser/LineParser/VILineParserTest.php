<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Intrant\Intrant;
use YoanBernabeu\DaplosBundle\Parser\LineParser\VILineParser;

class VILineParserTest extends TestCase
{
    private VILineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new VILineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('VI', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('VI'));
        $this->assertFalse($this->parser->supports('PV'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG VI p. 36-40),
     * tous les champs renseignés, positions exactes (longueur totale 447).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(447, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(Intrant::class, $result);

        // Positions 3-10 : identifiant composite
        $this->assertSame('000178', $result->identifiantParcelle);
        // Positions 11-14 : année
        $this->assertSame(2025, $result->annee);
        // Positions 15-46 : référence de l'événement
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $result->refIntervention);
        // Positions 47-49 : type d'intrant
        $this->assertSame('ZJB', $result->codeTypeIntrant);
        // Positions 50-119 : libellé intrant (an 70)
        $this->assertSame('Fumier de bovins composte', $result->designation);
        // Positions 120-132 : code EAN du produit
        $this->assertSame('3401234567890', $result->codeEAN);
        // Positions 133-167 : code AMM du produit
        $this->assertSame('2100042', $result->codeAMM);
        // Positions 168-174 : code GNIS
        $this->assertSame('123ABCD', $result->codeGNIS);
        // Positions 175-177 : code apport organique
        $this->assertSame('ZL1', $result->codeApportOrganique);
        // Positions 178-180 : code eau
        $this->assertSame('EAU', $result->codeEAU);
        // Positions 181-183 : code adjuvant
        $this->assertSame('ADJ', $result->codeAdjuvant);
        // Positions 184-186 : code calco-magnésien
        $this->assertSame('ZK5', $result->codeCalcoMagnesien);
        // Positions 187-189 : qualifiant (1) de l'effluent
        $this->assertSame('ZQ1', $result->codeQualifiantIntrant);
        // Positions 190-201 : qualifiants (2) à (5) de l'effluent
        $this->assertSame('ZQ2', $result->codeQualifiantEffluent2);
        $this->assertSame('ZQ3', $result->codeQualifiantEffluent3);
        $this->assertSame('ZQ4', $result->codeQualifiantEffluent4);
        $this->assertSame('ZQ5', $result->codeQualifiantEffluent5);
        // Positions 202-210 : qualifiants semence (1) à (3)
        $this->assertSame('ZQA', $result->codeQualifiantSemence1);
        $this->assertSame('ZS2', $result->codeQualifiantSemence2);
        $this->assertSame('ZS3', $result->codeQualifiantSemence3);
        // Positions 211-219 + 220-222 : quantité totale effective + unité
        $this->assertSame(523.9578, $result->quantite);
        $this->assertSame('KGM', $result->codeUnite);
        // Positions 223-231 + 232-234 : quantité effective par hectare + unité
        $this->assertSame(0.075, $result->quantiteEffectiveHa);
        $this->assertSame('ZKK', $result->codeUniteQuantiteEffectiveHa);
        // Positions 235-243 + 244-246 : dose hectare visée + unité
        $this->assertSame(1.5, $result->doseHaVisee);
        $this->assertSame('LTR', $result->codeUniteDoseHaVisee);
        // Positions 247-252 : nombre de passages préconisés
        $this->assertSame(0.5, $result->nombrePassagesPreconises);
        // Positions 253-287 / 288-322 : raison sociale origine effluent
        $this->assertSame('GAEC DE LA VALLEE', $result->origineEffluentRaisonSociale1);
        $this->assertSame('Site de Montbard', $result->origineEffluentRaisonSociale2);
        // Positions 323-357 / 358-392 : adresse origine effluent
        $this->assertSame('12 route des Champs', $result->origineEffluentAdresse1);
        $this->assertSame('Lieu-dit Les Pres', $result->origineEffluentAdresse2);
        // Positions 393-427 : ville
        $this->assertSame('MONTBARD', $result->origineEffluentVille);
        // Positions 428-436 : code postal
        $this->assertSame('21500', $result->origineEffluentCodePostal);
        // Positions 437-438 : pays
        $this->assertSame('FR', $result->origineEffluentPays);
        // Positions 439-447 : densité volumique
        $this->assertSame(1.3, $result->densiteVolumique);

        // Champ hors guide, déprécié : plus jamais rempli
        $this->assertNull($result->codeVariete);
    }

    /**
     * Ligne issue de fichiers réels : la densité (439-447) est souvent absente
     * (lignes de 438 caractères) — le parser doit tolérer la troncature.
     */
    public function testParseRealWorldLineWithoutDensite(): void
    {
        $line = 'VI000266  20258C333EDE3EB064E5D4BE832B4F168870ZJC'
            .str_pad('Kieserite 25', 70)
            .str_repeat(' ', 13)  // EAN
            .str_repeat(' ', 35)  // AMM
            .str_repeat(' ', 7)   // GNIS
            .str_repeat(' ', 3)   // apport organique
            .str_repeat(' ', 3)   // eau
            .str_repeat(' ', 3)   // adjuvant
            .str_repeat(' ', 3)   // calco-magnésien
            .str_repeat(' ', 15)  // qualifiants effluent x5
            .str_repeat(' ', 9)   // qualifiants semence x3
            .'0523.9578'
            .'KGM'
            .str_repeat(' ', 12)  // qté/ha + unité
            .str_repeat(' ', 12)  // dose visée + unité
            .str_repeat(' ', 6)   // passages
            .str_repeat(' ', 184) // origine effluent (raisons sociales, adresses, ville, CP)
            .str_repeat(' ', 2);  // pays

        $this->assertSame(438, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('000266', $result->identifiantParcelle);
        $this->assertSame('ZJC', $result->codeTypeIntrant);
        $this->assertSame('Kieserite 25', $result->designation);
        $this->assertNull($result->codeAMM);
        $this->assertNull($result->codeGNIS);
        $this->assertSame(523.9578, $result->quantite);
        $this->assertSame('KGM', $result->codeUnite);
        $this->assertNull($result->quantiteEffectiveHa);
        $this->assertNull($result->doseHaVisee);
        $this->assertNull($result->densiteVolumique);
    }

    /**
     * Le libellé fait 70 caractères (50-119), pas 35 : un libellé long ne doit
     * plus être tronqué, et l'AMM doit être lu en 133-167 (pas 97).
     */
    public function testParseLongDesignationAndAmm(): void
    {
        $line = $this->buildFullLine();
        $line = substr_replace($line, str_pad('Produit avec un nom commercial particulierement long pour tester', 70), 49, 70);

        $result = $this->parser->parse($line, 1);

        $this->assertSame('Produit avec un nom commercial particulierement long pour tester', $result->designation);
        $this->assertSame('2100042', $result->codeAMM);
    }

    private function buildFullLine(): string
    {
        return 'VI'
            .'0001'                                     // 3-6    n° ordre parcelle
            .'78  '                                     // 7-10   réf parcelle culturale
            .'2025'                                     // 11-14  année
            .'A1B2C3D4E5F60718293A4B5C6D7E8F90'         // 15-46  GUID
            .'ZJB'                                      // 47-49  type d'intrant
            .str_pad('Fumier de bovins composte', 70)   // 50-119 libellé
            .'3401234567890'                            // 120-132 EAN
            .str_pad('2100042', 35)                     // 133-167 AMM
            .'123ABCD'                                  // 168-174 GNIS
            .'ZL1'                                      // 175-177 apport organique
            .'EAU'                                      // 178-180 code eau
            .'ADJ'                                      // 181-183 code adjuvant
            .'ZK5'                                      // 184-186 calco-magnésien
            .'ZQ1'                                      // 187-189 qualifiant effluent 1
            .'ZQ2'                                      // 190-192 qualifiant effluent 2
            .'ZQ3'                                      // 193-195 qualifiant effluent 3
            .'ZQ4'                                      // 196-198 qualifiant effluent 4
            .'ZQ5'                                      // 199-201 qualifiant effluent 5
            .'ZQA'                                      // 202-204 qualifiant semence 1
            .'ZS2'                                      // 205-207 qualifiant semence 2
            .'ZS3'                                      // 208-210 qualifiant semence 3
            .'0523.9578'                                // 211-219 quantité totale
            .'KGM'                                      // 220-222 unité
            .'00.075000'                                // 223-231 quantité effective /ha
            .'ZKK'                                      // 232-234 unité
            .'000001.50'                                // 235-243 dose ha visée
            .'LTR'                                      // 244-246 unité
            .'000.50'                                   // 247-252 passages préconisés
            .str_pad('GAEC DE LA VALLEE', 35)           // 253-287 raison sociale 1
            .str_pad('Site de Montbard', 35)            // 288-322 raison sociale 2
            .str_pad('12 route des Champs', 35)         // 323-357 adresse 1
            .str_pad('Lieu-dit Les Pres', 35)           // 358-392 adresse 2
            .str_pad('MONTBARD', 35)                    // 393-427 ville
            .str_pad('21500', 9)                        // 428-436 code postal
            .'FR'                                       // 437-438 pays
            .'0000001.3';                               // 439-447 densité volumique
    }
}
