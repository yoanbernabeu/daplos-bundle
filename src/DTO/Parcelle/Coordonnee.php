<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Parcelle;

/**
 * DTO pour les FLAGS SC, CC, VC (Coordonnees).
 */
final class Coordonnee
{
    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $systemeCoordonnees = null,
        public readonly ?float $x = null,
        public readonly ?float $y = null,
        public readonly ?string $refIntervention = null,
    ) {
    }
}
