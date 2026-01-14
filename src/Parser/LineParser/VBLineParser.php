<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Intervention\CibleEvenement;

/**
 * Parser pour le FLAG VB (Cible Evenement).
 *
 * Format observe :
 * Position 1-2   : FLAG "VB"
 * Position 3-10  : Identifiant parcelle (8 an)
 * Position 11-14 : Annee (4 n)
 * Position 15-46 : Reference intervention UUID (32 an)
 * Position 47-49 : Code organisme cible (3 an)
 * Position 50-52 : Code sous-type organisme (3 an)
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
            codeSousTypeOrganisme: $this->extractField($line, 50, 3),
        );
    }
}
