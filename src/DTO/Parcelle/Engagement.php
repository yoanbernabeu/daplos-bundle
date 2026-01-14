<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Parcelle;

/**
 * DTO pour le FLAG PE (Engagement).
 */
final class Engagement
{
    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $libelle = null,
        public readonly ?string $codeEngagement = null,
        public readonly ?\DateTimeImmutable $dateDebut = null,
        public readonly ?\DateTimeImmutable $dateFin = null,
    ) {
    }
}
