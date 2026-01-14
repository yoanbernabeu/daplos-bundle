<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Engagement;

/**
 * Parser pour le FLAG PE (Engagement).
 *
 * Format observe :
 * Position 1-2   : FLAG "PE"
 * Position 3-10  : Identifiant parcelle (8 an)
 * Position 11-14 : Annee (4 n)
 * Position 15+   : Libelle engagement (variable)
 */
final class PELineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'PE';
    }

    protected function doParse(string $line, int $lineNumber): Engagement
    {
        return new Engagement(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            libelle: $this->extractField($line, 15, 200),
        );
    }
}
