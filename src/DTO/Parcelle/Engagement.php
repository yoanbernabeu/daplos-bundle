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
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser */
        public readonly ?\DateTimeImmutable $dateDebut = null,
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser */
        public readonly ?\DateTimeImmutable $dateFin = null,
        public readonly ?string $numeroContrat = null,
        public readonly ?\DateTimeImmutable $dateContrat = null,
        public readonly ?string $identificationContractant = null,
        public readonly ?string $typeIdentificationContractant = null,
        public readonly ?string $contractantRaisonSociale1 = null,
        public readonly ?string $contractantRaisonSociale2 = null,
        public readonly ?string $contractantAdresseRue1 = null,
        public readonly ?string $contractantAdresseRue2 = null,
        public readonly ?string $contractantVille = null,
        public readonly ?string $contractantCodePostal = null,
        public readonly ?string $contractantPays = null,
    ) {
    }
}
