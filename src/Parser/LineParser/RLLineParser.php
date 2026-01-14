<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Recolte\LotRecolte;

/**
 * Parser pour le FLAG RL (Lot Recolte).
 *
 * Format observe :
 * Position 1-2   : FLAG "RL"
 * Position 3-10  : Identifiant parcelle (8 an)
 * Position 11-14 : Annee (4 n)
 * Position 15-46 : Reference intervention UUID (32 an)
 * Position 47-81 : Numero lot (35 an)
 * Position 82-90 : Quantite (9 n)
 * Position 91-93 : Code unite (3 an)
 */
final class RLLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'RL';
    }

    protected function doParse(string $line, int $lineNumber): LotRecolte
    {
        return new LotRecolte(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            refIntervention: $this->extractField($line, 15, 32),
            numeroLot: $this->extractField($line, 47, 35),
            quantite: $this->extractFloat($line, 82, 9),
            codeUnite: $this->extractField($line, 91, 3),
        );
    }
}
