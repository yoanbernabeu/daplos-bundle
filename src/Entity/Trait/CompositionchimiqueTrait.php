<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Composition chimique".
 *
 * Repository Code: List_CropInputChemical_CodeType
 * Référentiel ID: 613
 * Nombre d'items: 17
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait CompositionchimiqueTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $compositionchimiqueId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $compositionchimiqueTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $compositionchimiqueReferenceCode = null;

    public function getCompositionchimiqueId(): ?int
    {
        return $this->compositionchimiqueId;
    }

    public function setCompositionchimiqueId(?int $compositionchimiqueId): self
    {
        $this->compositionchimiqueId = $compositionchimiqueId;

        return $this;
    }

    public function getCompositionchimiqueTitle(): ?string
    {
        return $this->compositionchimiqueTitle;
    }

    public function setCompositionchimiqueTitle(?string $compositionchimiqueTitle): self
    {
        $this->compositionchimiqueTitle = $compositionchimiqueTitle;

        return $this;
    }

    public function getCompositionchimiqueReferenceCode(): ?string
    {
        return $this->compositionchimiqueReferenceCode;
    }

    public function setCompositionchimiqueReferenceCode(?string $compositionchimiqueReferenceCode): self
    {
        $this->compositionchimiqueReferenceCode = $compositionchimiqueReferenceCode;

        return $this;
    }
}
