<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Parser\LineParser;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PVLineParser;

class PVLineParserTest extends TestCase
{
    private PVLineParser $parser;

    protected function setUp(): void
    {
        $this->parser = new PVLineParser();
    }

    public function testGetFlag(): void
    {
        $this->assertSame('PV', $this->parser->getFlag());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->parser->supports('PV'));
        $this->assertFalse($this->parser->supports('VI'));
    }

    /**
     * Ligne synthétique conforme au guide DAPLOS v0.95 (FLAG PV p. 30-33),
     * tous les champs renseignés, positions exactes (longueur totale 494).
     */
    public function testParseFullLine(): void
    {
        $line = $this->buildFullLine();

        $this->assertSame(494, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertInstanceOf(Evenement::class, $result);

        // Positions 3-10 : identifiant composite (n° ordre 3-6 + réf parcelle 7-10)
        $this->assertSame('000178', $result->identifiantParcelle);
        // Positions 11-14 : année prévue de récolte
        $this->assertSame(2025, $result->annee);
        // Positions 15-46 : référence de l'événement (GUID)
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $result->refIntervention);
        // Position 47 : action sur l'évènement
        $this->assertSame('2', $result->codeAction);
        // Positions 48-50 : type d'évènement (nomenclature Catégorie d'intervention)
        $this->assertSame('ZG7', $result->codeIntervention);
        $this->assertSame('ZG7', $result->codeCategorieIntervention);
        // Positions 51-53 : prévu ou réalisé (nomenclature Statut d'une intervention)
        $this->assertSame('ZK1', $result->codeStatutIntervention);
        // Positions 54-88 : intitulé de l'évènement
        $this->assertSame('Pulverisation fongicide', $result->libelleIntervention);
        // Positions 89-100 / 101-112 : dates de début et fin
        $this->assertSame('202503150830', $result->dateDebutIntervention?->format('YmdHi'));
        $this->assertSame('202503151030', $result->dateFinIntervention?->format('YmdHi'));
        // Positions 113-118 : durée du traitement (JJHHMM)
        $this->assertSame('010430', $result->dureeTraitement);
        // Positions 119-126 : date de préconisation
        $this->assertSame('20250310', $result->datePreconisation?->format('Ymd'));
        // Positions 127-129 : stade de la culture (codification obsolète)
        $this->assertSame('Z61', $result->codeStadeVegetatif);
        // Positions 130-164 : précision sur le stade de culture
        $this->assertSame('Debut montaison', $result->libelleStadeVegetatif);
        // Positions 165-167 : type de travail
        $this->assertSame('PUL', $result->codeTypeTravail);
        // Positions 168-202 : complément infos sur le type de travail
        $this->assertSame('Passage cuve 2000L', $result->complementTypeTravail);
        // Positions 203-205 : motivation (nomenclature Justification de l'intervention)
        $this->assertSame('ZB1', $result->codeJustificationIntervention);
        // Positions 206-240 : complément info sur motivation
        $this->assertSame('Pression maladie forte', $result->complementMotivation);
        // Positions 241-243 : type d'opérateur
        $this->assertSame('ZHM', $result->codeTypeOperateur);
        // Positions 244-261 : n° licence opérateur
        $this->assertSame('CERT-2025-00042', $result->numeroLicenceOperateur);
        // Positions 262-298 : nom de l'opérateur
        $this->assertSame('Jean Dupont', $result->nomOperateur);
        // Positions 299-301 : conditions météo
        $this->assertSame('ZC1', $result->codeConditionsMeteo);
        // Positions 302-304 : traitements spéciaux
        $this->assertSame('ZKF', $result->codeTraitementsSpeciaux);
        // Positions 305-308 : signe + température extérieure
        $this->assertSame(18, $result->temperatureExterieure);
        // Positions 309-311 : pourcentage d'hygrométrie
        $this->assertSame(65, $result->pourcentageHygrometrie);
        // Positions 312-320 + 321-323 : quantité de bouillie visée par ha + unité
        $this->assertSame(150.5, $result->quantiteBouillieViseeHa);
        $this->assertSame('LTR', $result->uniteBouillieViseeHa);
        // Positions 324-332 + 333-335 : quantité de bouillie effective par ha + unité
        $this->assertSame(148.2, $result->quantiteBouillieEffectiveHa);
        $this->assertSame('LTR', $result->uniteBouillieEffectiveHa);
        // Positions 336-344 : surface couverte par l'évènement
        $this->assertSame(12.34, $result->surfaceTraitee);
        // Positions 345-414 + 415-484 : commentaires (concaténés)
        $this->assertSame('Commentaire ligne un Commentaire ligne deux', $result->commentaire);
        // Positions 485-494 : codes stades de cultures v095 (BBCH, prioritaire)
        $this->assertSame('BBCH31', $result->codeStadeCultureBBCH);
    }

    /**
     * Ligne issue d'un fichier réel (champs facultatifs vides).
     */
    public function testParseRealWorldLine(): void
    {
        $line = 'PV000266  20258C333EDE3EB064E5D4BE832B4F168870 ZG7ZK2'
            .str_pad('Intervention avec intrant', 35)
            .'202502170000202502170000'
            .str_repeat(' ', 6)   // durée
            .str_repeat(' ', 8)   // date préconisation
            .str_repeat(' ', 3)   // stade obsolète
            .str_pad('Stade C2', 35)
            .'SEM'
            .str_repeat(' ', 35)  // complément type de travail
            .str_repeat(' ', 3)   // motivation
            .str_repeat(' ', 35)  // complément motivation
            .str_repeat(' ', 3)   // type opérateur
            .str_repeat(' ', 18)  // licence
            .str_repeat(' ', 37)  // nom opérateur
            .str_repeat(' ', 3)   // météo
            .str_repeat(' ', 3)   // traitements spéciaux
            .str_repeat(' ', 4)   // signe + température
            .str_repeat(' ', 3)   // hygrométrie
            .str_repeat(' ', 12)  // bouillie visée + unité
            .str_repeat(' ', 12)  // bouillie effective + unité
            .'000005.58'
            .str_repeat(' ', 140) // commentaires
            .str_repeat(' ', 10); // BBCH

        $this->assertSame(494, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('000266', $result->identifiantParcelle);
        $this->assertSame(2025, $result->annee);
        $this->assertSame('8C333EDE3EB064E5D4BE832B4F168870', $result->refIntervention);
        $this->assertNull($result->codeAction);
        $this->assertSame('ZG7', $result->codeIntervention);
        $this->assertSame('ZK2', $result->codeStatutIntervention);
        $this->assertSame('Intervention avec intrant', $result->libelleIntervention);
        $this->assertNull($result->dureeTraitement);
        $this->assertNull($result->datePreconisation);
        $this->assertSame('Stade C2', $result->libelleStadeVegetatif);
        $this->assertSame('SEM', $result->codeTypeTravail);
        $this->assertNull($result->codeTypeOperateur);
        $this->assertNull($result->temperatureExterieure);
        $this->assertSame(5.58, $result->surfaceTraitee);
        $this->assertNull($result->commentaire);
        $this->assertNull($result->codeStadeCultureBBCH);
    }

    public function testParseNegativeTemperature(): void
    {
        $line = $this->buildFullLine();
        // Position 305 : signe, positions 306-308 : température
        $line = substr_replace($line, '-005', 304, 4);

        $result = $this->parser->parse($line, 1);

        $this->assertSame(-5, $result->temperatureExterieure);
    }

    public function testParseTruncatedLineIsTolerated(): void
    {
        // Ligne minimale (jusqu'aux dates uniquement)
        $line = 'PV000178  2025A1B2C3D4E5F60718293A4B5C6D7E8F90 ZG7ZK1'
            .str_pad('Semis', 35)
            .'202503150830202503151030';

        $result = $this->parser->parse($line, 1);

        $this->assertSame('Semis', $result->libelleIntervention);
        $this->assertNull($result->surfaceTraitee);
        $this->assertNull($result->codeStadeCultureBBCH);
    }

    /**
     * Certains émetteurs (Smag) écrivent un code BBCH de 11 caractères :
     * le dernier champ (485-494) doit être lu jusqu'à la fin de ligne.
     */
    public function testParseBbchOverflowSmag(): void
    {
        $line = substr($this->buildFullLine(), 0, 484).'06BBCH0000b';

        $this->assertSame(495, strlen($line));

        $result = $this->parser->parse($line, 1);

        $this->assertSame('06BBCH0000b', $result->codeStadeCultureBBCH);
    }

    public function testDureeTraitementEnMinutes(): void
    {
        $result = $this->parser->parse($this->buildFullLine(), 1);

        // 010430 = 1 jour, 4 heures, 30 minutes = 1710 minutes
        $this->assertSame(1710, $result->getDureeTraitementEnMinutes());
    }

    private function buildFullLine(): string
    {
        $line = 'PV'
            .'0001'                                     // 3-6    n° ordre parcelle
            .'78  '                                     // 7-10   réf parcelle culturale
            .'2025'                                     // 11-14  année
            .'A1B2C3D4E5F60718293A4B5C6D7E8F90'         // 15-46  GUID
            .'2'                                        // 47     action
            .'ZG7'                                      // 48-50  type d'évènement
            .'ZK1'                                      // 51-53  prévu/réalisé
            .str_pad('Pulverisation fongicide', 35)     // 54-88  intitulé
            .'202503150830'                             // 89-100 date début
            .'202503151030'                             // 101-112 date fin
            .'010430'                                   // 113-118 durée
            .'20250310'                                 // 119-126 date préconisation
            .'Z61'                                      // 127-129 stade (obsolète)
            .str_pad('Debut montaison', 35)             // 130-164 précision stade
            .'PUL'                                      // 165-167 type de travail
            .str_pad('Passage cuve 2000L', 35)          // 168-202 complément type travail
            .'ZB1'                                      // 203-205 motivation
            .str_pad('Pression maladie forte', 35)      // 206-240 complément motivation
            .'ZHM'                                      // 241-243 type opérateur
            .str_pad('CERT-2025-00042', 18)             // 244-261 n° licence
            .str_pad('Jean Dupont', 37)                 // 262-298 nom opérateur
            .'ZC1'                                      // 299-301 météo
            .'ZKF'                                      // 302-304 traitements spéciaux
            .'+'                                        // 305    signe température
            .'018'                                      // 306-308 température
            .'065'                                      // 309-311 hygrométrie
            .'000150.50'                                // 312-320 bouillie visée
            .'LTR'                                      // 321-323 unité
            .'000148.20'                                // 324-332 bouillie effective
            .'LTR'                                      // 333-335 unité
            .'000012.34'                                // 336-344 surface
            .str_pad('Commentaire ligne un', 70)        // 345-414 commentaire 1
            .str_pad('Commentaire ligne deux', 70)      // 415-484 commentaire 2
            .'BBCH31    ';                              // 485-494 codes stades v095

        return $line;
    }
}
