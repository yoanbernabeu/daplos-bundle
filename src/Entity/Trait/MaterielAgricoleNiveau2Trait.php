<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Matériel Agricole (Niveau 2)".
 *
 * Repository Code: List_AgriculturalEquipmentBCMA_CodeType
 * Référentiel ID: 699
 * Nombre d'items: 807
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait MaterielAgricoleNiveau2Trait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $materielAgricoleNiveau2Id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $materielAgricoleNiveau2Title = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $materielAgricoleNiveau2ReferenceCode = null;

    public function getMaterielAgricoleNiveau2Id(): ?int
    {
        return $this->materielAgricoleNiveau2Id;
    }

    public function setMaterielAgricoleNiveau2Id(?int $materielAgricoleNiveau2Id): self
    {
        $this->materielAgricoleNiveau2Id = $materielAgricoleNiveau2Id;

        return $this;
    }

    public function getMaterielAgricoleNiveau2Title(): ?string
    {
        return $this->materielAgricoleNiveau2Title;
    }

    public function setMaterielAgricoleNiveau2Title(?string $materielAgricoleNiveau2Title): self
    {
        $this->materielAgricoleNiveau2Title = $materielAgricoleNiveau2Title;

        return $this;
    }

    public function getMaterielAgricoleNiveau2ReferenceCode(): ?string
    {
        return $this->materielAgricoleNiveau2ReferenceCode;
    }

    public function setMaterielAgricoleNiveau2ReferenceCode(?string $materielAgricoleNiveau2ReferenceCode): self
    {
        $this->materielAgricoleNiveau2ReferenceCode = $materielAgricoleNiveau2ReferenceCode;

        return $this;
    }
}
