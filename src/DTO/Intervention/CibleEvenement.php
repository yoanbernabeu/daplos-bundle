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
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser (les positions 50-61 portent la cible v0.95, voir $codeCibleV095) */
        public readonly ?string $codeSousTypeOrganisme = null,
        public readonly ?string $codeCibleV095 = null,
    ) {
    }
}
