<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Intervention culturale (Type)".
 *
 * Repository Code: List_PlotAgriculturalProcess_CodeType
 * Référentiel ID: 625
 * Nombre d'items: 6
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait InterventionculturaleTypeTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $interventionculturaleTypeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $interventionculturaleTypeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $interventionculturaleTypeReferenceCode = null;

    public function getInterventionculturaleTypeId(): ?int
    {
        return $this->interventionculturaleTypeId;
    }

    public function setInterventionculturaleTypeId(?int $interventionculturaleTypeId): self
    {
        $this->interventionculturaleTypeId = $interventionculturaleTypeId;

        return $this;
    }

    public function getInterventionculturaleTypeTitle(): ?string
    {
        return $this->interventionculturaleTypeTitle;
    }

    public function setInterventionculturaleTypeTitle(?string $interventionculturaleTypeTitle): self
    {
        $this->interventionculturaleTypeTitle = $interventionculturaleTypeTitle;

        return $this;
    }

    public function getInterventionculturaleTypeReferenceCode(): ?string
    {
        return $this->interventionculturaleTypeReferenceCode;
    }

    public function setInterventionculturaleTypeReferenceCode(?string $interventionculturaleTypeReferenceCode): self
    {
        $this->interventionculturaleTypeReferenceCode = $interventionculturaleTypeReferenceCode;

        return $this;
    }
}
