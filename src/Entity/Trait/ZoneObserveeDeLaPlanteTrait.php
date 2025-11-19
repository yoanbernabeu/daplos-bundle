<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Zone observée de la plante".
 *
 * Repository Code: List_AgroObsBasisType_CodeType
 * Référentiel ID: 661
 * Nombre d'items: 114
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété zoneObserveeDeLaPlanteId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $zoneObserveeDeLaPlanteId = null;
 */
trait ZoneObserveeDeLaPlanteTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $zoneObserveeDeLaPlanteId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $zoneObserveeDeLaPlanteTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $zoneObserveeDeLaPlanteReferenceCode = null;

    public function getZoneObserveeDeLaPlanteId(): ?int
    {
        return $this->zoneObserveeDeLaPlanteId;
    }

    public function setZoneObserveeDeLaPlanteId(?int $zoneObserveeDeLaPlanteId): self
    {
        $this->zoneObserveeDeLaPlanteId = $zoneObserveeDeLaPlanteId;

        return $this;
    }

    public function getZoneObserveeDeLaPlanteTitle(): ?string
    {
        return $this->zoneObserveeDeLaPlanteTitle;
    }

    public function setZoneObserveeDeLaPlanteTitle(?string $zoneObserveeDeLaPlanteTitle): self
    {
        $this->zoneObserveeDeLaPlanteTitle = $zoneObserveeDeLaPlanteTitle;

        return $this;
    }

    public function getZoneObserveeDeLaPlanteReferenceCode(): ?string
    {
        return $this->zoneObserveeDeLaPlanteReferenceCode;
    }

    public function setZoneObserveeDeLaPlanteReferenceCode(?string $zoneObserveeDeLaPlanteReferenceCode): self
    {
        $this->zoneObserveeDeLaPlanteReferenceCode = $zoneObserveeDeLaPlanteReferenceCode;

        return $this;
    }
}
