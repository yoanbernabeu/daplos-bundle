<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCadastrale;

/**
 * Parser pour le FLAG PC (Parcelle Cadastrale).
 */
final class PCLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'PC';
    }

    protected function doParse(string $line, int $lineNumber): ParcelleCadastrale
    {
        return new ParcelleCadastrale(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            codeCommune: $this->extractField($line, 15, 5),
            prefixe: $this->extractField($line, 20, 3),
            section: $this->extractField($line, 23, 2),
            numero: $this->extractField($line, 25, 4),
            surface: $this->extractFloat($line, 29, 10),
        );
    }
}
