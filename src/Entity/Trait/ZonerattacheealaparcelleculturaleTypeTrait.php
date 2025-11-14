<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Zone rattachée à la parcelle culturale (Type)"
 *
 * Repository Code: List_AgriculturalCountrySubdivision_CodeType
 * Référentiel ID: 687
 * Nombre d'items: 2
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait ZonerattacheealaparcelleculturaleTypeTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $zonerattacheealaparcelleculturaleTypeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $zonerattacheealaparcelleculturaleTypeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $zonerattacheealaparcelleculturaleTypeReferenceCode = null;

    public function getZonerattacheealaparcelleculturaleTypeId(): ?int
    {
        return $this->zonerattacheealaparcelleculturaleTypeId;
    }

    public function setZonerattacheealaparcelleculturaleTypeId(?int $zonerattacheealaparcelleculturaleTypeId): self
    {
        $this->zonerattacheealaparcelleculturaleTypeId = $zonerattacheealaparcelleculturaleTypeId;
        return $this;
    }

    public function getZonerattacheealaparcelleculturaleTypeTitle(): ?string
    {
        return $this->zonerattacheealaparcelleculturaleTypeTitle;
    }

    public function setZonerattacheealaparcelleculturaleTypeTitle(?string $zonerattacheealaparcelleculturaleTypeTitle): self
    {
        $this->zonerattacheealaparcelleculturaleTypeTitle = $zonerattacheealaparcelleculturaleTypeTitle;
        return $this;
    }

    public function getZonerattacheealaparcelleculturaleTypeReferenceCode(): ?string
    {
        return $this->zonerattacheealaparcelleculturaleTypeReferenceCode;
    }

    public function setZonerattacheealaparcelleculturaleTypeReferenceCode(?string $zonerattacheealaparcelleculturaleTypeReferenceCode): self
    {
        $this->zonerattacheealaparcelleculturaleTypeReferenceCode = $zonerattacheealaparcelleculturaleTypeReferenceCode;
        return $this;
    }
}
