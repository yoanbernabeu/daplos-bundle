<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Cultures (Catégorie)".
 *
 * Repository Code: List_CropCategory_CodeType
 * Référentiel ID: 701
 * Nombre d'items: 13
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait CulturesCategorieTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $culturesCategorieId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $culturesCategorieTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $culturesCategorieReferenceCode = null;

    public function getCulturesCategorieId(): ?int
    {
        return $this->culturesCategorieId;
    }

    public function setCulturesCategorieId(?int $culturesCategorieId): self
    {
        $this->culturesCategorieId = $culturesCategorieId;

        return $this;
    }

    public function getCulturesCategorieTitle(): ?string
    {
        return $this->culturesCategorieTitle;
    }

    public function setCulturesCategorieTitle(?string $culturesCategorieTitle): self
    {
        $this->culturesCategorieTitle = $culturesCategorieTitle;

        return $this;
    }

    public function getCulturesCategorieReferenceCode(): ?string
    {
        return $this->culturesCategorieReferenceCode;
    }

    public function setCulturesCategorieReferenceCode(?string $culturesCategorieReferenceCode): self
    {
        $this->culturesCategorieReferenceCode = $culturesCategorieReferenceCode;

        return $this;
    }
}
