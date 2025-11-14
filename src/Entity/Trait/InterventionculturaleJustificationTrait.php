<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Intervention culturale (Justification)".
 *
 * Repository Code: List_AgriculturalProcessReason_CodeType
 * Référentiel ID: 599
 * Nombre d'items: 19
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait InterventionculturaleJustificationTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $interventionculturaleJustificationId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $interventionculturaleJustificationTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $interventionculturaleJustificationReferenceCode = null;

    public function getInterventionculturaleJustificationId(): ?int
    {
        return $this->interventionculturaleJustificationId;
    }

    public function setInterventionculturaleJustificationId(?int $interventionculturaleJustificationId): self
    {
        $this->interventionculturaleJustificationId = $interventionculturaleJustificationId;

        return $this;
    }

    public function getInterventionculturaleJustificationTitle(): ?string
    {
        return $this->interventionculturaleJustificationTitle;
    }

    public function setInterventionculturaleJustificationTitle(?string $interventionculturaleJustificationTitle): self
    {
        $this->interventionculturaleJustificationTitle = $interventionculturaleJustificationTitle;

        return $this;
    }

    public function getInterventionculturaleJustificationReferenceCode(): ?string
    {
        return $this->interventionculturaleJustificationReferenceCode;
    }

    public function setInterventionculturaleJustificationReferenceCode(?string $interventionculturaleJustificationReferenceCode): self
    {
        $this->interventionculturaleJustificationReferenceCode = $interventionculturaleJustificationReferenceCode;

        return $this;
    }
}
