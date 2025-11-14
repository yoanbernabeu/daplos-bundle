<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Matériel Agricole (Type)".
 *
 * Repository Code: List_AgriculturalEquipment_CodeType
 * Référentiel ID: 693
 * Nombre d'items: 222
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait MaterielAgricoleTypeTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $materielAgricoleTypeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $materielAgricoleTypeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $materielAgricoleTypeReferenceCode = null;

    public function getMaterielAgricoleTypeId(): ?int
    {
        return $this->materielAgricoleTypeId;
    }

    public function setMaterielAgricoleTypeId(?int $materielAgricoleTypeId): self
    {
        $this->materielAgricoleTypeId = $materielAgricoleTypeId;

        return $this;
    }

    public function getMaterielAgricoleTypeTitle(): ?string
    {
        return $this->materielAgricoleTypeTitle;
    }

    public function setMaterielAgricoleTypeTitle(?string $materielAgricoleTypeTitle): self
    {
        $this->materielAgricoleTypeTitle = $materielAgricoleTypeTitle;

        return $this;
    }

    public function getMaterielAgricoleTypeReferenceCode(): ?string
    {
        return $this->materielAgricoleTypeReferenceCode;
    }

    public function setMaterielAgricoleTypeReferenceCode(?string $materielAgricoleTypeReferenceCode): self
    {
        $this->materielAgricoleTypeReferenceCode = $materielAgricoleTypeReferenceCode;

        return $this;
    }
}
