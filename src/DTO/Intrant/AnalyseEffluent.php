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
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser */
        public readonly ?string $typeAnalyse = null,
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser */
        public readonly ?string $codeElement = null,
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser */
        public readonly ?float $valeur = null,
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser */
        public readonly ?string $codeUnite = null,
        public readonly ?string $numeroBordereau = null,
        public readonly ?string $identificationLaboratoire = null,
        public readonly ?string $laboratoireRaisonSociale1 = null,
        public readonly ?string $laboratoireRaisonSociale2 = null,
        public readonly ?string $laboratoireAdresse1 = null,
        public readonly ?string $laboratoireAdresse2 = null,
        public readonly ?string $laboratoireVille = null,
        public readonly ?string $laboratoireCodePostal = null,
        public readonly ?string $laboratoirePays = null,
        public readonly ?\DateTimeImmutable $dateAnalyse = null,
        public readonly ?\DateTimeImmutable $datePrelevement = null,
    ) {
    }
}
