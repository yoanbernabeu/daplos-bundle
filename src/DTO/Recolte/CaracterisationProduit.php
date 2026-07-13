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

    /**
     * Accès numérique à la valeur de la caractéristique (format guide 9 n).
     */
    public function getValeurNumerique(): ?float
    {
        if (null === $this->valeur) {
            return null;
        }

        $normalized = str_replace(',', '.', $this->valeur);

        return is_numeric($normalized) ? (float) $normalized : null;
    }
}
