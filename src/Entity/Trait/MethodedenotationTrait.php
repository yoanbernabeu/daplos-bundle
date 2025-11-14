<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Méthode de notation"
 *
 * Repository Code: List_NotationMethodology_CodeType
 * Référentiel ID: 663
 * Nombre d'items: 4
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait MethodedenotationTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $methodedenotationId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $methodedenotationTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $methodedenotationReferenceCode = null;

    public function getMethodedenotationId(): ?int
    {
        return $this->methodedenotationId;
    }

    public function setMethodedenotationId(?int $methodedenotationId): self
    {
        $this->methodedenotationId = $methodedenotationId;
        return $this;
    }

    public function getMethodedenotationTitle(): ?string
    {
        return $this->methodedenotationTitle;
    }

    public function setMethodedenotationTitle(?string $methodedenotationTitle): self
    {
        $this->methodedenotationTitle = $methodedenotationTitle;
        return $this;
    }

    public function getMethodedenotationReferenceCode(): ?string
    {
        return $this->methodedenotationReferenceCode;
    }

    public function setMethodedenotationReferenceCode(?string $methodedenotationReferenceCode): self
    {
        $this->methodedenotationReferenceCode = $methodedenotationReferenceCode;
        return $this;
    }
}
