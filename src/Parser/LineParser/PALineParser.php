<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Analyse;

/**
 * Parser pour le FLAG PA (Analyse de sol).
 *
 * Format observe :
 * Position 1-2   : FLAG "PA"
 * Position 3-10  : Identifiant parcelle (8 an)
 * Position 11-14 : Annee (4 n)
 * Position 15-17 : Type analyse (3 an)
 * Position 18-52 : Laboratoire (35 an)
 * Position 53-60 : Date prelevement (8 n)
 * Position 61-68 : Date analyse (8 n)
 */
final class PALineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'PA';
    }

    protected function doParse(string $line, int $lineNumber): Analyse
    {
        // Le format peut varier, detection des dates a la fin
        $lineLength = strlen($line);

        // Les dates sont souvent a la fin
        $datePrelevement = null;
        $dateAnalyse = null;

        if ($lineLength >= 16) {
            // Essai d'extraction des dates depuis la fin
            $dateAnalyse = $this->extractDateTime($line, $lineLength - 7, 8);
            $datePrelevement = $this->extractDateTime($line, $lineLength - 15, 8);
        }

        return new Analyse(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            typeAnalyse: $this->extractField($line, 15, 3),
            datePrelevement: $datePrelevement,
            dateAnalyse: $dateAnalyse,
        );
    }
}
