<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Matériel Agricole (Catégorie) - Ne plus utiliser suppression Mai 2026"
 *
 * Repository Code: List_AgriculturalEquipmentCategory_CodeType
 * Référentiel ID: 697
 * Nombre d'items: 21
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété materielAgricoleNePlusUtiliserSuppressionMai2026CategorieId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $materielAgricoleNePlusUtiliserSuppressionMai2026CategorieId = null;
 */
trait MaterielAgricoleNePlusUtiliserSuppressionMai2026CategorieTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $materielAgricoleNePlusUtiliserSuppressionMai2026CategorieId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $materielAgricoleNePlusUtiliserSuppressionMai2026CategorieTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $materielAgricoleNePlusUtiliserSuppressionMai2026CategorieReferenceCode = null;

    public function getMaterielAgricoleNePlusUtiliserSuppressionMai2026CategorieId(): ?int
    {
        return $this->materielAgricoleNePlusUtiliserSuppressionMai2026CategorieId;
    }

    public function setMaterielAgricoleNePlusUtiliserSuppressionMai2026CategorieId(?int $materielAgricoleNePlusUtiliserSuppressionMai2026CategorieId): self
    {
        $this->materielAgricoleNePlusUtiliserSuppressionMai2026CategorieId = $materielAgricoleNePlusUtiliserSuppressionMai2026CategorieId;
        return $this;
    }

    public function getMaterielAgricoleNePlusUtiliserSuppressionMai2026CategorieTitle(): ?string
    {
        return $this->materielAgricoleNePlusUtiliserSuppressionMai2026CategorieTitle;
    }

    public function setMaterielAgricoleNePlusUtiliserSuppressionMai2026CategorieTitle(?string $materielAgricoleNePlusUtiliserSuppressionMai2026CategorieTitle): self
    {
        $this->materielAgricoleNePlusUtiliserSuppressionMai2026CategorieTitle = $materielAgricoleNePlusUtiliserSuppressionMai2026CategorieTitle;
        return $this;
    }

    public function getMaterielAgricoleNePlusUtiliserSuppressionMai2026CategorieReferenceCode(): ?string
    {
        return $this->materielAgricoleNePlusUtiliserSuppressionMai2026CategorieReferenceCode;
    }

    public function setMaterielAgricoleNePlusUtiliserSuppressionMai2026CategorieReferenceCode(?string $materielAgricoleNePlusUtiliserSuppressionMai2026CategorieReferenceCode): self
    {
        $this->materielAgricoleNePlusUtiliserSuppressionMai2026CategorieReferenceCode = $materielAgricoleNePlusUtiliserSuppressionMai2026CategorieReferenceCode;
        return $this;
    }
}
