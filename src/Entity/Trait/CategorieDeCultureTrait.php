<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Catégorie de culture"
 *
 * Repository Code: List_CropCategory_CodeType
 * Référentiel ID: 701
 * Nombre d'items: 13
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété categorieDeCultureId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $categorieDeCultureId = null;
 */
trait CategorieDeCultureTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $categorieDeCultureId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $categorieDeCultureTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $categorieDeCultureReferenceCode = null;

    public function getCategorieDeCultureId(): ?int
    {
        return $this->categorieDeCultureId;
    }

    public function setCategorieDeCultureId(?int $categorieDeCultureId): self
    {
        $this->categorieDeCultureId = $categorieDeCultureId;
        return $this;
    }

    public function getCategorieDeCultureTitle(): ?string
    {
        return $this->categorieDeCultureTitle;
    }

    public function setCategorieDeCultureTitle(?string $categorieDeCultureTitle): self
    {
        $this->categorieDeCultureTitle = $categorieDeCultureTitle;
        return $this;
    }

    public function getCategorieDeCultureReferenceCode(): ?string
    {
        return $this->categorieDeCultureReferenceCode;
    }

    public function setCategorieDeCultureReferenceCode(?string $categorieDeCultureReferenceCode): self
    {
        $this->categorieDeCultureReferenceCode = $categorieDeCultureReferenceCode;
        return $this;
    }
}
