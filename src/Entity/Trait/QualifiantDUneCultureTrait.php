<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Qualifiant d'une culture".
 *
 * Repository Code: List_SupplementaryBotanicalSpecies_CodeType
 * Référentiel ID: 639
 * Nombre d'items: 112
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété qualifiantDUneCultureId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $qualifiantDUneCultureId = null;
 */
trait QualifiantDUneCultureTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $qualifiantDUneCultureId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $qualifiantDUneCultureTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $qualifiantDUneCultureReferenceCode = null;

    public function getQualifiantDUneCultureId(): ?int
    {
        return $this->qualifiantDUneCultureId;
    }

    public function setQualifiantDUneCultureId(?int $qualifiantDUneCultureId): self
    {
        $this->qualifiantDUneCultureId = $qualifiantDUneCultureId;

        return $this;
    }

    public function getQualifiantDUneCultureTitle(): ?string
    {
        return $this->qualifiantDUneCultureTitle;
    }

    public function setQualifiantDUneCultureTitle(?string $qualifiantDUneCultureTitle): self
    {
        $this->qualifiantDUneCultureTitle = $qualifiantDUneCultureTitle;

        return $this;
    }

    public function getQualifiantDUneCultureReferenceCode(): ?string
    {
        return $this->qualifiantDUneCultureReferenceCode;
    }

    public function setQualifiantDUneCultureReferenceCode(?string $qualifiantDUneCultureReferenceCode): self
    {
        $this->qualifiantDUneCultureReferenceCode = $qualifiantDUneCultureReferenceCode;

        return $this;
    }
}
