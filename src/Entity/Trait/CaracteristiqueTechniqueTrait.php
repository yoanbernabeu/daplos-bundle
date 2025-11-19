<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Caractéristique technique".
 *
 * Repository Code: List_TechnicalCharacteristic_CodeType
 * Référentiel ID: 635
 * Nombre d'items: 36
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété caracteristiqueTechniqueId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $caracteristiqueTechniqueId = null;
 */
trait CaracteristiqueTechniqueTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $caracteristiqueTechniqueId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $caracteristiqueTechniqueTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $caracteristiqueTechniqueReferenceCode = null;

    public function getCaracteristiqueTechniqueId(): ?int
    {
        return $this->caracteristiqueTechniqueId;
    }

    public function setCaracteristiqueTechniqueId(?int $caracteristiqueTechniqueId): self
    {
        $this->caracteristiqueTechniqueId = $caracteristiqueTechniqueId;

        return $this;
    }

    public function getCaracteristiqueTechniqueTitle(): ?string
    {
        return $this->caracteristiqueTechniqueTitle;
    }

    public function setCaracteristiqueTechniqueTitle(?string $caracteristiqueTechniqueTitle): self
    {
        $this->caracteristiqueTechniqueTitle = $caracteristiqueTechniqueTitle;

        return $this;
    }

    public function getCaracteristiqueTechniqueReferenceCode(): ?string
    {
        return $this->caracteristiqueTechniqueReferenceCode;
    }

    public function setCaracteristiqueTechniqueReferenceCode(?string $caracteristiqueTechniqueReferenceCode): self
    {
        $this->caracteristiqueTechniqueReferenceCode = $caracteristiqueTechniqueReferenceCode;

        return $this;
    }
}
