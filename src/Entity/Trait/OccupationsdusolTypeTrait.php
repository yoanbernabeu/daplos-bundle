<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Occupations du sol (Type)".
 *
 * Repository Code: List_PlotSoilOccupation_CodeType
 * Référentiel ID: 685
 * Nombre d'items: 12
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait OccupationsdusolTypeTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $occupationsdusolTypeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $occupationsdusolTypeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $occupationsdusolTypeReferenceCode = null;

    public function getOccupationsdusolTypeId(): ?int
    {
        return $this->occupationsdusolTypeId;
    }

    public function setOccupationsdusolTypeId(?int $occupationsdusolTypeId): self
    {
        $this->occupationsdusolTypeId = $occupationsdusolTypeId;

        return $this;
    }

    public function getOccupationsdusolTypeTitle(): ?string
    {
        return $this->occupationsdusolTypeTitle;
    }

    public function setOccupationsdusolTypeTitle(?string $occupationsdusolTypeTitle): self
    {
        $this->occupationsdusolTypeTitle = $occupationsdusolTypeTitle;

        return $this;
    }

    public function getOccupationsdusolTypeReferenceCode(): ?string
    {
        return $this->occupationsdusolTypeReferenceCode;
    }

    public function setOccupationsdusolTypeReferenceCode(?string $occupationsdusolTypeReferenceCode): self
    {
        $this->occupationsdusolTypeReferenceCode = $occupationsdusolTypeReferenceCode;

        return $this;
    }
}
