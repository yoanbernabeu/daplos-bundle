<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Coordonnee;

/**
 * Parser pour le FLAG CC (Coordonnees Cadastrales).
 *
 * Format DAPLOS v0.95 :
 * Position 1-2   : FLAG "CC"
 * Position 3-6   : N° ordre (n4)
 * Position 7-10  : Reference parcelle culturale (an4)
 * Position 11-14 : Annee (n4)
 * Position 15-30 : N° parcelle cadastrale (an16)
 * Position 31-33 : Qualifiant position geographique (an3)
 * Position 34-44 : Longitude (an11)
 * Position 45-54 : Latitude (an10)
 * Position 55-72 : Altitude (n..18)
 */
final class CCLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'CC';
    }

    protected function doParse(string $line, int $lineNumber): Coordonnee
    {
        return new Coordonnee(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            systemeCoordonnees: $this->extractField($line, 31, 3),
            x: $this->extractFloat($line, 34, 11),
            y: $this->extractFloat($line, 45, 10),
            numeroParcelleCadastrale: $this->extractField($line, 15, 16),
            altitude: $this->extractFloat($line, 55, 18),
        );
    }
}
