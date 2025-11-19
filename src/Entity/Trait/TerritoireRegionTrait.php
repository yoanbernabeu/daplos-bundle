<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Territoire / Région".
 *
 * Repository Code: List_ReferenceType_CodeType
 * Référentiel ID: 681
 * Nombre d'items: 28
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété territoireRegionId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $territoireRegionId = null;
 */
trait TerritoireRegionTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $territoireRegionId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $territoireRegionTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $territoireRegionReferenceCode = null;

    public function getTerritoireRegionId(): ?int
    {
        return $this->territoireRegionId;
    }

    public function setTerritoireRegionId(?int $territoireRegionId): self
    {
        $this->territoireRegionId = $territoireRegionId;

        return $this;
    }

    public function getTerritoireRegionTitle(): ?string
    {
        return $this->territoireRegionTitle;
    }

    public function setTerritoireRegionTitle(?string $territoireRegionTitle): self
    {
        $this->territoireRegionTitle = $territoireRegionTitle;

        return $this;
    }

    public function getTerritoireRegionReferenceCode(): ?string
    {
        return $this->territoireRegionReferenceCode;
    }

    public function setTerritoireRegionReferenceCode(?string $territoireRegionReferenceCode): self
    {
        $this->territoireRegionReferenceCode = $territoireRegionReferenceCode;

        return $this;
    }
}
