<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Intrant\Intrant;

/**
 * Parser pour le FLAG VI (Intrant).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), pages 36-40 :
 *
 * Position 3-6     : N° d'ordre de la parcelle (4 n)
 * Position 7-10    : Référence parcelle culturale (4 an)
 * Position 11-14   : Année prévue de récolte (4 n)
 * Position 15-46   : Référence de l'événement, GUID (32 an)
 * Position 47-49   : Type d'intrant (3 an) — nomenclature Famille d'intrant
 * Position 50-119  : Libellé intrant (70 an)
 * Position 120-132 : Code EAN du produit (13 an)
 * Position 133-167 : Code AMM du produit (35 an) — obligatoire pour les phytos avec AMM
 * Position 168-174 : Code GNIS (7 an) — obligatoire si semence (ZJF) ou plants (ZJT)
 * Position 175-177 : Code Apport Organique (3 an) — obligatoire si apport organique
 * Position 178-180 : Code eau (3 an) — obligatoire si irrigation (ZJE)
 * Position 181-183 : Code adjuvant (3 an) — obligatoire si ZJA sans AMM
 * Position 184-186 : Code calco-magnésien (3 an) — obligatoire si ZKE
 * Position 187-189 : Qualifiant (1) de l'effluent (3 an)
 * Position 190-192 : Qualifiant (2) de l'effluent (3 an)
 * Position 193-195 : Qualifiant (3) de l'effluent (3 an)
 * Position 196-198 : Qualifiant (4) de l'effluent (3 an)
 * Position 199-201 : Qualifiant (5) de l'effluent (3 an)
 * Position 202-204 : Qualifiant semence (1) (3 an)
 * Position 205-207 : Qualifiant semence (2) (3 an)
 * Position 208-210 : Qualifiant semence (3) (3 an)
 * Position 211-219 : Quantité totale effective intrant (9 n)
 * Position 220-222 : Unité de mesure (3 an)
 * Position 223-231 : Quantité effective par hectare (9 n)
 * Position 232-234 : Unité de mesure (3 an)
 * Position 235-243 : Dose hectare visée (9 n)
 * Position 244-246 : Unité de mesure (3 an)
 * Position 247-252 : Nombre de passages préconisés (6 n, 2 décimales maxi)
 * Position 253-287 : Raison sociale (1) — origine de l'effluent (35 an)
 * Position 288-322 : Raison sociale (2) (35 an)
 * Position 323-357 : Adresse Rue (1) (35 an)
 * Position 358-392 : Adresse Rue (2) (35 an)
 * Position 393-427 : Ville (35 an)
 * Position 428-436 : Code postal (9 an)
 * Position 437-438 : Pays (2 an)
 * Position 439-447 : Densité volumique de l'intrant (9 n) en kg/L — souvent absent (lignes de 438)
 */
final class VILineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'VI';
    }

    protected function doParse(string $line, int $lineNumber): Intrant
    {
        return new Intrant(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            refIntervention: $this->extractField($line, 15, 32),
            codeTypeIntrant: $this->extractField($line, 47, 3),
            designation: $this->extractField($line, 50, 70),
            quantite: $this->extractFloat($line, 211, 9),
            codeUnite: $this->extractField($line, 220, 3),
            codeAMM: $this->extractField($line, 133, 35),
            codeGNIS: $this->extractField($line, 168, 7),
            codeApportOrganique: $this->extractField($line, 175, 3),
            codeEAU: $this->extractField($line, 178, 3),
            codeAdjuvant: $this->extractField($line, 181, 3),
            codeCalcoMagnesien: $this->extractField($line, 184, 3),
            codeQualifiantIntrant: $this->extractField($line, 187, 3),
            codeEAN: $this->extractField($line, 120, 13),
            codeQualifiantEffluent2: $this->extractField($line, 190, 3),
            codeQualifiantEffluent3: $this->extractField($line, 193, 3),
            codeQualifiantEffluent4: $this->extractField($line, 196, 3),
            codeQualifiantEffluent5: $this->extractField($line, 199, 3),
            codeQualifiantSemence1: $this->extractField($line, 202, 3),
            codeQualifiantSemence2: $this->extractField($line, 205, 3),
            codeQualifiantSemence3: $this->extractField($line, 208, 3),
            quantiteEffectiveHa: $this->extractFloat($line, 223, 9),
            codeUniteQuantiteEffectiveHa: $this->extractField($line, 232, 3),
            doseHaVisee: $this->extractFloat($line, 235, 9),
            codeUniteDoseHaVisee: $this->extractField($line, 244, 3),
            nombrePassagesPreconises: $this->extractFloat($line, 247, 6),
            origineEffluentRaisonSociale1: $this->extractField($line, 253, 35),
            origineEffluentRaisonSociale2: $this->extractField($line, 288, 35),
            origineEffluentAdresse1: $this->extractField($line, 323, 35),
            origineEffluentAdresse2: $this->extractField($line, 358, 35),
            origineEffluentVille: $this->extractField($line, 393, 35),
            origineEffluentCodePostal: $this->extractField($line, 428, 9),
            origineEffluentPays: $this->extractField($line, 437, 2),
            densiteVolumique: $this->extractFloat($line, 439, 9),
        );
    }
}
