<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Type de travail".
 *
 * Repository Code: List_AgriculturalProcessWorkItem_CodeType
 * Référentiel ID: 603
 * Nombre d'items: 134
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait TypedetravailTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $typedetravailId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typedetravailTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $typedetravailReferenceCode = null;

    public function getTypedetravailId(): ?int
    {
        return $this->typedetravailId;
    }

    public function setTypedetravailId(?int $typedetravailId): self
    {
        $this->typedetravailId = $typedetravailId;

        return $this;
    }

    public function getTypedetravailTitle(): ?string
    {
        return $this->typedetravailTitle;
    }

    public function setTypedetravailTitle(?string $typedetravailTitle): self
    {
        $this->typedetravailTitle = $typedetravailTitle;

        return $this;
    }

    public function getTypedetravailReferenceCode(): ?string
    {
        return $this->typedetravailReferenceCode;
    }

    public function setTypedetravailReferenceCode(?string $typedetravailReferenceCode): self
    {
        $this->typedetravailReferenceCode = $typedetravailReferenceCode;

        return $this;
    }
}
