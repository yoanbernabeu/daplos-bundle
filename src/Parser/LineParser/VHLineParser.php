<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Intervention\HistoriqueDecision;

/**
 * Parser pour le FLAG VH (Historique Indicateur de décision).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), pages 49-50 :
 *
 * Position 3-6     : N° d'ordre de la parcelle (4 n)
 * Position 7-10    : Référence parcelle culturale (4 an)
 * Position 11-14   : Année prévue de récolte (4 n)
 * Position 15-46   : Référence de l'événement, GUID (32 an)
 * Position 47-49   : Type de lien en code (3 an) — nomenclature Nature du lien
 * Position 50-81   : Référence de l'événement considéré (32 an)
 * Position 82-85   : N° de la parcelle antérieur (4 an) — obligatoire si même exploitation
 * Position 86-89   : Année de récolte (4 an) SSAA de l'événement antérieur
 * Position 90-106  : Identification exploitation (17 an) — code SIRET ou code adhérent
 * Position 107-109 : Type d'identification (3 an) — 107 : N° de SIRET, ZZZ : défini mutuellement
 * Position 110-144 : Raison sociale (1) de l'exploitation (35 an)
 * Position 145-179 : Raison sociale (2) de l'exploitation (35 an)
 * Position 180-214 : Adresse Rue (1) de l'exploitation (35 an)
 * Position 215-249 : Adresse Rue (2) de l'exploitation (35 an)
 * Position 250-284 : Ville de l'exploitation (35 an)
 * Position 285-293 : Code postal de l'exploitation (9 an)
 * Position 294-295 : Pays de l'exploitation (2 an) — code ISO
 * Position 296-365 : Informations parcelle non EDI (1) (70 an) — si type de lien ZL4
 * Position 366-435 : Informations parcelle non EDI (2) (70 an) — si type de lien ZL4
 *
 * Les anciens champs decision (47-146, fourre-tout) et dateDecision (147-160)
 * ne correspondaient à aucun champ du guide : ils sont dépréciés et ne sont
 * plus remplis.
 */
final class VHLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'VH';
    }

    protected function doParse(string $line, int $lineNumber): HistoriqueDecision
    {
        return new HistoriqueDecision(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            refIntervention: $this->extractField($line, 15, 32),
            codeTypeLien: $this->extractField($line, 47, 3),
            refEvenementConsidere: $this->extractField($line, 50, 32),
            numeroParcelleAnterieur: $this->extractField($line, 82, 4),
            anneeRecolte: $this->extractInt($line, 86, 4),
            identificationExploitation: $this->extractField($line, 90, 17),
            codeTypeIdentification: $this->extractField($line, 107, 3),
            exploitationRaisonSociale1: $this->extractField($line, 110, 35),
            exploitationRaisonSociale2: $this->extractField($line, 145, 35),
            exploitationAdresse1: $this->extractField($line, 180, 35),
            exploitationAdresse2: $this->extractField($line, 215, 35),
            exploitationVille: $this->extractField($line, 250, 35),
            exploitationCodePostal: $this->extractField($line, 285, 9),
            exploitationPays: $this->extractField($line, 294, 2),
            infoParcelleNonEdi1: $this->extractField($line, 296, 70),
            infoParcelleNonEdi2: $this->extractField($line, 366, 70),
        );
    }
}
