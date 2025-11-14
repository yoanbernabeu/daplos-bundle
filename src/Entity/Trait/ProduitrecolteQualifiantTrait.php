<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Produit récolté (Qualifiant)"
 *
 * Repository Code: List_AgriculturalProduceSubordinateTypeCode_CodeType
 * Référentiel ID: 607
 * Nombre d'items: 0
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait ProduitrecolteQualifiantTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $produitrecolteQualifiantId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $produitrecolteQualifiantTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $produitrecolteQualifiantReferenceCode = null;

    public function getProduitrecolteQualifiantId(): ?int
    {
        return $this->produitrecolteQualifiantId;
    }

    public function setProduitrecolteQualifiantId(?int $produitrecolteQualifiantId): self
    {
        $this->produitrecolteQualifiantId = $produitrecolteQualifiantId;
        return $this;
    }

    public function getProduitrecolteQualifiantTitle(): ?string
    {
        return $this->produitrecolteQualifiantTitle;
    }

    public function setProduitrecolteQualifiantTitle(?string $produitrecolteQualifiantTitle): self
    {
        $this->produitrecolteQualifiantTitle = $produitrecolteQualifiantTitle;
        return $this;
    }

    public function getProduitrecolteQualifiantReferenceCode(): ?string
    {
        return $this->produitrecolteQualifiantReferenceCode;
    }

    public function setProduitrecolteQualifiantReferenceCode(?string $produitrecolteQualifiantReferenceCode): self
    {
        $this->produitrecolteQualifiantReferenceCode = $produitrecolteQualifiantReferenceCode;
        return $this;
    }
}
