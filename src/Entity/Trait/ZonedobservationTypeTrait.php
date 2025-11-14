<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Zone d'observation (Type)"
 *
 * Repository Code: List_SpecifiedLocation_CodeType
 * Référentiel ID: 677
 * Nombre d'items: 2
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait ZonedobservationTypeTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $zonedobservationTypeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $zonedobservationTypeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $zonedobservationTypeReferenceCode = null;

    public function getZonedobservationTypeId(): ?int
    {
        return $this->zonedobservationTypeId;
    }

    public function setZonedobservationTypeId(?int $zonedobservationTypeId): self
    {
        $this->zonedobservationTypeId = $zonedobservationTypeId;
        return $this;
    }

    public function getZonedobservationTypeTitle(): ?string
    {
        return $this->zonedobservationTypeTitle;
    }

    public function setZonedobservationTypeTitle(?string $zonedobservationTypeTitle): self
    {
        $this->zonedobservationTypeTitle = $zonedobservationTypeTitle;
        return $this;
    }

    public function getZonedobservationTypeReferenceCode(): ?string
    {
        return $this->zonedobservationTypeReferenceCode;
    }

    public function setZonedobservationTypeReferenceCode(?string $zonedobservationTypeReferenceCode): self
    {
        $this->zonedobservationTypeReferenceCode = $zonedobservationTypeReferenceCode;
        return $this;
    }
}
