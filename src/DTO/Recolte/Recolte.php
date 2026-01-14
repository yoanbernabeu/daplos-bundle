<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Recolte;

/**
 * DTO pour le FLAG VR (Recolte).
 */
final class Recolte
{
    /** @var array<LotRecolte> */
    private array $lots = [];

    /** @var array<CaracterisationProduit> */
    private array $caracterisations = [];

    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $refIntervention = null,
        public readonly ?string $codeTypeProduitRecolte = null,
        public readonly ?string $codeEspeceBotanique = null,
        public readonly ?string $libelleProduit = null,
        public readonly ?float $quantite = null,
        public readonly ?string $codeUnite = null,
        public readonly ?string $destinationProduit = null,
    ) {
    }

    public function addLot(LotRecolte $lot): void
    {
        $this->lots[] = $lot;
    }

    /**
     * @return array<LotRecolte>
     */
    public function getLots(): array
    {
        return $this->lots;
    }

    public function addCaracterisation(CaracterisationProduit $caracterisation): void
    {
        $this->caracterisations[] = $caracterisation;
    }

    /**
     * @return array<CaracterisationProduit>
     */
    public function getCaracterisations(): array
    {
        return $this->caracterisations;
    }
}
