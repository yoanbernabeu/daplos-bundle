<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\SurfaceParcelle;

/**
 * Parser pour le FLAG PS (Surface Parcelle).
 *
 * Format DAPLOS v0.95 :
 * Position 1-2   : FLAG "PS"
 * Position 3-6   : N° ordre (n4)
 * Position 7-10  : Reference parcelle culturale (an4)
 * Position 11-14 : Annee (n4)
 * Position 15-17 : Type de surface (an3) - A17, A28, A40
 * Position 18-26 : Surface (n9)
 */
final class PSLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'PS';
    }

    protected function doParse(string $line, int $lineNumber): SurfaceParcelle
    {
        return new SurfaceParcelle(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            typeSurface: $this->extractField($line, 15, 3),
            surface: $this->extractFloat($line, 18, 9),
        );
    }
}
