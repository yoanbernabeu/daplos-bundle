<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Matériel Agricole (Catégorie)"
 *
 * Repository Code: List_AgriculturalEquipmentCategory_CodeType
 * Référentiel ID: 697
 * Nombre d'items: 21
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait MaterielAgricoleCategorieTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $materielAgricoleCategorieId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $materielAgricoleCategorieTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $materielAgricoleCategorieReferenceCode = null;

    public function getMaterielAgricoleCategorieId(): ?int
    {
        return $this->materielAgricoleCategorieId;
    }

    public function setMaterielAgricoleCategorieId(?int $materielAgricoleCategorieId): self
    {
        $this->materielAgricoleCategorieId = $materielAgricoleCategorieId;
        return $this;
    }

    public function getMaterielAgricoleCategorieTitle(): ?string
    {
        return $this->materielAgricoleCategorieTitle;
    }

    public function setMaterielAgricoleCategorieTitle(?string $materielAgricoleCategorieTitle): self
    {
        $this->materielAgricoleCategorieTitle = $materielAgricoleCategorieTitle;
        return $this;
    }

    public function getMaterielAgricoleCategorieReferenceCode(): ?string
    {
        return $this->materielAgricoleCategorieReferenceCode;
    }

    public function setMaterielAgricoleCategorieReferenceCode(?string $materielAgricoleCategorieReferenceCode): self
    {
        $this->materielAgricoleCategorieReferenceCode = $materielAgricoleCategorieReferenceCode;
        return $this;
    }
}
