<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Type de surfaces".
 *
 * Repository Code: List_AgriculturalArea_CodeType
 * Référentiel ID: 641
 * Nombre d'items: 17
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait TypedesurfacesTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $typedesurfacesId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typedesurfacesTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $typedesurfacesReferenceCode = null;

    public function getTypedesurfacesId(): ?int
    {
        return $this->typedesurfacesId;
    }

    public function setTypedesurfacesId(?int $typedesurfacesId): self
    {
        $this->typedesurfacesId = $typedesurfacesId;

        return $this;
    }

    public function getTypedesurfacesTitle(): ?string
    {
        return $this->typedesurfacesTitle;
    }

    public function setTypedesurfacesTitle(?string $typedesurfacesTitle): self
    {
        $this->typedesurfacesTitle = $typedesurfacesTitle;

        return $this;
    }

    public function getTypedesurfacesReferenceCode(): ?string
    {
        return $this->typedesurfacesReferenceCode;
    }

    public function setTypedesurfacesReferenceCode(?string $typedesurfacesReferenceCode): self
    {
        $this->typedesurfacesReferenceCode = $typedesurfacesReferenceCode;

        return $this;
    }
}
