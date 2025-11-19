<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Catégorie d'intervention".
 *
 * Repository Code: List_PlotAgriculturalProcess_CodeType
 * Référentiel ID: 625
 * Nombre d'items: 6
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété categorieDInterventionId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $categorieDInterventionId = null;
 */
trait CategorieDInterventionTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $categorieDInterventionId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $categorieDInterventionTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $categorieDInterventionReferenceCode = null;

    public function getCategorieDInterventionId(): ?int
    {
        return $this->categorieDInterventionId;
    }

    public function setCategorieDInterventionId(?int $categorieDInterventionId): self
    {
        $this->categorieDInterventionId = $categorieDInterventionId;

        return $this;
    }

    public function getCategorieDInterventionTitle(): ?string
    {
        return $this->categorieDInterventionTitle;
    }

    public function setCategorieDInterventionTitle(?string $categorieDInterventionTitle): self
    {
        $this->categorieDInterventionTitle = $categorieDInterventionTitle;

        return $this;
    }

    public function getCategorieDInterventionReferenceCode(): ?string
    {
        return $this->categorieDInterventionReferenceCode;
    }

    public function setCategorieDInterventionReferenceCode(?string $categorieDInterventionReferenceCode): self
    {
        $this->categorieDInterventionReferenceCode = $categorieDInterventionReferenceCode;

        return $this;
    }
}
