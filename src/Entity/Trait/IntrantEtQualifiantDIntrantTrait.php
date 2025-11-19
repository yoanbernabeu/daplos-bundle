<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Intrant et qualifiant d'intrant"
 *
 * Repository Code: List_AgriculturalProcessCropInputSubordinateTypeCode_CodeType
 * Référentiel ID: 595
 * Nombre d'items: 122
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété intrantEtQualifiantDIntrantId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $intrantEtQualifiantDIntrantId = null;
 */
trait IntrantEtQualifiantDIntrantTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $intrantEtQualifiantDIntrantId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $intrantEtQualifiantDIntrantTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $intrantEtQualifiantDIntrantReferenceCode = null;

    public function getIntrantEtQualifiantDIntrantId(): ?int
    {
        return $this->intrantEtQualifiantDIntrantId;
    }

    public function setIntrantEtQualifiantDIntrantId(?int $intrantEtQualifiantDIntrantId): self
    {
        $this->intrantEtQualifiantDIntrantId = $intrantEtQualifiantDIntrantId;
        return $this;
    }

    public function getIntrantEtQualifiantDIntrantTitle(): ?string
    {
        return $this->intrantEtQualifiantDIntrantTitle;
    }

    public function setIntrantEtQualifiantDIntrantTitle(?string $intrantEtQualifiantDIntrantTitle): self
    {
        $this->intrantEtQualifiantDIntrantTitle = $intrantEtQualifiantDIntrantTitle;
        return $this;
    }

    public function getIntrantEtQualifiantDIntrantReferenceCode(): ?string
    {
        return $this->intrantEtQualifiantDIntrantReferenceCode;
    }

    public function setIntrantEtQualifiantDIntrantReferenceCode(?string $intrantEtQualifiantDIntrantReferenceCode): self
    {
        $this->intrantEtQualifiantDIntrantReferenceCode = $intrantEtQualifiantDIntrantReferenceCode;
        return $this;
    }
}
