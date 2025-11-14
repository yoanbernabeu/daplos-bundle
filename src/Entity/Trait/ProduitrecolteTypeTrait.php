<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Produit récolté (Type)".
 *
 * Repository Code: List_AgriculturalProduce_CodeType
 * Référentiel ID: 605
 * Nombre d'items: 6
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait ProduitrecolteTypeTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $produitrecolteTypeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $produitrecolteTypeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $produitrecolteTypeReferenceCode = null;

    public function getProduitrecolteTypeId(): ?int
    {
        return $this->produitrecolteTypeId;
    }

    public function setProduitrecolteTypeId(?int $produitrecolteTypeId): self
    {
        $this->produitrecolteTypeId = $produitrecolteTypeId;

        return $this;
    }

    public function getProduitrecolteTypeTitle(): ?string
    {
        return $this->produitrecolteTypeTitle;
    }

    public function setProduitrecolteTypeTitle(?string $produitrecolteTypeTitle): self
    {
        $this->produitrecolteTypeTitle = $produitrecolteTypeTitle;

        return $this;
    }

    public function getProduitrecolteTypeReferenceCode(): ?string
    {
        return $this->produitrecolteTypeReferenceCode;
    }

    public function setProduitrecolteTypeReferenceCode(?string $produitrecolteTypeReferenceCode): self
    {
        $this->produitrecolteTypeReferenceCode = $produitrecolteTypeReferenceCode;

        return $this;
    }
}
