<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Unité de mesure".
 *
 * Repository Code: List_UnitCode
 * Référentiel ID: 637
 * Nombre d'items: 23
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété uniteDeMesureId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $uniteDeMesureId = null;
 */
trait UniteDeMesureTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $uniteDeMesureId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $uniteDeMesureTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $uniteDeMesureReferenceCode = null;

    public function getUniteDeMesureId(): ?int
    {
        return $this->uniteDeMesureId;
    }

    public function setUniteDeMesureId(?int $uniteDeMesureId): self
    {
        $this->uniteDeMesureId = $uniteDeMesureId;

        return $this;
    }

    public function getUniteDeMesureTitle(): ?string
    {
        return $this->uniteDeMesureTitle;
    }

    public function setUniteDeMesureTitle(?string $uniteDeMesureTitle): self
    {
        $this->uniteDeMesureTitle = $uniteDeMesureTitle;

        return $this;
    }

    public function getUniteDeMesureReferenceCode(): ?string
    {
        return $this->uniteDeMesureReferenceCode;
    }

    public function setUniteDeMesureReferenceCode(?string $uniteDeMesureReferenceCode): self
    {
        $this->uniteDeMesureReferenceCode = $uniteDeMesureReferenceCode;

        return $this;
    }
}
