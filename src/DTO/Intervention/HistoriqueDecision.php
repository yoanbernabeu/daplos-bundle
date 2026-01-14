<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Intervention;

/**
 * DTO pour le FLAG VH (Historique Decision).
 */
final class HistoriqueDecision
{
    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $refIntervention = null,
        public readonly ?string $decision = null,
        public readonly ?\DateTimeImmutable $dateDecision = null,
    ) {
    }
}
