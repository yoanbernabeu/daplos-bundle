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
        public readonly ?int $indexLot = null,
        public readonly ?string $numeroLot = null,
        public readonly ?float $quantite = null,
        public readonly ?string $codeUnite = null,
    ) {
    }
}
