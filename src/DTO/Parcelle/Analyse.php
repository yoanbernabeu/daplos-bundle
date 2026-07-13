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
        /** @deprecated champ hors guide v0.95 (les positions 15-49 portent le n° de bordereau), plus jamais rempli par le parser — voir $numeroBordereau */
        public readonly ?string $typeAnalyse = null,
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser — voir $laboratoireRaisonSociale1 */
        public readonly ?string $laboratoire = null,
        public readonly ?\DateTimeImmutable $datePrelevement = null,
        public readonly ?\DateTimeImmutable $dateAnalyse = null,
        public readonly ?string $numeroBordereau = null,
        public readonly ?string $identificationLaboratoire = null,
        public readonly ?string $laboratoireRaisonSociale1 = null,
        public readonly ?string $laboratoireRaisonSociale2 = null,
        public readonly ?string $laboratoireAdresseRue1 = null,
        public readonly ?string $laboratoireAdresseRue2 = null,
        public readonly ?string $laboratoireVille = null,
        public readonly ?string $laboratoireCodePostal = null,
        public readonly ?string $laboratoirePays = null,
    ) {
    }
}
