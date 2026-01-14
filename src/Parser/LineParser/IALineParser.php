<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Intrant\AnalyseEffluent;

/**
 * Parser pour le FLAG IA (Analyse Effluent).
 */
final class IALineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'IA';
    }

    protected function doParse(string $line, int $lineNumber): AnalyseEffluent
    {
        return new AnalyseEffluent(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            refIntervention: $this->extractField($line, 15, 32),
            typeAnalyse: $this->extractField($line, 47, 3),
            codeElement: $this->extractField($line, 50, 3),
            valeur: $this->extractFloat($line, 53, 10),
            codeUnite: $this->extractField($line, 63, 3),
        );
    }
}
