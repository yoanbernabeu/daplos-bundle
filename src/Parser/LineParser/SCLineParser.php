<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Coordonnee;

/**
 * Parser pour le FLAG SC (Coordonnees Surface).
 *
 * Format DAPLOS v0.95 :
 * Position 1-2   : FLAG "SC"
 * Position 3-6   : N° ordre (n4)
 * Position 7-10  : Reference parcelle culturale (an4)
 * Position 11-14 : Annee (n4)
 * Position 15-17 : Qualifiant position geographique (an3)
 * Position 18-28 : Longitude (an11)
 * Position 29-38 : Latitude (an10)
 * Position 39-56 : Altitude (n..18)
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
            x: $this->extractFloat($line, 18, 11),
            y: $this->extractFloat($line, 29, 10),
            altitude: $this->extractFloat($line, 39, 18),
        );
    }
}
