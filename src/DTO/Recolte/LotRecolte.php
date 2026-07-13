<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Recolte;

/**
 * DTO pour le FLAG RL (Lot Recolte).
 */
final class LotRecolte
{
    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $refIntervention = null,
        public readonly ?string $numeroLot = null,
        public readonly ?float $quantite = null,
        /** @deprecated champ hors guide v0.95 (pas d'unité dans le FLAG RL, quantité en tonnes), plus jamais rempli par le parser */
        public readonly ?string $codeUnite = null,
        public readonly ?string $numeroLotAgriculteur = null,
    ) {
    }
}
