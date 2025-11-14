<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Intrant (qualifiant)"
 *
 * Repository Code: List_AgriculturalProcessCropInputSubordinateTypeCode_CodeType
 * Référentiel ID: 595
 * Nombre d'items: 122
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait IntrantQualifiantTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $intrantQualifiantId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $intrantQualifiantTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $intrantQualifiantReferenceCode = null;

    public function getIntrantQualifiantId(): ?int
    {
        return $this->intrantQualifiantId;
    }

    public function setIntrantQualifiantId(?int $intrantQualifiantId): self
    {
        $this->intrantQualifiantId = $intrantQualifiantId;
        return $this;
    }

    public function getIntrantQualifiantTitle(): ?string
    {
        return $this->intrantQualifiantTitle;
    }

    public function setIntrantQualifiantTitle(?string $intrantQualifiantTitle): self
    {
        $this->intrantQualifiantTitle = $intrantQualifiantTitle;
        return $this;
    }

    public function getIntrantQualifiantReferenceCode(): ?string
    {
        return $this->intrantQualifiantReferenceCode;
    }

    public function setIntrantQualifiantReferenceCode(?string $intrantQualifiantReferenceCode): self
    {
        $this->intrantQualifiantReferenceCode = $intrantQualifiantReferenceCode;
        return $this;
    }
}
