<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Parcelle;

/**
 * DTO pour le FLAG HA (Amendement/Residus).
 */
final class Amendement
{
    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $codeAmendement = null,
        public readonly ?float $quantite = null,
        public readonly ?string $codeUnite = null,
        public readonly ?string $complementTypeAmendement = null,
        public readonly ?\DateTimeImmutable $dateAmendement = null,
        public readonly ?string $origineRaisonSociale1 = null,
        public readonly ?string $origineRaisonSociale2 = null,
        public readonly ?string $origineAdresseRue1 = null,
        public readonly ?string $origineAdresseRue2 = null,
        public readonly ?string $origineVille = null,
        public readonly ?string $origineCodePostal = null,
        public readonly ?string $originePays = null,
    ) {
    }
}
