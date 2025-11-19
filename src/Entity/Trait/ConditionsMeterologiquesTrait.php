<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Conditions métérologiques"
 *
 * Repository Code: List_AgriculturalProcessCondition_CodeType
 * Référentiel ID: 591
 * Nombre d'items: 12
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété conditionsMeterologiquesId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $conditionsMeterologiquesId = null;
 */
trait ConditionsMeterologiquesTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $conditionsMeterologiquesId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $conditionsMeterologiquesTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $conditionsMeterologiquesReferenceCode = null;

    public function getConditionsMeterologiquesId(): ?int
    {
        return $this->conditionsMeterologiquesId;
    }

    public function setConditionsMeterologiquesId(?int $conditionsMeterologiquesId): self
    {
        $this->conditionsMeterologiquesId = $conditionsMeterologiquesId;
        return $this;
    }

    public function getConditionsMeterologiquesTitle(): ?string
    {
        return $this->conditionsMeterologiquesTitle;
    }

    public function setConditionsMeterologiquesTitle(?string $conditionsMeterologiquesTitle): self
    {
        $this->conditionsMeterologiquesTitle = $conditionsMeterologiquesTitle;
        return $this;
    }

    public function getConditionsMeterologiquesReferenceCode(): ?string
    {
        return $this->conditionsMeterologiquesReferenceCode;
    }

    public function setConditionsMeterologiquesReferenceCode(?string $conditionsMeterologiquesReferenceCode): self
    {
        $this->conditionsMeterologiquesReferenceCode = $conditionsMeterologiquesReferenceCode;
        return $this;
    }
}
