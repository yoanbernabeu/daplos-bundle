<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Coordonnee;

/**
 * Parser pour le FLAG CC (Coordonnees Cadastrales).
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
            systemeCoordonnees: $this->extractField($line, 15, 3),
            x: $this->extractFloat($line, 18, 12),
            y: $this->extractFloat($line, 30, 12),
        );
    }
}
