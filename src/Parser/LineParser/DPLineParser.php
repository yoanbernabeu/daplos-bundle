<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;

/**
 * Parser pour le FLAG DP (Parcelle Culturale).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), pages 13-16 :
 *
 * Position 3-6     : N° d'ordre de la parcelle (4 n)
 * Position 7-10    : Identification parcelle culturale (4 an)
 * Position 11-14   : Année prévue de récolte (4 n)
 * Position 15-22   : Date de début de la parcelle (8 n) SSAAMMJJ — date de la 1ère intervention
 * Position 23-30   : Date de création de la fiche (8 n) SSAAMMJJ
 * Position 31-38   : Date de dernière saisie sur la parcelle (8 n) SSAAMMJJ
 * Position 39-46   : Date de fin de parcelle (8 n) SSAAMMJJ
 * Position 47-49   : Espèce botanique attendue en code (3 an) — nomenclature Espèce botanique d'une culture
 * Position 50-56   : Variété semée 1 (7 an) — code GNIS par défaut (3n + 4an)
 * Position 57-63   : Variété semée 2 (7 an)
 * Position 64-70   : Variété semée 3 (7 an)
 * Position 71-77   : Variété semée 4 (7 an)
 * Position 78-84   : Variété semée 5 (7 an)
 * Position 85-87   : Qualifiant de l'espèce (3 an) — nomenclature Qualifiant d'une culture ;
 *                    rempli dans codeQualifiantCulture
 * Position 88-90   : Période de semis (3 an) — nomenclature Période de semis d'une culture ;
 *                    remplie dans codePeriodeSemis
 * Position 91-93   : Destination (3 an) — nomenclature Destination d'une culture ;
 *                    remplie dans codeDestinationCulture
 * Position 94-102  : Rendement objectif (9 n)
 * Position 103-105 : Unité de mesure de rendement (3 an) — obligatoire si rendement renseigné
 * Position 106-140 : Intitulé de la parcelle culturale (35 an)
 * Position 141-150 : N° îlot PAC (10 an)
 * Position 151-160 : N° parcelle pérenne (10 an) — identification obsolète, préférer l'îlot PAC
 * Position 161-166 : N° de commune (6 an) — code INSEE
 * Position 167-169 : Profondeur du sol (3 n) en centimètres
 * Position 170-172 : Pierrosité de surface (3 n) en pourcentage
 * Position 173-175 : Type de sol en code (3 an) — nomenclature valeur de la caractéristique technique
 * Position 176-210 : Autre type de sol (35 an) — libellé en clair
 * Position 211-213 : Acidité du sol en code (3 an)
 * Position 214-216 : Profondeur qualitative d'apparition du sous-sol en code (3 an)
 * Position 217-219 : Type de sous-sol en code (3 an)
 * Position 220-222 : Culture intermédiaire en code (3 an) — nomenclature Espèce botanique d'une culture
 * Position 223     : Sol hydromorphe (1 an) — O(Oui) ou non renseigné
 * Position 224     : Parcelle culturale drainée (1 an) — O(Oui) ou non renseigné
 * Position 225     : Parcelle culturale re-découpée (1 an) — O(Oui) ou non renseigné
 * Position 226-229 : Clé de la parcelle culturale initiale (4 an) — obligatoire si re-découpée
 * Position 230-232 : Gestion des résidus en code (3 an) — nomenclature Traitement des résidus de culture
 * Position 233-241 : Quantité épandue (9 n) en tonne/ha
 * Position 242-250 : Type de sol v0.95 (9 an) — nomenclature sols Arvalis, codification prioritaire
 *                    sur le Type de sol AEE (173-175)
 * Position 251-259 : Dose N à apporter (9 n) — souvent absente, les lignes réelles font 250 caractères
 */
final class DPLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'DP';
    }

    protected function doParse(string $line, int $lineNumber): ParcelleCulturale
    {
        return new ParcelleCulturale(
            identifiant: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            codeEspeceBotanique: $this->extractField($line, 47, 3),
            codeVariete: $this->extractField($line, 50, 7),
            codeQualifiantCulture: $this->extractField($line, 85, 3),
            codeDestinationCulture: $this->extractField($line, 91, 3),
            codePeriodeSemis: $this->extractField($line, 88, 3),
            codeTypeSol: $this->extractField($line, 173, 3),
            codeTypeSousSol: $this->extractField($line, 217, 3),
            nom: $this->extractField($line, 106, 35),
            codeCommune: $this->extractField($line, 161, 6),
            dateDebutParcelle: $this->extractDateTime($line, 15, 8),
            dateCreationFiche: $this->extractDateTime($line, 23, 8),
            dateDerniereSaisie: $this->extractDateTime($line, 31, 8),
            dateFinParcelle: $this->extractDateTime($line, 39, 8),
            codeVariete2: $this->extractField($line, 57, 7),
            codeVariete3: $this->extractField($line, 64, 7),
            codeVariete4: $this->extractField($line, 71, 7),
            codeVariete5: $this->extractField($line, 78, 7),
            rendementObjectif: $this->extractFloat($line, 94, 9),
            codeUniteRendement: $this->extractField($line, 103, 3),
            numeroIlotPac: $this->extractField($line, 141, 10),
            numeroParcellePerenne: $this->extractField($line, 151, 10),
            profondeurSol: $this->extractInt($line, 167, 3),
            pierrosite: $this->extractInt($line, 170, 3),
            autreTypeSol: $this->extractField($line, 176, 35),
            codeAcidite: $this->extractField($line, 211, 3),
            codeProfondeurSousSol: $this->extractField($line, 214, 3),
            codeCultureIntermediaire: $this->extractField($line, 220, 3),
            solHydromorphe: $this->extractBool($line, 223),
            parcelleDrainee: $this->extractBool($line, 224),
            parcelleRedecoupee: $this->extractBool($line, 225),
            cleParcelleInitiale: $this->extractField($line, 226, 4),
            codeGestionResidus: $this->extractField($line, 230, 3),
            quantiteEpandue: $this->extractFloat($line, 233, 9),
            codeTypeSolV095: $this->extractField($line, 242, 9),
            doseAzote: $this->extractFloat($line, 251, 9),
        );
    }
}
