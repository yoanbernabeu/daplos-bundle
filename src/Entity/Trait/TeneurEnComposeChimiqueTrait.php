<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Teneur en composé chimique"
 *
 * Repository Code: List_CropInputChemical_CodeType
 * Référentiel ID: 613
 * Nombre d'items: 17
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété teneurEnComposeChimiqueId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $teneurEnComposeChimiqueId = null;
 */
trait TeneurEnComposeChimiqueTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $teneurEnComposeChimiqueId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $teneurEnComposeChimiqueTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $teneurEnComposeChimiqueReferenceCode = null;

    public function getTeneurEnComposeChimiqueId(): ?int
    {
        return $this->teneurEnComposeChimiqueId;
    }

    public function setTeneurEnComposeChimiqueId(?int $teneurEnComposeChimiqueId): self
    {
        $this->teneurEnComposeChimiqueId = $teneurEnComposeChimiqueId;
        return $this;
    }

    public function getTeneurEnComposeChimiqueTitle(): ?string
    {
        return $this->teneurEnComposeChimiqueTitle;
    }

    public function setTeneurEnComposeChimiqueTitle(?string $teneurEnComposeChimiqueTitle): self
    {
        $this->teneurEnComposeChimiqueTitle = $teneurEnComposeChimiqueTitle;
        return $this;
    }

    public function getTeneurEnComposeChimiqueReferenceCode(): ?string
    {
        return $this->teneurEnComposeChimiqueReferenceCode;
    }

    public function setTeneurEnComposeChimiqueReferenceCode(?string $teneurEnComposeChimiqueReferenceCode): self
    {
        $this->teneurEnComposeChimiqueReferenceCode = $teneurEnComposeChimiqueReferenceCode;
        return $this;
    }
}
