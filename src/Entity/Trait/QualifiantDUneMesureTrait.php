<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Qualifiant d'une mesure".
 *
 * Repository Code: List_ValueExpression_CodeType
 * Référentiel ID: 671
 * Nombre d'items: 293
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété qualifiantDUneMesureId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $qualifiantDUneMesureId = null;
 */
trait QualifiantDUneMesureTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $qualifiantDUneMesureId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $qualifiantDUneMesureTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $qualifiantDUneMesureReferenceCode = null;

    public function getQualifiantDUneMesureId(): ?int
    {
        return $this->qualifiantDUneMesureId;
    }

    public function setQualifiantDUneMesureId(?int $qualifiantDUneMesureId): self
    {
        $this->qualifiantDUneMesureId = $qualifiantDUneMesureId;

        return $this;
    }

    public function getQualifiantDUneMesureTitle(): ?string
    {
        return $this->qualifiantDUneMesureTitle;
    }

    public function setQualifiantDUneMesureTitle(?string $qualifiantDUneMesureTitle): self
    {
        $this->qualifiantDUneMesureTitle = $qualifiantDUneMesureTitle;

        return $this;
    }

    public function getQualifiantDUneMesureReferenceCode(): ?string
    {
        return $this->qualifiantDUneMesureReferenceCode;
    }

    public function setQualifiantDUneMesureReferenceCode(?string $qualifiantDUneMesureReferenceCode): self
    {
        $this->qualifiantDUneMesureReferenceCode = $qualifiantDUneMesureReferenceCode;

        return $this;
    }
}
