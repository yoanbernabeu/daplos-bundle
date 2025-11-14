<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Intervention culturale (Qualifiant)"
 *
 * Repository Code: List_PlotAgriculturalProcessSubordinateTypeCode_CodeType
 * Référentiel ID: 601
 * Nombre d'items: 4
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait InterventionculturaleQualifiantTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $interventionculturaleQualifiantId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $interventionculturaleQualifiantTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $interventionculturaleQualifiantReferenceCode = null;

    public function getInterventionculturaleQualifiantId(): ?int
    {
        return $this->interventionculturaleQualifiantId;
    }

    public function setInterventionculturaleQualifiantId(?int $interventionculturaleQualifiantId): self
    {
        $this->interventionculturaleQualifiantId = $interventionculturaleQualifiantId;
        return $this;
    }

    public function getInterventionculturaleQualifiantTitle(): ?string
    {
        return $this->interventionculturaleQualifiantTitle;
    }

    public function setInterventionculturaleQualifiantTitle(?string $interventionculturaleQualifiantTitle): self
    {
        $this->interventionculturaleQualifiantTitle = $interventionculturaleQualifiantTitle;
        return $this;
    }

    public function getInterventionculturaleQualifiantReferenceCode(): ?string
    {
        return $this->interventionculturaleQualifiantReferenceCode;
    }

    public function setInterventionculturaleQualifiantReferenceCode(?string $interventionculturaleQualifiantReferenceCode): self
    {
        $this->interventionculturaleQualifiantReferenceCode = $interventionculturaleQualifiantReferenceCode;
        return $this;
    }
}
