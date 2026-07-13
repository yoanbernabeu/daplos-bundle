<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DPLineParser;

class DPLineParserTest extends TestCase
{
    private DPLineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new DPLineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('DP', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('DP'));
        $this->assertFalse($this->parser->supports('DE'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG DP p. 13-16),
     * tous les champs renseignés, positions exactes (longueur totale 259).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(259, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(ParcelleCulturale::class, $result);

        // Positions 3-10 : identifiant composite (n° ordre 3-6 + réf parcelle 7-10)
        $this->assertSame('000178', $result->identifiant);
        // Positions 11-14 : année prévue de récolte
        $this->assertSame(2025, $result->annee);
        // Positions 15-22 : date de début de la parcelle
        $this->assertSame('20240901', $result->dateDebutParcelle?->format('Ymd'));
        // Positions 23-30 : date de création de la fiche
        $this->assertSame('20240815', $result->dateCreationFiche?->format('Ymd'));
        // Positions 31-38 : date de dernière saisie sur la parcelle
        $this->assertSame('20250310', $result->dateDerniereSaisie?->format('Ymd'));
        // Positions 39-46 : date de fin de parcelle
        $this->assertSame('20250715', $result->dateFinParcelle?->format('Ymd'));
        // Positions 47-49 : espèce botanique attendue (en code)
        $this->assertSame('ZAR', $result->codeEspeceBotanique);
        // Positions 50-56 : variété semée (1)
        $this->assertSame('512D574', $result->codeVariete);
        // Positions 57-63 : variété semée (2)
        $this->assertSame('512D296', $result->codeVariete2);
        // Positions 64-70 : variété semée (3)
        $this->assertSame('515C875', $result->codeVariete3);
        // Positions 71-77 : variété semée (4)
        $this->assertSame('512E081', $result->codeVariete4);
        // Positions 78-84 : variété semée (5)
        $this->assertSame('580G491', $result->codeVariete5);
        // Positions 85-87 : qualifiant de l'espèce
        $this->assertSame('ZES', $result->codeQualifiantCulture);
        // Positions 88-90 : période de semis
        $this->assertSame('ZFB', $result->codePeriodeSemis);
        // Positions 91-93 : destination
        $this->assertSame('ZLR', $result->codeDestinationCulture);
        // Positions 94-102 : rendement objectif
        $this->assertSame(7.5, $result->rendementObjectif);
        // Positions 103-105 : unité de mesure de rendement
        $this->assertSame('ZHK', $result->codeUniteRendement);
        // Positions 106-140 : intitulé de la parcelle culturale
        $this->assertSame('Les Bergeries', $result->nom);
        // Positions 141-150 : n° îlot PAC (an 10)
        $this->assertSame('12', $result->numeroIlotPac);
        // Positions 151-160 : n° parcelle pérenne
        $this->assertSame('PER001', $result->numeroParcellePerenne);
        // Positions 161-166 : n° de commune (an 6, code INSEE)
        $this->assertSame('89173', $result->codeCommune);
        // Positions 167-169 : profondeur du sol (cm)
        $this->assertSame(30, $result->profondeurSol);
        // Positions 170-172 : pierrosité de surface (%)
        $this->assertSame(15, $result->pierrosite);
        // Positions 173-175 : type de sol (en code)
        $this->assertSame('ZFJ', $result->codeTypeSol);
        // Positions 176-210 : autre type de sol (libellé en clair)
        $this->assertSame('Limon argileux', $result->autreTypeSol);
        // Positions 211-213 : acidité du sol (en code)
        $this->assertSame('ZF1', $result->codeAcidite);
        // Positions 214-216 : profondeur qualitative d'apparition du sous-sol (en code)
        $this->assertSame('ZF4', $result->codeProfondeurSousSol);
        // Positions 217-219 : type de sous-sol (en code)
        $this->assertSame('ZF8', $result->codeTypeSousSol);
        // Positions 220-222 : culture intermédiaire (en code)
        $this->assertSame('ZDH', $result->codeCultureIntermediaire);
        // Position 223 : sol hydromorphe (O ou non renseigné)
        $this->assertTrue($result->solHydromorphe);
        // Position 224 : parcelle culturale drainée
        $this->assertFalse($result->parcelleDrainee);
        // Position 225 : parcelle culturale re-découpée
        $this->assertTrue($result->parcelleRedecoupee);
        // Positions 226-229 : clé de la parcelle culturale initiale
        $this->assertSame('P001', $result->cleParcelleInitiale);
        // Positions 230-232 : gestion des résidus (en code)
        $this->assertSame('ZLJ', $result->codeGestionResidus);
        // Positions 233-241 : quantité épandue (t/ha)
        $this->assertSame(3.5, $result->quantiteEpandue);
        // Positions 242-250 : type de sol v0.95 (nomenclature Arvalis)
        $this->assertSame('BO0513001', $result->codeTypeSolV095);
        // Positions 251-259 : dose N à apporter
        $this->assertSame(150.0, $result->doseAzote);

        // Champs hors guide / sémantique erronée : plus jamais remplis
        $this->assertNull($result->dateCreation);
        $this->assertNull($result->dateDebutCampagne);
        $this->assertNull($result->dateFinCampagne);
        $this->assertNull($result->numeroIlot);
        $this->assertNull($result->numeroRPG);
    }

    /**
     * Ligne issue d'un fichier réel (250 caractères : le champ 251-259
     * « Dose N à apporter » est absent, champs facultatifs vides).
     */
    public function testParseRealWorldLine(): void
    {
        $line = 'DP'
            .'0001'                                 // 3-6    n° ordre parcelle
            .'78  '                                 // 7-10   réf parcelle culturale
            .'2024'                                 // 11-14  année
            .'20230515'                             // 15-22  date de début de la parcelle
            .str_repeat(' ', 8)                     // 23-30  date de création de la fiche
            .str_repeat(' ', 8)                     // 31-38  date de dernière saisie
            .str_repeat(' ', 8)                     // 39-46  date de fin de parcelle
            .'ZDH'                                  // 47-49  espèce botanique
            .str_repeat(' ', 35)                    // 50-84  variétés semées 1 à 5
            .'ZMV'                                  // 85-87  qualifiant de l'espèce
            .'ZFA'                                  // 88-90  période de semis
            .str_repeat(' ', 3)                     // 91-93  destination
            .str_repeat(' ', 9)                     // 94-102 rendement objectif
            .str_repeat(' ', 3)                     // 103-105 unité de rendement
            .str_pad('le champ du bas', 35)         // 106-140 intitulé
            .str_pad('1', 10)                       // 141-150 n° îlot PAC
            .str_repeat(' ', 10)                    // 151-160 n° parcelle pérenne
            .str_pad('89266', 6)                    // 161-166 n° de commune
            .str_repeat(' ', 3)                     // 167-169 profondeur du sol
            .str_repeat(' ', 3)                     // 170-172 pierrosité
            .str_repeat(' ', 3)                     // 173-175 type de sol
            .str_repeat(' ', 35)                    // 176-210 autre type de sol
            .str_repeat(' ', 3)                     // 211-213 acidité
            .str_repeat(' ', 3)                     // 214-216 profondeur sous-sol
            .str_repeat(' ', 3)                     // 217-219 type de sous-sol
            .str_repeat(' ', 3)                     // 220-222 culture intermédiaire
            .' '                                    // 223    sol hydromorphe
            .' '                                    // 224    parcelle drainée
            .' '                                    // 225    parcelle re-découpée
            .str_repeat(' ', 4)                     // 226-229 clé parcelle initiale
            .str_repeat(' ', 3)                     // 230-232 gestion des résidus
            .str_repeat(' ', 9)                     // 233-241 quantité épandue
            .'BO5531003';                           // 242-250 type de sol v0.95

        $this->assertSame(250, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('000178', $result->identifiant);
        $this->assertSame(2024, $result->annee);
        $this->assertSame('20230515', $result->dateDebutParcelle?->format('Ymd'));
        $this->assertNull($result->dateCreationFiche);
        $this->assertNull($result->dateDerniereSaisie);
        $this->assertNull($result->dateFinParcelle);
        $this->assertSame('ZDH', $result->codeEspeceBotanique);
        $this->assertNull($result->codeVariete);
        $this->assertNull($result->codeVariete2);
        $this->assertSame('ZMV', $result->codeQualifiantCulture);
        $this->assertSame('ZFA', $result->codePeriodeSemis);
        $this->assertNull($result->codeDestinationCulture);
        $this->assertNull($result->rendementObjectif);
        $this->assertSame('le champ du bas', $result->nom);
        $this->assertSame('1', $result->numeroIlotPac);
        $this->assertNull($result->numeroParcellePerenne);
        $this->assertSame('89266', $result->codeCommune);
        $this->assertNull($result->codeTypeSol);
        $this->assertNull($result->solHydromorphe);
        $this->assertNull($result->codeGestionResidus);
        $this->assertSame('BO5531003', $result->codeTypeSolV095);
        // Ligne de 250 caractères : la dose N (251-259) est absente
        $this->assertNull($result->doseAzote);
    }

    /**
     * Le n° îlot PAC est un an 10 : les valeurs alphanumériques
     * ne doivent plus être tronquées ni converties en entier.
     */
    public function testParseIlotPacAlphanumerique(): void
    {
        $line = $this->buildFullLine();
        // Positions 141-150 : n° îlot PAC
        $line = substr_replace($line, str_pad('ILOT-2025A', 10), 140, 10);

        $result = $this->parser->parse($line, 1);

        $this->assertSame('ILOT-2025A', $result->numeroIlotPac);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        $line = 'DP00001   2024';

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(ParcelleCulturale::class, $result);
        $this->assertSame('00001', $result->identifiant);
        $this->assertSame(2024, $result->annee);
        $this->assertNull($result->dateDebutParcelle);
        $this->assertNull($result->codeEspeceBotanique);
        $this->assertNull($result->nom);
        $this->assertNull($result->codeTypeSolV095);
        $this->assertNull($result->doseAzote);
    }

    private function buildFullLine(): string
    {
        return 'DP'
            .'0001'                                 // 3-6    n° ordre parcelle
            .'78  '                                 // 7-10   réf parcelle culturale
            .'2025'                                 // 11-14  année prévue de récolte
            .'20240901'                             // 15-22  date de début de la parcelle
            .'20240815'                             // 23-30  date de création de la fiche
            .'20250310'                             // 31-38  date de dernière saisie
            .'20250715'                             // 39-46  date de fin de parcelle
            .'ZAR'                                  // 47-49  espèce botanique
            .'512D574'                              // 50-56  variété semée (1)
            .'512D296'                              // 57-63  variété semée (2)
            .'515C875'                              // 64-70  variété semée (3)
            .'512E081'                              // 71-77  variété semée (4)
            .'580G491'                              // 78-84  variété semée (5)
            .'ZES'                                  // 85-87  qualifiant de l'espèce
            .'ZFB'                                  // 88-90  période de semis
            .'ZLR'                                  // 91-93  destination
            .'0000007.5'                            // 94-102 rendement objectif
            .'ZHK'                                  // 103-105 unité de rendement
            .str_pad('Les Bergeries', 35)           // 106-140 intitulé
            .str_pad('12', 10)                      // 141-150 n° îlot PAC
            .str_pad('PER001', 10)                  // 151-160 n° parcelle pérenne
            .str_pad('89173', 6)                    // 161-166 n° de commune
            .'030'                                  // 167-169 profondeur du sol
            .'015'                                  // 170-172 pierrosité de surface
            .'ZFJ'                                  // 173-175 type de sol (en code)
            .str_pad('Limon argileux', 35)          // 176-210 autre type de sol
            .'ZF1'                                  // 211-213 acidité du sol
            .'ZF4'                                  // 214-216 profondeur sous-sol
            .'ZF8'                                  // 217-219 type de sous-sol
            .'ZDH'                                  // 220-222 culture intermédiaire
            .'O'                                    // 223    sol hydromorphe
            .'N'                                    // 224    parcelle drainée
            .'O'                                    // 225    parcelle re-découpée
            .'P001'                                 // 226-229 clé parcelle initiale
            .'ZLJ'                                  // 230-232 gestion des résidus
            .'0000003.5'                            // 233-241 quantité épandue
            .'BO0513001'                            // 242-250 type de sol v0.95
            .'0000150.0';                           // 251-259 dose N à apporter
    }
}
