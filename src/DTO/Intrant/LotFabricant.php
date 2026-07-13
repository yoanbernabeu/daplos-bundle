<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Intrant;

/**
 * DTO pour le FLAG IL (Lot Fabricant).
 */
final class LotFabricant
{
    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $refIntervention = null,
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser (les positions 47-81 portent le code produit, voir $codeProduit) */
        public readonly ?int $indexLot = null,
        public readonly ?string $numeroLot = null,
        public readonly ?float $quantite = null,
        public readonly ?string $codeUnite = null,
        public readonly ?string $codeProduit = null,
        public readonly ?float $pmg = null,
        public readonly ?string $codeUnitePmg = null,
    ) {
    }
}
