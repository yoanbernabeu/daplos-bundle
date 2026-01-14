<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Intrant\CompositionFertilisation;

/**
 * Parser pour le FLAG IC (Composition Fertilisation).
 *
 * Format observe :
 * Position 1-2   : FLAG "IC"
 * Position 3-10  : Identifiant parcelle (8 an)
 * Position 11-14 : Annee (4 n)
 * Position 15-46 : Reference intervention UUID (32 an)
 * Position 47-48 : Code element (2 an) - NT, PT, KT, CA, ST, NL, MT, NJ, BT
 * Position 49    : Espace
 * Position 50-55 : Index element (6 n)
 * Position 56-60 : Teneur (5 n avec decimales, ex: 0.24)
 */
final class ICLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'IC';
    }

    protected function doParse(string $line, int $lineNumber): CompositionFertilisation
    {
        $idParcelle = $this->extractField($line, 3, 8);
        $annee = $this->extractInt($line, 11, 4);
        $refIntervention = $this->extractField($line, 15, 32);

        // Code element chimique
        $codeElement = $this->extractField($line, 47, 2);

        // Index et teneur
        $indexElement = $this->extractInt($line, 50, 6);
        $teneur = $this->extractFloat($line, 56, 5);

        // Si la teneur n'est pas trouvee a cette position, on cherche ailleurs
        if (null === $teneur || 0.0 === $teneur) {
            $teneur = $this->extractTeneurFromEnd($line);
        }

        return new CompositionFertilisation(
            identifiantParcelle: $idParcelle,
            annee: $annee,
            refIntervention: $refIntervention,
            codeElement: $codeElement,
            indexElement: $indexElement,
            teneur: $teneur,
        );
    }

    /**
     * Extrait la teneur depuis la fin de la ligne.
     */
    private function extractTeneurFromEnd(string $line): ?float
    {
        // Recherche d'un nombre decimal a la fin
        if (preg_match('/(\d*\.?\d+)\s*$/', trim($line), $matches)) {
            $value = (float) $matches[1];

            // La teneur est generalement entre 0 et 1 (pourcentage)
            return $value <= 1.0 ? $value : $value / 100;
        }

        return null;
    }
}
