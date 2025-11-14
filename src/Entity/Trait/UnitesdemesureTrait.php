<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Unités de mesure"
 *
 * Repository Code: List_UnitCode
 * Référentiel ID: 637
 * Nombre d'items: 23
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait UnitesdemesureTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $unitesdemesureId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $unitesdemesureTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $unitesdemesureReferenceCode = null;

    public function getUnitesdemesureId(): ?int
    {
        return $this->unitesdemesureId;
    }

    public function setUnitesdemesureId(?int $unitesdemesureId): self
    {
        $this->unitesdemesureId = $unitesdemesureId;
        return $this;
    }

    public function getUnitesdemesureTitle(): ?string
    {
        return $this->unitesdemesureTitle;
    }

    public function setUnitesdemesureTitle(?string $unitesdemesureTitle): self
    {
        $this->unitesdemesureTitle = $unitesdemesureTitle;
        return $this;
    }

    public function getUnitesdemesureReferenceCode(): ?string
    {
        return $this->unitesdemesureReferenceCode;
    }

    public function setUnitesdemesureReferenceCode(?string $unitesdemesureReferenceCode): self
    {
        $this->unitesdemesureReferenceCode = $unitesdemesureReferenceCode;
        return $this;
    }
}
