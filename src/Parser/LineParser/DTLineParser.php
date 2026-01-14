<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Document\TypeAgriculture;

/**
 * Parser pour le FLAG DT (Type d'Agriculture).
 *
 * Format de la ligne :
 * Position 1-2  : FLAG "DT"
 * Position 3-5  : Code type agriculture (3 an)
 * Position 6+   : Libelle (variable)
 */
final class DTLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'DT';
    }

    protected function doParse(string $line, int $lineNumber): TypeAgriculture
    {
        return new TypeAgriculture(
            codeTypeAgriculture: $this->extractField($line, 3, 3),
            libelle: $this->extractField($line, 6, 100),
        );
    }
}
