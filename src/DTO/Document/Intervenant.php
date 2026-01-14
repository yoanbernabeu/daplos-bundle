<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Document;

/**
 * DTO pour le FLAG DA (Adresses Intervenants).
 */
final class Intervenant
{
    public const TYPE_TF = 'TF'; // Exploitant (Travailleur Foncier)
    public const TYPE_FR = 'FR'; // Fournisseur
    public const TYPE_MR = 'MR'; // Mandataire
    public const TYPE_BY = 'BY'; // Acheteur (Buyer)
    public const TYPE_SE = 'SE'; // Vendeur (Seller)
    public const TYPE_SU = 'SU'; // Fournisseur (Supplier)

    public function __construct(
        public readonly ?string $typeIntervenant = null,
        public readonly ?string $identification = null,
        public readonly ?string $typeIdentification = null,
        public readonly ?string $raisonSociale1 = null,
        public readonly ?string $raisonSociale2 = null,
        public readonly ?string $adresseRue1 = null,
        public readonly ?string $adresseRue2 = null,
        public readonly ?string $ville = null,
        public readonly ?string $codePostal = null,
        public readonly ?string $codePays = null,
        public readonly ?string $codeCommune = null,
        public readonly ?string $numeroPackage = null,
    ) {
    }

    public function isExploitant(): bool
    {
        return self::TYPE_TF === $this->typeIntervenant;
    }

    public function isFournisseur(): bool
    {
        return in_array($this->typeIntervenant, [self::TYPE_FR, self::TYPE_SU], true);
    }

    public function isMandataire(): bool
    {
        return self::TYPE_MR === $this->typeIntervenant;
    }
}
