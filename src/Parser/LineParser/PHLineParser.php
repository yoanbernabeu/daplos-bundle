<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Historique;

/**
 * Parser pour le FLAG PH (Historique/Precedent cultural).
 *
 * Format observe :
 * Position 1-2   : FLAG "PH"
 * Position 3-10  : Identifiant parcelle (8 an)
 * Position 11-14 : Annee (4 n)
 * Position 15-16 : Index precedent (-1, -2, etc.)
 * Position 17-20 : Annee precedent (4 n)
 * Position 21-23 : Code espece botanique (3 an)
 * Position 24-26 : Code traitement residus (3 an)
 * Position 27-29 : Code mode production (3 an)
 */
final class PHLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'PH';
    }

    protected function doParse(string $line, int $lineNumber): Historique
    {
        // Extraction de l'index (peut etre -1, -2, etc.)
        $indexStr = $this->extractField($line, 15, 2);
        $index = null;
        if (null !== $indexStr) {
            $index = (int) str_replace('-', '', $indexStr);
            if (str_contains($indexStr, '-')) {
                $index = -$index;
            }
        }

        return new Historique(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            indexPrecedent: $index,
            anneePrecedent: $this->extractInt($line, 17, 4),
            codeEspeceBotanique: $this->extractField($line, 21, 3),
            codeTraitementResidus: $this->extractField($line, 24, 3),
            codeModeProduction: $this->extractField($line, 27, 3),
        );
    }
}
