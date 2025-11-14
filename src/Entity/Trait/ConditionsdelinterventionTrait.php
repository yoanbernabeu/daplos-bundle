<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Conditions de l'intervention".
 *
 * Repository Code: List_AgriculturalProcessCondition_CodeType
 * Référentiel ID: 591
 * Nombre d'items: 12
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait ConditionsdelinterventionTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $conditionsdelinterventionId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $conditionsdelinterventionTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $conditionsdelinterventionReferenceCode = null;

    public function getConditionsdelinterventionId(): ?int
    {
        return $this->conditionsdelinterventionId;
    }

    public function setConditionsdelinterventionId(?int $conditionsdelinterventionId): self
    {
        $this->conditionsdelinterventionId = $conditionsdelinterventionId;

        return $this;
    }

    public function getConditionsdelinterventionTitle(): ?string
    {
        return $this->conditionsdelinterventionTitle;
    }

    public function setConditionsdelinterventionTitle(?string $conditionsdelinterventionTitle): self
    {
        $this->conditionsdelinterventionTitle = $conditionsdelinterventionTitle;

        return $this;
    }

    public function getConditionsdelinterventionReferenceCode(): ?string
    {
        return $this->conditionsdelinterventionReferenceCode;
    }

    public function setConditionsdelinterventionReferenceCode(?string $conditionsdelinterventionReferenceCode): self
    {
        $this->conditionsdelinterventionReferenceCode = $conditionsdelinterventionReferenceCode;

        return $this;
    }
}
