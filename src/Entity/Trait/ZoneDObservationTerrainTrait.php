<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Zone d’observation terrain".
 *
 * Repository Code: List_SpecifiedLocation_CodeType
 * Référentiel ID: 677
 * Nombre d'items: 2
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété zoneDObservationTerrainId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $zoneDObservationTerrainId = null;
 */
trait ZoneDObservationTerrainTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $zoneDObservationTerrainId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $zoneDObservationTerrainTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $zoneDObservationTerrainReferenceCode = null;

    public function getZoneDObservationTerrainId(): ?int
    {
        return $this->zoneDObservationTerrainId;
    }

    public function setZoneDObservationTerrainId(?int $zoneDObservationTerrainId): self
    {
        $this->zoneDObservationTerrainId = $zoneDObservationTerrainId;

        return $this;
    }

    public function getZoneDObservationTerrainTitle(): ?string
    {
        return $this->zoneDObservationTerrainTitle;
    }

    public function setZoneDObservationTerrainTitle(?string $zoneDObservationTerrainTitle): self
    {
        $this->zoneDObservationTerrainTitle = $zoneDObservationTerrainTitle;

        return $this;
    }

    public function getZoneDObservationTerrainReferenceCode(): ?string
    {
        return $this->zoneDObservationTerrainReferenceCode;
    }

    public function setZoneDObservationTerrainReferenceCode(?string $zoneDObservationTerrainReferenceCode): self
    {
        $this->zoneDObservationTerrainReferenceCode = $zoneDObservationTerrainReferenceCode;

        return $this;
    }
}
