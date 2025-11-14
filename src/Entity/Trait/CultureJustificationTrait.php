<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Culture (Justification)".
 *
 * Repository Code: List_PlantingReasonCode_CodeType
 * Référentiel ID: 623
 * Nombre d'items: 19
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait CultureJustificationTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $cultureJustificationId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cultureJustificationTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $cultureJustificationReferenceCode = null;

    public function getCultureJustificationId(): ?int
    {
        return $this->cultureJustificationId;
    }

    public function setCultureJustificationId(?int $cultureJustificationId): self
    {
        $this->cultureJustificationId = $cultureJustificationId;

        return $this;
    }

    public function getCultureJustificationTitle(): ?string
    {
        return $this->cultureJustificationTitle;
    }

    public function setCultureJustificationTitle(?string $cultureJustificationTitle): self
    {
        $this->cultureJustificationTitle = $cultureJustificationTitle;

        return $this;
    }

    public function getCultureJustificationReferenceCode(): ?string
    {
        return $this->cultureJustificationReferenceCode;
    }

    public function setCultureJustificationReferenceCode(?string $cultureJustificationReferenceCode): self
    {
        $this->cultureJustificationReferenceCode = $cultureJustificationReferenceCode;

        return $this;
    }
}
