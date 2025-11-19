<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Traitement des résidus de culture"
 *
 * Repository Code: List_SoilOccupationCropResidue_CodeType
 * Référentiel ID: 629
 * Nombre d'items: 4
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété traitementDesResidusDeCultureId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $traitementDesResidusDeCultureId = null;
 */
trait TraitementDesResidusDeCultureTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $traitementDesResidusDeCultureId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $traitementDesResidusDeCultureTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $traitementDesResidusDeCultureReferenceCode = null;

    public function getTraitementDesResidusDeCultureId(): ?int
    {
        return $this->traitementDesResidusDeCultureId;
    }

    public function setTraitementDesResidusDeCultureId(?int $traitementDesResidusDeCultureId): self
    {
        $this->traitementDesResidusDeCultureId = $traitementDesResidusDeCultureId;
        return $this;
    }

    public function getTraitementDesResidusDeCultureTitle(): ?string
    {
        return $this->traitementDesResidusDeCultureTitle;
    }

    public function setTraitementDesResidusDeCultureTitle(?string $traitementDesResidusDeCultureTitle): self
    {
        $this->traitementDesResidusDeCultureTitle = $traitementDesResidusDeCultureTitle;
        return $this;
    }

    public function getTraitementDesResidusDeCultureReferenceCode(): ?string
    {
        return $this->traitementDesResidusDeCultureReferenceCode;
    }

    public function setTraitementDesResidusDeCultureReferenceCode(?string $traitementDesResidusDeCultureReferenceCode): self
    {
        $this->traitementDesResidusDeCultureReferenceCode = $traitementDesResidusDeCultureReferenceCode;
        return $this;
    }
}
