<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Intrant;

/**
 * DTO pour le FLAG IA (Analyse Effluent).
 */
final class AnalyseEffluent
{
    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $refIntervention = null,
        public readonly ?string $typeAnalyse = null,
        public readonly ?string $codeElement = null,
        public readonly ?float $valeur = null,
        public readonly ?string $codeUnite = null,
    ) {
    }
}
