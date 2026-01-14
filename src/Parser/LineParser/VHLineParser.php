<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Intervention\HistoriqueDecision;

/**
 * Parser pour le FLAG VH (Historique Decision).
 */
final class VHLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'VH';
    }

    protected function doParse(string $line, int $lineNumber): HistoriqueDecision
    {
        return new HistoriqueDecision(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            refIntervention: $this->extractField($line, 15, 32),
            decision: $this->extractField($line, 47, 100),
            dateDecision: $this->extractDateTime($line, 147, 14),
        );
    }
}
