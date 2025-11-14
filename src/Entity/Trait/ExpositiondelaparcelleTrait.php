<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Exposition de la parcelle".
 *
 * Repository Code: rep46
 * Référentiel ID: 647
 * Nombre d'items: 17
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait ExpositiondelaparcelleTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $expositiondelaparcelleId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $expositiondelaparcelleTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $expositiondelaparcelleReferenceCode = null;

    public function getExpositiondelaparcelleId(): ?int
    {
        return $this->expositiondelaparcelleId;
    }

    public function setExpositiondelaparcelleId(?int $expositiondelaparcelleId): self
    {
        $this->expositiondelaparcelleId = $expositiondelaparcelleId;

        return $this;
    }

    public function getExpositiondelaparcelleTitle(): ?string
    {
        return $this->expositiondelaparcelleTitle;
    }

    public function setExpositiondelaparcelleTitle(?string $expositiondelaparcelleTitle): self
    {
        $this->expositiondelaparcelleTitle = $expositiondelaparcelleTitle;

        return $this;
    }

    public function getExpositiondelaparcelleReferenceCode(): ?string
    {
        return $this->expositiondelaparcelleReferenceCode;
    }

    public function setExpositiondelaparcelleReferenceCode(?string $expositiondelaparcelleReferenceCode): self
    {
        $this->expositiondelaparcelleReferenceCode = $expositiondelaparcelleReferenceCode;

        return $this;
    }
}
