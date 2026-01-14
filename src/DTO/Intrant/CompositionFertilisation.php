<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Intrant;

/**
 * DTO pour le FLAG IC (Composition Fertilisation).
 */
final class CompositionFertilisation
{
    // Codes elements chimiques
    public const ELEMENT_NT = 'NT'; // Azote total
    public const ELEMENT_PT = 'PT'; // Phosphore total
    public const ELEMENT_KT = 'KT'; // Potassium total
    public const ELEMENT_CA = 'CA'; // Calcium
    public const ELEMENT_ST = 'ST'; // Soufre total
    public const ELEMENT_NL = 'NL'; // Azote organique
    public const ELEMENT_MT = 'MT'; // Magnesium total
    public const ELEMENT_NJ = 'NJ'; // Azote ammoniacal
    public const ELEMENT_BT = 'BT'; // Bore total

    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $refIntervention = null,
        public readonly ?string $codeElement = null,
        public readonly ?int $indexElement = null,
        public readonly ?float $teneur = null,
    ) {
    }

    /**
     * Retourne le libelle de l'element chimique.
     */
    public function getLibelleElement(): ?string
    {
        return match ($this->codeElement) {
            self::ELEMENT_NT => 'Azote total',
            self::ELEMENT_PT => 'Phosphore total',
            self::ELEMENT_KT => 'Potassium total',
            self::ELEMENT_CA => 'Calcium',
            self::ELEMENT_ST => 'Soufre total',
            self::ELEMENT_NL => 'Azote organique',
            self::ELEMENT_MT => 'Magnesium total',
            self::ELEMENT_NJ => 'Azote ammoniacal',
            self::ELEMENT_BT => 'Bore total',
            default => null,
        };
    }
}
