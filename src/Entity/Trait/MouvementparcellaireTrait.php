<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Mouvement parcellaire".
 *
 * Repository Code: List_Movement_CodeType
 * Référentiel ID: 691
 * Nombre d'items: 2
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait MouvementparcellaireTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $mouvementparcellaireId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $mouvementparcellaireTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $mouvementparcellaireReferenceCode = null;

    public function getMouvementparcellaireId(): ?int
    {
        return $this->mouvementparcellaireId;
    }

    public function setMouvementparcellaireId(?int $mouvementparcellaireId): self
    {
        $this->mouvementparcellaireId = $mouvementparcellaireId;

        return $this;
    }

    public function getMouvementparcellaireTitle(): ?string
    {
        return $this->mouvementparcellaireTitle;
    }

    public function setMouvementparcellaireTitle(?string $mouvementparcellaireTitle): self
    {
        $this->mouvementparcellaireTitle = $mouvementparcellaireTitle;

        return $this;
    }

    public function getMouvementparcellaireReferenceCode(): ?string
    {
        return $this->mouvementparcellaireReferenceCode;
    }

    public function setMouvementparcellaireReferenceCode(?string $mouvementparcellaireReferenceCode): self
    {
        $this->mouvementparcellaireReferenceCode = $mouvementparcellaireReferenceCode;

        return $this;
    }
}
