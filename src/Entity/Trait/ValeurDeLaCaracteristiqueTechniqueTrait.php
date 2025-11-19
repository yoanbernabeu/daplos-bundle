<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Valeur de la caractéristique technique".
 *
 * Repository Code: List_TechnicalCharacteristicSubordinateType_CodeType
 * Référentiel ID: 589
 * Nombre d'items: 99
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété valeurDeLaCaracteristiqueTechniqueId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $valeurDeLaCaracteristiqueTechniqueId = null;
 */
trait ValeurDeLaCaracteristiqueTechniqueTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $valeurDeLaCaracteristiqueTechniqueId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $valeurDeLaCaracteristiqueTechniqueTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $valeurDeLaCaracteristiqueTechniqueReferenceCode = null;

    public function getValeurDeLaCaracteristiqueTechniqueId(): ?int
    {
        return $this->valeurDeLaCaracteristiqueTechniqueId;
    }

    public function setValeurDeLaCaracteristiqueTechniqueId(?int $valeurDeLaCaracteristiqueTechniqueId): self
    {
        $this->valeurDeLaCaracteristiqueTechniqueId = $valeurDeLaCaracteristiqueTechniqueId;

        return $this;
    }

    public function getValeurDeLaCaracteristiqueTechniqueTitle(): ?string
    {
        return $this->valeurDeLaCaracteristiqueTechniqueTitle;
    }

    public function setValeurDeLaCaracteristiqueTechniqueTitle(?string $valeurDeLaCaracteristiqueTechniqueTitle): self
    {
        $this->valeurDeLaCaracteristiqueTechniqueTitle = $valeurDeLaCaracteristiqueTechniqueTitle;

        return $this;
    }

    public function getValeurDeLaCaracteristiqueTechniqueReferenceCode(): ?string
    {
        return $this->valeurDeLaCaracteristiqueTechniqueReferenceCode;
    }

    public function setValeurDeLaCaracteristiqueTechniqueReferenceCode(?string $valeurDeLaCaracteristiqueTechniqueReferenceCode): self
    {
        $this->valeurDeLaCaracteristiqueTechniqueReferenceCode = $valeurDeLaCaracteristiqueTechniqueReferenceCode;

        return $this;
    }
}
