<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Intrant\LotFabricant;

/**
 * Parser pour le FLAG IL (Lot Fabricant).
 *
 * Format observe :
 * Position 1-2   : FLAG "IL"
 * Position 3-10  : Identifiant parcelle (8 an)
 * Position 11-14 : Annee (4 n)
 * Position 15-46 : Reference intervention UUID (32 an)
 * Position 47-49 : Index lot (3 n)
 * Position 50-84 : Numero lot (35 an)
 * Position 85-93 : Quantite (9 n)
 * Position 94-96 : Code unite (3 an)
 */
final class ILLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'IL';
    }

    protected function doParse(string $line, int $lineNumber): LotFabricant
    {
        $idParcelle = $this->extractField($line, 3, 8);
        $annee = $this->extractInt($line, 11, 4);
        $refIntervention = $this->extractField($line, 15, 32);

        // Index lot
        $indexLot = $this->extractInt($line, 47, 3);

        // Numero lot
        $numeroLot = $this->extractField($line, 50, 35);

        // Quantite et unite
        $quantite = $this->extractFloat($line, 85, 9);
        $codeUnite = $this->extractField($line, 94, 3);

        return new LotFabricant(
            identifiantParcelle: $idParcelle,
            annee: $annee,
            refIntervention: $refIntervention,
            indexLot: $indexLot,
            numeroLot: $numeroLot,
            quantite: $quantite,
            codeUnite: $codeUnite,
        );
    }
}
