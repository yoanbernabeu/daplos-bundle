<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Coordonnee;

/**
 * Parser pour le FLAG VC (Coordonnees Intervention).
 */
final class VCLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'VC';
    }

    protected function doParse(string $line, int $lineNumber): Coordonnee
    {
        return new Coordonnee(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            refIntervention: $this->extractField($line, 15, 32),
            systemeCoordonnees: $this->extractField($line, 47, 3),
            x: $this->extractFloat($line, 50, 12),
            y: $this->extractFloat($line, 62, 12),
        );
    }
}
