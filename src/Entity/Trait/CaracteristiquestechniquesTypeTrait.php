<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Caractéristiques techniques (Type)".
 *
 * Repository Code: List_TechnicalCharacteristic_CodeType
 * Référentiel ID: 635
 * Nombre d'items: 36
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait CaracteristiquestechniquesTypeTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $caracteristiquestechniquesTypeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $caracteristiquestechniquesTypeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $caracteristiquestechniquesTypeReferenceCode = null;

    public function getCaracteristiquestechniquesTypeId(): ?int
    {
        return $this->caracteristiquestechniquesTypeId;
    }

    public function setCaracteristiquestechniquesTypeId(?int $caracteristiquestechniquesTypeId): self
    {
        $this->caracteristiquestechniquesTypeId = $caracteristiquestechniquesTypeId;

        return $this;
    }

    public function getCaracteristiquestechniquesTypeTitle(): ?string
    {
        return $this->caracteristiquestechniquesTypeTitle;
    }

    public function setCaracteristiquestechniquesTypeTitle(?string $caracteristiquestechniquesTypeTitle): self
    {
        $this->caracteristiquestechniquesTypeTitle = $caracteristiquestechniquesTypeTitle;

        return $this;
    }

    public function getCaracteristiquestechniquesTypeReferenceCode(): ?string
    {
        return $this->caracteristiquestechniquesTypeReferenceCode;
    }

    public function setCaracteristiquestechniquesTypeReferenceCode(?string $caracteristiquestechniquesTypeReferenceCode): self
    {
        $this->caracteristiquestechniquesTypeReferenceCode = $caracteristiquestechniquesTypeReferenceCode;

        return $this;
    }
}
