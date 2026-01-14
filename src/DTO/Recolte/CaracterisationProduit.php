<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Recolte;

/**
 * DTO pour le FLAG LC (Caracterisation Produit).
 */
final class CaracterisationProduit
{
    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $refIntervention = null,
        public readonly ?string $codeCaracteristique = null,
        public readonly ?string $valeur = null,
        public readonly ?string $codeUnite = null,
    ) {
    }
}
