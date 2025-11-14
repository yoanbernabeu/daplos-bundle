<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Gestion des résidus de cultures".
 *
 * Repository Code: List_SoilOccupationCropResidue_CodeType
 * Référentiel ID: 629
 * Nombre d'items: 4
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait GestiondesresidusdeculturesTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $gestiondesresidusdeculturesId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $gestiondesresidusdeculturesTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $gestiondesresidusdeculturesReferenceCode = null;

    public function getGestiondesresidusdeculturesId(): ?int
    {
        return $this->gestiondesresidusdeculturesId;
    }

    public function setGestiondesresidusdeculturesId(?int $gestiondesresidusdeculturesId): self
    {
        $this->gestiondesresidusdeculturesId = $gestiondesresidusdeculturesId;

        return $this;
    }

    public function getGestiondesresidusdeculturesTitle(): ?string
    {
        return $this->gestiondesresidusdeculturesTitle;
    }

    public function setGestiondesresidusdeculturesTitle(?string $gestiondesresidusdeculturesTitle): self
    {
        $this->gestiondesresidusdeculturesTitle = $gestiondesresidusdeculturesTitle;

        return $this;
    }

    public function getGestiondesresidusdeculturesReferenceCode(): ?string
    {
        return $this->gestiondesresidusdeculturesReferenceCode;
    }

    public function setGestiondesresidusdeculturesReferenceCode(?string $gestiondesresidusdeculturesReferenceCode): self
    {
        $this->gestiondesresidusdeculturesReferenceCode = $gestiondesresidusdeculturesReferenceCode;

        return $this;
    }
}
