<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Amendement;

/**
 * Parser pour le FLAG HA (Amendement/Residus).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), pages 27-28 :
 *
 * Position 3-6     : N° d'ordre de la parcelle (4 n)
 * Position 7-10    : Référence parcelle culturale (4 an)
 * Position 11-14   : Année prévue de récolte (4 n)
 * Position 15-17   : Type d'amendement (3 an) — nomenclature Amendement du sol
 * Position 18-52   : Complément information sur type amendement (35 an)
 * Position 53-60   : Date de l'amendement (8 n) SSAAMMJJ
 * Position 61-69   : Quantité épandue (9 n)
 * Position 70-72   : Unité de mesure de la quantité épandue (3 an) — nomenclature Unité de mesure
 * Position 73-107  : Raison sociale 1 — origine de l'amendement (35 an)
 * Position 108-142 : Raison sociale 2 — origine de l'amendement (35 an)
 * Position 143-177 : Adresse rue 1 — origine de l'amendement (35 an)
 * Position 178-212 : Adresse rue 2 — origine de l'amendement (35 an)
 * Position 213-247 : Ville — origine de l'amendement (35 an)
 * Position 248-256 : Code postal — origine de l'amendement (9 an)
 * Position 257-258 : Pays, code ISO — origine de l'amendement (2 an)
 */
final class HALineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'HA';
    }

    protected function doParse(string $line, int $lineNumber): Amendement
    {
        return new Amendement(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            codeAmendement: $this->extractField($line, 15, 3),
            quantite: $this->extractFloat($line, 61, 9),
            codeUnite: $this->extractField($line, 70, 3),
            complementTypeAmendement: $this->extractField($line, 18, 35),
            dateAmendement: $this->extractDateTime($line, 53, 8),
            origineRaisonSociale1: $this->extractField($line, 73, 35),
            origineRaisonSociale2: $this->extractField($line, 108, 35),
            origineAdresseRue1: $this->extractField($line, 143, 35),
            origineAdresseRue2: $this->extractField($line, 178, 35),
            origineVille: $this->extractField($line, 213, 35),
            origineCodePostal: $this->extractField($line, 248, 9),
            originePays: $this->extractField($line, 257, 2),
        );
    }
}
