<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Intervention;

/**
 * DTO pour le FLAG VB (Cible Evenement).
 */
final class CibleEvenement
{
    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $refIntervention = null,
        public readonly ?string $codeOrganismeCible = null,
        public readonly ?string $codeSousTypeOrganisme = null,
    ) {
    }
}
