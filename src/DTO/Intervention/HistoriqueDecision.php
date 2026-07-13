<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Intervention;

/**
 * DTO pour le FLAG VH (Historique Indicateur de decision).
 */
final class HistoriqueDecision
{
    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $refIntervention = null,
        /** @deprecated champ hors guide v0.95 (fourre-tout), plus jamais rempli par le parser */
        public readonly ?string $decision = null,
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser */
        public readonly ?\DateTimeImmutable $dateDecision = null,
        public readonly ?string $codeTypeLien = null,
        public readonly ?string $refEvenementConsidere = null,
        public readonly ?string $numeroParcelleAnterieur = null,
        public readonly ?int $anneeRecolte = null,
        public readonly ?string $identificationExploitation = null,
        public readonly ?string $codeTypeIdentification = null,
        public readonly ?string $exploitationRaisonSociale1 = null,
        public readonly ?string $exploitationRaisonSociale2 = null,
        public readonly ?string $exploitationAdresse1 = null,
        public readonly ?string $exploitationAdresse2 = null,
        public readonly ?string $exploitationVille = null,
        public readonly ?string $exploitationCodePostal = null,
        public readonly ?string $exploitationPays = null,
        public readonly ?string $infoParcelleNonEdi1 = null,
        public readonly ?string $infoParcelleNonEdi2 = null,
    ) {
    }
}
