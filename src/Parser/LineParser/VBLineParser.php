<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Intervention\CibleEvenement;

/**
 * Parser pour le FLAG VB (Cible évènement).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), page 35 :
 *
 * Position 3-6   : N° d'ordre de la parcelle (4 n)
 * Position 7-10  : Référence parcelle culturale (4 an)
 * Position 11-14 : Année prévue de récolte (4 n)
 * Position 15-46 : Référence de l'événement, GUID (32 an)
 * Position 47-49 : Cible de l'intervention v0.94 (3 an) — codification obsolète
 * Position 50-61 : Cible de l'intervention v0.95 (12 an) — nomenclature Organisme
 *                  vivant (cible ou auxiliaire), codification prioritaire sur la v0.94
 */
final class VBLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'VB';
    }

    protected function doParse(string $line, int $lineNumber): CibleEvenement
    {
        return new CibleEvenement(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            refIntervention: $this->extractField($line, 15, 32),
            codeOrganismeCible: $this->extractField($line, 47, 3),
            codeCibleV095: $this->extractField($line, 50, 12),
        );
    }
}
