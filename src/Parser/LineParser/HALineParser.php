<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Amendement;

/**
 * Parser pour le FLAG HA (Amendement/Residus).
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
            quantite: $this->extractFloat($line, 18, 10),
            codeUnite: $this->extractField($line, 28, 3),
        );
    }
}
