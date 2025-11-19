<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Type d'occupation du sol".
 *
 * Repository Code: List_PlotSoilOccupation_CodeType
 * Référentiel ID: 685
 * Nombre d'items: 12
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété typeDOccupationDuSolId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $typeDOccupationDuSolId = null;
 */
trait TypeDOccupationDuSolTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $typeDOccupationDuSolId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typeDOccupationDuSolTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $typeDOccupationDuSolReferenceCode = null;

    public function getTypeDOccupationDuSolId(): ?int
    {
        return $this->typeDOccupationDuSolId;
    }

    public function setTypeDOccupationDuSolId(?int $typeDOccupationDuSolId): self
    {
        $this->typeDOccupationDuSolId = $typeDOccupationDuSolId;

        return $this;
    }

    public function getTypeDOccupationDuSolTitle(): ?string
    {
        return $this->typeDOccupationDuSolTitle;
    }

    public function setTypeDOccupationDuSolTitle(?string $typeDOccupationDuSolTitle): self
    {
        $this->typeDOccupationDuSolTitle = $typeDOccupationDuSolTitle;

        return $this;
    }

    public function getTypeDOccupationDuSolReferenceCode(): ?string
    {
        return $this->typeDOccupationDuSolReferenceCode;
    }

    public function setTypeDOccupationDuSolReferenceCode(?string $typeDOccupationDuSolReferenceCode): self
    {
        $this->typeDOccupationDuSolReferenceCode = $typeDOccupationDuSolReferenceCode;

        return $this;
    }
}
