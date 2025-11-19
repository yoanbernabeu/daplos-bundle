<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Méthode de mesure"
 *
 * Repository Code: List_MeasurementMethodCode_CodeType
 * Référentiel ID: 621
 * Nombre d'items: 8
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété methodeDeMesureId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $methodeDeMesureId = null;
 */
trait MethodeDeMesureTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $methodeDeMesureId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $methodeDeMesureTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $methodeDeMesureReferenceCode = null;

    public function getMethodeDeMesureId(): ?int
    {
        return $this->methodeDeMesureId;
    }

    public function setMethodeDeMesureId(?int $methodeDeMesureId): self
    {
        $this->methodeDeMesureId = $methodeDeMesureId;
        return $this;
    }

    public function getMethodeDeMesureTitle(): ?string
    {
        return $this->methodeDeMesureTitle;
    }

    public function setMethodeDeMesureTitle(?string $methodeDeMesureTitle): self
    {
        $this->methodeDeMesureTitle = $methodeDeMesureTitle;
        return $this;
    }

    public function getMethodeDeMesureReferenceCode(): ?string
    {
        return $this->methodeDeMesureReferenceCode;
    }

    public function setMethodeDeMesureReferenceCode(?string $methodeDeMesureReferenceCode): self
    {
        $this->methodeDeMesureReferenceCode = $methodeDeMesureReferenceCode;
        return $this;
    }
}
