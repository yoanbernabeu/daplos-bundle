<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Réseaux d'observations d'appartenance".
 *
 * Repository Code: List_ReferenceType_CodeType
 * Référentiel ID: 681
 * Nombre d'items: 28
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait ReseauxdobservationsdappartenanceTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $reseauxdobservationsdappartenanceId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $reseauxdobservationsdappartenanceTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $reseauxdobservationsdappartenanceReferenceCode = null;

    public function getReseauxdobservationsdappartenanceId(): ?int
    {
        return $this->reseauxdobservationsdappartenanceId;
    }

    public function setReseauxdobservationsdappartenanceId(?int $reseauxdobservationsdappartenanceId): self
    {
        $this->reseauxdobservationsdappartenanceId = $reseauxdobservationsdappartenanceId;

        return $this;
    }

    public function getReseauxdobservationsdappartenanceTitle(): ?string
    {
        return $this->reseauxdobservationsdappartenanceTitle;
    }

    public function setReseauxdobservationsdappartenanceTitle(?string $reseauxdobservationsdappartenanceTitle): self
    {
        $this->reseauxdobservationsdappartenanceTitle = $reseauxdobservationsdappartenanceTitle;

        return $this;
    }

    public function getReseauxdobservationsdappartenanceReferenceCode(): ?string
    {
        return $this->reseauxdobservationsdappartenanceReferenceCode;
    }

    public function setReseauxdobservationsdappartenanceReferenceCode(?string $reseauxdobservationsdappartenanceReferenceCode): self
    {
        $this->reseauxdobservationsdappartenanceReferenceCode = $reseauxdobservationsdappartenanceReferenceCode;

        return $this;
    }
}
