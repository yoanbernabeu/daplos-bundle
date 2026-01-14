<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Coordonnee;

/**
 * Parser pour le FLAG SC (Coordonnees Surface).
 *
 * Format observe :
 * Position 1-2   : FLAG "SC"
 * Position 3-10  : Identifiant parcelle (8 an)
 * Position 11-14 : Annee (4 n)
 * Position 15-17 : Systeme coordonnees (3 an)
 * Position 18-29 : Coordonnee X (12 n avec decimales)
 * Position 30-41 : Coordonnee Y (12 n avec decimales)
 */
final class SCLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'SC';
    }

    protected function doParse(string $line, int $lineNumber): Coordonnee
    {
        return new Coordonnee(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            systemeCoordonnees: $this->extractField($line, 15, 3),
            x: $this->extractFloat($line, 18, 12),
            y: $this->extractFloat($line, 30, 12),
        );
    }
}
