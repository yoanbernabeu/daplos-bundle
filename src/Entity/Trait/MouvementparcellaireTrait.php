<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Mouvement parcellaire"
 *
 * Repository Code: List_Movement_CodeType
 * Référentiel ID: 691
 * Nombre d'items: 2
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété mouvementParcellaireId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $mouvementParcellaireId = null;
 */
trait MouvementParcellaireTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $mouvementParcellaireId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $mouvementParcellaireTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $mouvementParcellaireReferenceCode = null;

    public function getMouvementParcellaireId(): ?int
    {
        return $this->mouvementParcellaireId;
    }

    public function setMouvementParcellaireId(?int $mouvementParcellaireId): self
    {
        $this->mouvementParcellaireId = $mouvementParcellaireId;
        return $this;
    }

    public function getMouvementParcellaireTitle(): ?string
    {
        return $this->mouvementParcellaireTitle;
    }

    public function setMouvementParcellaireTitle(?string $mouvementParcellaireTitle): self
    {
        $this->mouvementParcellaireTitle = $mouvementParcellaireTitle;
        return $this;
    }

    public function getMouvementParcellaireReferenceCode(): ?string
    {
        return $this->mouvementParcellaireReferenceCode;
    }

    public function setMouvementParcellaireReferenceCode(?string $mouvementParcellaireReferenceCode): self
    {
        $this->mouvementParcellaireReferenceCode = $mouvementParcellaireReferenceCode;
        return $this;
    }
}
