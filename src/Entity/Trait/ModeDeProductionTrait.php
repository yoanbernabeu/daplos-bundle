<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Mode de production".
 *
 * Repository Code: List_ProductionType_CodeType
 * Référentiel ID: 703
 * Nombre d'items: 5
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété modeDeProductionId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $modeDeProductionId = null;
 */
trait ModeDeProductionTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $modeDeProductionId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $modeDeProductionTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $modeDeProductionReferenceCode = null;

    public function getModeDeProductionId(): ?int
    {
        return $this->modeDeProductionId;
    }

    public function setModeDeProductionId(?int $modeDeProductionId): self
    {
        $this->modeDeProductionId = $modeDeProductionId;

        return $this;
    }

    public function getModeDeProductionTitle(): ?string
    {
        return $this->modeDeProductionTitle;
    }

    public function setModeDeProductionTitle(?string $modeDeProductionTitle): self
    {
        $this->modeDeProductionTitle = $modeDeProductionTitle;

        return $this;
    }

    public function getModeDeProductionReferenceCode(): ?string
    {
        return $this->modeDeProductionReferenceCode;
    }

    public function setModeDeProductionReferenceCode(?string $modeDeProductionReferenceCode): self
    {
        $this->modeDeProductionReferenceCode = $modeDeProductionReferenceCode;

        return $this;
    }
}
