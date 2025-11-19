<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Matériel Agricole - Ne plus utiliser - Suppression en mai 2026"
 *
 * Repository Code: List_AgriculturalEquipmentBCMA_CodeType
 * Référentiel ID: 699
 * Nombre d'items: 807
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété materielAgricoleNePlusUtiliserSuppressionEnMai2026Id :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $materielAgricoleNePlusUtiliserSuppressionEnMai2026Id = null;
 */
trait MaterielAgricoleNePlusUtiliserSuppressionEnMai2026Trait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $materielAgricoleNePlusUtiliserSuppressionEnMai2026Id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $materielAgricoleNePlusUtiliserSuppressionEnMai2026Title = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $materielAgricoleNePlusUtiliserSuppressionEnMai2026ReferenceCode = null;

    public function getMaterielAgricoleNePlusUtiliserSuppressionEnMai2026Id(): ?int
    {
        return $this->materielAgricoleNePlusUtiliserSuppressionEnMai2026Id;
    }

    public function setMaterielAgricoleNePlusUtiliserSuppressionEnMai2026Id(?int $materielAgricoleNePlusUtiliserSuppressionEnMai2026Id): self
    {
        $this->materielAgricoleNePlusUtiliserSuppressionEnMai2026Id = $materielAgricoleNePlusUtiliserSuppressionEnMai2026Id;
        return $this;
    }

    public function getMaterielAgricoleNePlusUtiliserSuppressionEnMai2026Title(): ?string
    {
        return $this->materielAgricoleNePlusUtiliserSuppressionEnMai2026Title;
    }

    public function setMaterielAgricoleNePlusUtiliserSuppressionEnMai2026Title(?string $materielAgricoleNePlusUtiliserSuppressionEnMai2026Title): self
    {
        $this->materielAgricoleNePlusUtiliserSuppressionEnMai2026Title = $materielAgricoleNePlusUtiliserSuppressionEnMai2026Title;
        return $this;
    }

    public function getMaterielAgricoleNePlusUtiliserSuppressionEnMai2026ReferenceCode(): ?string
    {
        return $this->materielAgricoleNePlusUtiliserSuppressionEnMai2026ReferenceCode;
    }

    public function setMaterielAgricoleNePlusUtiliserSuppressionEnMai2026ReferenceCode(?string $materielAgricoleNePlusUtiliserSuppressionEnMai2026ReferenceCode): self
    {
        $this->materielAgricoleNePlusUtiliserSuppressionEnMai2026ReferenceCode = $materielAgricoleNePlusUtiliserSuppressionEnMai2026ReferenceCode;
        return $this;
    }
}
