<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Caractéristique technique (qualifiants)".
 *
 * Repository Code: List_TechnicalCharacteristicSubordinateType_CodeType
 * Référentiel ID: 589
 * Nombre d'items: 99
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait CaracteristiquetechniqueQualifiantsTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $caracteristiquetechniqueQualifiantsId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $caracteristiquetechniqueQualifiantsTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $caracteristiquetechniqueQualifiantsReferenceCode = null;

    public function getCaracteristiquetechniqueQualifiantsId(): ?int
    {
        return $this->caracteristiquetechniqueQualifiantsId;
    }

    public function setCaracteristiquetechniqueQualifiantsId(?int $caracteristiquetechniqueQualifiantsId): self
    {
        $this->caracteristiquetechniqueQualifiantsId = $caracteristiquetechniqueQualifiantsId;

        return $this;
    }

    public function getCaracteristiquetechniqueQualifiantsTitle(): ?string
    {
        return $this->caracteristiquetechniqueQualifiantsTitle;
    }

    public function setCaracteristiquetechniqueQualifiantsTitle(?string $caracteristiquetechniqueQualifiantsTitle): self
    {
        $this->caracteristiquetechniqueQualifiantsTitle = $caracteristiquetechniqueQualifiantsTitle;

        return $this;
    }

    public function getCaracteristiquetechniqueQualifiantsReferenceCode(): ?string
    {
        return $this->caracteristiquetechniqueQualifiantsReferenceCode;
    }

    public function setCaracteristiquetechniqueQualifiantsReferenceCode(?string $caracteristiquetechniqueQualifiantsReferenceCode): self
    {
        $this->caracteristiquetechniqueQualifiantsReferenceCode = $caracteristiquetechniqueQualifiantsReferenceCode;

        return $this;
    }
}
