<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;

/**
 * Parser pour le FLAG PV (Evenement/Intervention).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), pages 30-33 :
 *
 * Position 3-6     : N° d'ordre de la parcelle (4 n)
 * Position 7-10    : Référence parcelle culturale (4 an)
 * Position 11-14   : Année prévue de récolte (4 n)
 * Position 15-46   : Référence de l'événement, GUID (32 an)
 * Position 47      : Action sur l'évènement (1 an) — « 2 » si suppression
 * Position 48-50   : Type d'évènement (3 an) — nomenclature Catégorie d'intervention
 * Position 51-53   : Prévu ou Réalisé (3 an) — nomenclature Statut d'une intervention
 * Position 54-88   : Intitulé de l'évènement (35 an)
 * Position 89-100  : Date/heure de début (12 n) SSAAMMJJHHmm
 * Position 101-112 : Date/heure de fin (12 n) SSAAMMJJHHmm
 * Position 113-118 : Durée du traitement (6 n) au format JJHHMM
 * Position 119-126 : Date de préconisation (8 n) SSAAMMJJ
 * Position 127-129 : Stade de la culture en code (3 an) — codification obsolète
 * Position 130-164 : Précision sur le stade de culture (35 an)
 * Position 165-167 : Type de travail (3 an) — nomenclature Intervention agricole
 * Position 168-202 : Complément infos sur le type de travail (35 an)
 * Position 203-205 : Motivation (3 an) — nomenclature Justification de l'intervention
 * Position 206-240 : Complément info sur motivation (35 an)
 * Position 241-243 : Type d'opérateur (3 an) — ZHM interne / ZHN externe
 * Position 244-261 : N° licence opérateur (18 an)
 * Position 262-298 : Nom de l'opérateur (37 an)
 * Position 299-301 : Conditions météo (3 an)
 * Position 302-304 : Traitements spéciaux (3 an) — ZKF localisé / ZKG en plein / ZKH désodorisation
 * Position 305     : Signe de la température (+ ou -)
 * Position 306-308 : Température extérieure (3 n)
 * Position 309-311 : Pourcentage d'hygrométrie (3 n)
 * Position 312-320 : Quantité de bouillie visée par hectare (9 n)
 * Position 321-323 : Unité de mesure de la bouillie visée (3 an)
 * Position 324-332 : Quantité de bouillie effective par hectare (9 n)
 * Position 333-335 : Unité de mesure de la bouillie effective (3 an)
 * Position 336-344 : Surface couverte par l'évènement (9 n)
 * Position 345-414 : Commentaires (70 an)
 * Position 415-484 : Commentaires (70 an)
 * Position 485-494 : Codes Stades de Cultures v095, BBCH (10 an) — codification prioritaire ;
 *                    certains émetteurs dépassent la position 494, lecture jusqu'à la fin de ligne
 */
final class PVLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'PV';
    }

    protected function doParse(string $line, int $lineNumber): Evenement
    {
        $idParcelle = $this->extractField($line, 3, 8);
        $annee = $this->extractInt($line, 11, 4);
        $refIntervention = $this->extractField($line, 15, 32);

        $codeAction = $this->extractField($line, 47, 1);
        $codeIntervention = $this->extractField($line, 48, 3);
        $codeStatut = $this->extractField($line, 51, 3);
        $libelleIntervention = $this->extractField($line, 54, 35);

        $dateDebut = $this->extractDateTime($line, 89, 12);
        $dateFin = $this->extractDateTime($line, 101, 12);

        $dureeTraitement = $this->extractField($line, 113, 6);
        $datePreconisation = $this->extractDateTime($line, 119, 8);

        $codeStadeVegetatif = $this->extractField($line, 127, 3);
        $precisionStade = $this->extractField($line, 130, 35);

        $codeTypeTravail = $this->extractField($line, 165, 3);
        $complementTypeTravail = $this->extractField($line, 168, 35);
        $codeJustification = $this->extractField($line, 203, 3);
        $complementMotivation = $this->extractField($line, 206, 35);

        $codeTypeOperateur = $this->extractField($line, 241, 3);
        $numeroLicenceOperateur = $this->extractField($line, 244, 18);
        $nomOperateur = $this->extractField($line, 262, 37);

        $codeConditionsMeteo = $this->extractField($line, 299, 3);
        $codeTraitementsSpeciaux = $this->extractField($line, 302, 3);

        $temperature = $this->extractTemperature($line);
        $hygrometrie = $this->extractInt($line, 309, 3);

        $quantiteBouillieVisee = $this->extractFloat($line, 312, 9);
        $uniteBouillieVisee = $this->extractField($line, 321, 3);
        $quantiteBouillieEffective = $this->extractFloat($line, 324, 9);
        $uniteBouillieEffective = $this->extractField($line, 333, 3);

        $surfaceTraitee = $this->extractFloat($line, 336, 9);
        $commentaire = $this->extractCommentaire($line);
        $codeStadeCultureBBCH = $this->extractFieldToEnd($line, 485);

        return new Evenement(
            identifiantParcelle: $idParcelle,
            annee: $annee,
            refIntervention: $refIntervention,
            codeIntervention: $codeIntervention,
            codeCategorieIntervention: $codeIntervention,
            libelleIntervention: $libelleIntervention,
            dateDebutIntervention: $dateDebut,
            dateFinIntervention: $dateFin,
            codeStatutIntervention: $codeStatut,
            codeJustificationIntervention: $codeJustification,
            codeStadeVegetatif: $codeStadeVegetatif,
            libelleStadeVegetatif: $precisionStade,
            codeConditionsMeteo: $codeConditionsMeteo,
            commentaire: $commentaire,
            surfaceTraitee: $surfaceTraitee,
            codeAction: $codeAction,
            dureeTraitement: $dureeTraitement,
            datePreconisation: $datePreconisation,
            codeTypeTravail: $codeTypeTravail,
            complementTypeTravail: $complementTypeTravail,
            complementMotivation: $complementMotivation,
            codeTypeOperateur: $codeTypeOperateur,
            numeroLicenceOperateur: $numeroLicenceOperateur,
            nomOperateur: $nomOperateur,
            codeTraitementsSpeciaux: $codeTraitementsSpeciaux,
            temperatureExterieure: $temperature,
            pourcentageHygrometrie: $hygrometrie,
            quantiteBouillieViseeHa: $quantiteBouillieVisee,
            uniteBouillieViseeHa: $uniteBouillieVisee,
            quantiteBouillieEffectiveHa: $quantiteBouillieEffective,
            uniteBouillieEffectiveHa: $uniteBouillieEffective,
            codeStadeCultureBBCH: $codeStadeCultureBBCH,
        );
    }

    /**
     * Combine le signe (position 305) et la valeur (positions 306-308).
     */
    private function extractTemperature(string $line): ?int
    {
        $valeur = $this->extractInt($line, 306, 3);
        if (null === $valeur) {
            return null;
        }

        $signe = $this->extractField($line, 305, 1);

        return '-' === $signe ? -$valeur : $valeur;
    }

    /**
     * Concatène les deux zones de commentaires (345-414 et 415-484).
     */
    private function extractCommentaire(string $line): ?string
    {
        $commentaire1 = $this->extractField($line, 345, 70);
        $commentaire2 = $this->extractField($line, 415, 70);

        $parts = array_filter([$commentaire1, $commentaire2], static fn (?string $p): bool => null !== $p);

        return [] !== $parts ? implode(' ', $parts) : null;
    }
}
