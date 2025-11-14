<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Produit récolté (Destination)".
 *
 * Repository Code: List_AgriculturalProduceUseCode_CodeType
 * Référentiel ID: 609
 * Nombre d'items: 50
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait ProduitrecolteDestinationTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $produitrecolteDestinationId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $produitrecolteDestinationTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $produitrecolteDestinationReferenceCode = null;

    public function getProduitrecolteDestinationId(): ?int
    {
        return $this->produitrecolteDestinationId;
    }

    public function setProduitrecolteDestinationId(?int $produitrecolteDestinationId): self
    {
        $this->produitrecolteDestinationId = $produitrecolteDestinationId;

        return $this;
    }

    public function getProduitrecolteDestinationTitle(): ?string
    {
        return $this->produitrecolteDestinationTitle;
    }

    public function setProduitrecolteDestinationTitle(?string $produitrecolteDestinationTitle): self
    {
        $this->produitrecolteDestinationTitle = $produitrecolteDestinationTitle;

        return $this;
    }

    public function getProduitrecolteDestinationReferenceCode(): ?string
    {
        return $this->produitrecolteDestinationReferenceCode;
    }

    public function setProduitrecolteDestinationReferenceCode(?string $produitrecolteDestinationReferenceCode): self
    {
        $this->produitrecolteDestinationReferenceCode = $produitrecolteDestinationReferenceCode;

        return $this;
    }
}
