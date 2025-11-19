<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Stade végétatif"
 *
 * Repository Code: List_CropStage_CodeType
 * Référentiel ID: 597
 * Nombre d'items: 3769
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété stadeVegetatifId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $stadeVegetatifId = null;
 */
trait StadeVegetatifTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $stadeVegetatifId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $stadeVegetatifTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $stadeVegetatifReferenceCode = null;

    public function getStadeVegetatifId(): ?int
    {
        return $this->stadeVegetatifId;
    }

    public function setStadeVegetatifId(?int $stadeVegetatifId): self
    {
        $this->stadeVegetatifId = $stadeVegetatifId;
        return $this;
    }

    public function getStadeVegetatifTitle(): ?string
    {
        return $this->stadeVegetatifTitle;
    }

    public function setStadeVegetatifTitle(?string $stadeVegetatifTitle): self
    {
        $this->stadeVegetatifTitle = $stadeVegetatifTitle;
        return $this;
    }

    public function getStadeVegetatifReferenceCode(): ?string
    {
        return $this->stadeVegetatifReferenceCode;
    }

    public function setStadeVegetatifReferenceCode(?string $stadeVegetatifReferenceCode): self
    {
        $this->stadeVegetatifReferenceCode = $stadeVegetatifReferenceCode;
        return $this;
    }
}
