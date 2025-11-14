<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Valeurs qualitatives (Code)"
 *
 * Repository Code: List_QualitativeValue_CodeType
 * Référentiel ID: 673
 * Nombre d'items: 737
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait ValeursqualitativesCodeTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $valeursqualitativesCodeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $valeursqualitativesCodeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $valeursqualitativesCodeReferenceCode = null;

    public function getValeursqualitativesCodeId(): ?int
    {
        return $this->valeursqualitativesCodeId;
    }

    public function setValeursqualitativesCodeId(?int $valeursqualitativesCodeId): self
    {
        $this->valeursqualitativesCodeId = $valeursqualitativesCodeId;
        return $this;
    }

    public function getValeursqualitativesCodeTitle(): ?string
    {
        return $this->valeursqualitativesCodeTitle;
    }

    public function setValeursqualitativesCodeTitle(?string $valeursqualitativesCodeTitle): self
    {
        $this->valeursqualitativesCodeTitle = $valeursqualitativesCodeTitle;
        return $this;
    }

    public function getValeursqualitativesCodeReferenceCode(): ?string
    {
        return $this->valeursqualitativesCodeReferenceCode;
    }

    public function setValeursqualitativesCodeReferenceCode(?string $valeursqualitativesCodeReferenceCode): self
    {
        $this->valeursqualitativesCodeReferenceCode = $valeursqualitativesCodeReferenceCode;
        return $this;
    }
}
