<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Parcelle;

/**
 * DTO pour le FLAG PA (Analyse de sol).
 */
final class Analyse
{
    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $typeAnalyse = null,
        public readonly ?string $laboratoire = null,
        public readonly ?\DateTimeImmutable $datePrelevement = null,
        public readonly ?\DateTimeImmutable $dateAnalyse = null,
    ) {
    }
}
