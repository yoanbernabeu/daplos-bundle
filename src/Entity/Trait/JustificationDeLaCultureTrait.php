<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Justification de la culture".
 *
 * Repository Code: List_PlantingReasonCode_CodeType
 * Référentiel ID: 623
 * Nombre d'items: 19
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété justificationDeLaCultureId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $justificationDeLaCultureId = null;
 */
trait JustificationDeLaCultureTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $justificationDeLaCultureId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $justificationDeLaCultureTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $justificationDeLaCultureReferenceCode = null;

    public function getJustificationDeLaCultureId(): ?int
    {
        return $this->justificationDeLaCultureId;
    }

    public function setJustificationDeLaCultureId(?int $justificationDeLaCultureId): self
    {
        $this->justificationDeLaCultureId = $justificationDeLaCultureId;

        return $this;
    }

    public function getJustificationDeLaCultureTitle(): ?string
    {
        return $this->justificationDeLaCultureTitle;
    }

    public function setJustificationDeLaCultureTitle(?string $justificationDeLaCultureTitle): self
    {
        $this->justificationDeLaCultureTitle = $justificationDeLaCultureTitle;

        return $this;
    }

    public function getJustificationDeLaCultureReferenceCode(): ?string
    {
        return $this->justificationDeLaCultureReferenceCode;
    }

    public function setJustificationDeLaCultureReferenceCode(?string $justificationDeLaCultureReferenceCode): self
    {
        $this->justificationDeLaCultureReferenceCode = $justificationDeLaCultureReferenceCode;

        return $this;
    }
}
