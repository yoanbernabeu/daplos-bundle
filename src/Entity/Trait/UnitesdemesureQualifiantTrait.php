<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Unités de mesure (Qualifiant)".
 *
 * Repository Code: List_ValueExpression_CodeType
 * Référentiel ID: 671
 * Nombre d'items: 293
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait UnitesdemesureQualifiantTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $unitesdemesureQualifiantId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $unitesdemesureQualifiantTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $unitesdemesureQualifiantReferenceCode = null;

    public function getUnitesdemesureQualifiantId(): ?int
    {
        return $this->unitesdemesureQualifiantId;
    }

    public function setUnitesdemesureQualifiantId(?int $unitesdemesureQualifiantId): self
    {
        $this->unitesdemesureQualifiantId = $unitesdemesureQualifiantId;

        return $this;
    }

    public function getUnitesdemesureQualifiantTitle(): ?string
    {
        return $this->unitesdemesureQualifiantTitle;
    }

    public function setUnitesdemesureQualifiantTitle(?string $unitesdemesureQualifiantTitle): self
    {
        $this->unitesdemesureQualifiantTitle = $unitesdemesureQualifiantTitle;

        return $this;
    }

    public function getUnitesdemesureQualifiantReferenceCode(): ?string
    {
        return $this->unitesdemesureQualifiantReferenceCode;
    }

    public function setUnitesdemesureQualifiantReferenceCode(?string $unitesdemesureQualifiantReferenceCode): self
    {
        $this->unitesdemesureQualifiantReferenceCode = $unitesdemesureQualifiantReferenceCode;

        return $this;
    }
}
