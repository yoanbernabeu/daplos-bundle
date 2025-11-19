<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Famille d'intrant"
 *
 * Repository Code: List_AgriculturalProcessCropInput_CodeType
 * Référentiel ID: 593
 * Nombre d'items: 35
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété familleDIntrantId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $familleDIntrantId = null;
 */
trait FamilleDIntrantTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $familleDIntrantId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $familleDIntrantTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $familleDIntrantReferenceCode = null;

    public function getFamilleDIntrantId(): ?int
    {
        return $this->familleDIntrantId;
    }

    public function setFamilleDIntrantId(?int $familleDIntrantId): self
    {
        $this->familleDIntrantId = $familleDIntrantId;
        return $this;
    }

    public function getFamilleDIntrantTitle(): ?string
    {
        return $this->familleDIntrantTitle;
    }

    public function setFamilleDIntrantTitle(?string $familleDIntrantTitle): self
    {
        $this->familleDIntrantTitle = $familleDIntrantTitle;
        return $this;
    }

    public function getFamilleDIntrantReferenceCode(): ?string
    {
        return $this->familleDIntrantReferenceCode;
    }

    public function setFamilleDIntrantReferenceCode(?string $familleDIntrantReferenceCode): self
    {
        $this->familleDIntrantReferenceCode = $familleDIntrantReferenceCode;
        return $this;
    }
}
