<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\SurfaceParcelle;

/**
 * Parser pour le FLAG PS (Surface Parcelle).
 *
 * Format observe :
 * Position 1-2   : FLAG "PS"
 * Position 3-10  : Identifiant parcelle (8 an)
 * Position 11-14 : Annee (4 n)
 * Position 15-17 : Type surface (3 an) - A17, A28, A40
 * Position 18-27 : Surface (10 n avec decimales)
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
            surface: $this->extractFloat($line, 18, 10),
        );
    }
}
