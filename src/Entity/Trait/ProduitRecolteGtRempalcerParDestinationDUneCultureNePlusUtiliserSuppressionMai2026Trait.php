<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Produit récolté (Ne plus utiliser suppression Mai 2026) --&gt; Rempalcer par destination d'une culture"
 *
 * Repository Code: List_AgriculturalProduceUseCode_CodeType
 * Référentiel ID: 609
 * Nombre d'items: 50
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Id :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Id = null;
 */
trait ProduitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Trait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Title = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026ReferenceCode = null;

    public function getProduitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Id(): ?int
    {
        return $this->produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Id;
    }

    public function setProduitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Id(?int $produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Id): self
    {
        $this->produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Id = $produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Id;
        return $this;
    }

    public function getProduitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Title(): ?string
    {
        return $this->produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Title;
    }

    public function setProduitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Title(?string $produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Title): self
    {
        $this->produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Title = $produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026Title;
        return $this;
    }

    public function getProduitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026ReferenceCode(): ?string
    {
        return $this->produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026ReferenceCode;
    }

    public function setProduitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026ReferenceCode(?string $produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026ReferenceCode): self
    {
        $this->produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026ReferenceCode = $produitRecolteGtRempalcerParDestinationDUneCultureNePlusUtiliserSuppressionMai2026ReferenceCode;
        return $this;
    }
}
