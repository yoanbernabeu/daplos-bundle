<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Justification de l'intervention".
 *
 * Repository Code: List_AgriculturalProcessReason_CodeType
 * Référentiel ID: 599
 * Nombre d'items: 19
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété justificationDeLInterventionId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $justificationDeLInterventionId = null;
 */
trait JustificationDeLInterventionTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $justificationDeLInterventionId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $justificationDeLInterventionTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $justificationDeLInterventionReferenceCode = null;

    public function getJustificationDeLInterventionId(): ?int
    {
        return $this->justificationDeLInterventionId;
    }

    public function setJustificationDeLInterventionId(?int $justificationDeLInterventionId): self
    {
        $this->justificationDeLInterventionId = $justificationDeLInterventionId;

        return $this;
    }

    public function getJustificationDeLInterventionTitle(): ?string
    {
        return $this->justificationDeLInterventionTitle;
    }

    public function setJustificationDeLInterventionTitle(?string $justificationDeLInterventionTitle): self
    {
        $this->justificationDeLInterventionTitle = $justificationDeLInterventionTitle;

        return $this;
    }

    public function getJustificationDeLInterventionReferenceCode(): ?string
    {
        return $this->justificationDeLInterventionReferenceCode;
    }

    public function setJustificationDeLInterventionReferenceCode(?string $justificationDeLInterventionReferenceCode): self
    {
        $this->justificationDeLInterventionReferenceCode = $justificationDeLInterventionReferenceCode;

        return $this;
    }
}
