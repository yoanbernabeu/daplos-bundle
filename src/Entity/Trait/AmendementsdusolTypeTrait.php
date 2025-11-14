<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Amendements du sol (Type)".
 *
 * Repository Code: List_SpecifiedSoilSupplement_CodeType
 * Référentiel ID: 633
 * Nombre d'items: 3
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait AmendementsdusolTypeTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $amendementsdusolTypeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $amendementsdusolTypeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $amendementsdusolTypeReferenceCode = null;

    public function getAmendementsdusolTypeId(): ?int
    {
        return $this->amendementsdusolTypeId;
    }

    public function setAmendementsdusolTypeId(?int $amendementsdusolTypeId): self
    {
        $this->amendementsdusolTypeId = $amendementsdusolTypeId;

        return $this;
    }

    public function getAmendementsdusolTypeTitle(): ?string
    {
        return $this->amendementsdusolTypeTitle;
    }

    public function setAmendementsdusolTypeTitle(?string $amendementsdusolTypeTitle): self
    {
        $this->amendementsdusolTypeTitle = $amendementsdusolTypeTitle;

        return $this;
    }

    public function getAmendementsdusolTypeReferenceCode(): ?string
    {
        return $this->amendementsdusolTypeReferenceCode;
    }

    public function setAmendementsdusolTypeReferenceCode(?string $amendementsdusolTypeReferenceCode): self
    {
        $this->amendementsdusolTypeReferenceCode = $amendementsdusolTypeReferenceCode;

        return $this;
    }
}
