<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Statut d'une intervention"
 *
 * Repository Code: List_PlotAgriculturalProcessSubordinateTypeCode_CodeType
 * Référentiel ID: 601
 * Nombre d'items: 4
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété statutDUneInterventionId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $statutDUneInterventionId = null;
 */
trait StatutDUneInterventionTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $statutDUneInterventionId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $statutDUneInterventionTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $statutDUneInterventionReferenceCode = null;

    public function getStatutDUneInterventionId(): ?int
    {
        return $this->statutDUneInterventionId;
    }

    public function setStatutDUneInterventionId(?int $statutDUneInterventionId): self
    {
        $this->statutDUneInterventionId = $statutDUneInterventionId;
        return $this;
    }

    public function getStatutDUneInterventionTitle(): ?string
    {
        return $this->statutDUneInterventionTitle;
    }

    public function setStatutDUneInterventionTitle(?string $statutDUneInterventionTitle): self
    {
        $this->statutDUneInterventionTitle = $statutDUneInterventionTitle;
        return $this;
    }

    public function getStatutDUneInterventionReferenceCode(): ?string
    {
        return $this->statutDUneInterventionReferenceCode;
    }

    public function setStatutDUneInterventionReferenceCode(?string $statutDUneInterventionReferenceCode): self
    {
        $this->statutDUneInterventionReferenceCode = $statutDUneInterventionReferenceCode;
        return $this;
    }
}
