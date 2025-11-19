<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Amendements du sol"
 *
 * Repository Code: List_SpecifiedSoilSupplement_CodeType
 * Référentiel ID: 633
 * Nombre d'items: 3
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété amendementsDuSolId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $amendementsDuSolId = null;
 */
trait AmendementsDuSolTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $amendementsDuSolId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $amendementsDuSolTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $amendementsDuSolReferenceCode = null;

    public function getAmendementsDuSolId(): ?int
    {
        return $this->amendementsDuSolId;
    }

    public function setAmendementsDuSolId(?int $amendementsDuSolId): self
    {
        $this->amendementsDuSolId = $amendementsDuSolId;
        return $this;
    }

    public function getAmendementsDuSolTitle(): ?string
    {
        return $this->amendementsDuSolTitle;
    }

    public function setAmendementsDuSolTitle(?string $amendementsDuSolTitle): self
    {
        $this->amendementsDuSolTitle = $amendementsDuSolTitle;
        return $this;
    }

    public function getAmendementsDuSolReferenceCode(): ?string
    {
        return $this->amendementsDuSolReferenceCode;
    }

    public function setAmendementsDuSolReferenceCode(?string $amendementsDuSolReferenceCode): self
    {
        $this->amendementsDuSolReferenceCode = $amendementsDuSolReferenceCode;
        return $this;
    }
}
