<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Nature du lien"
 *
 * Repository Code: List_linktype_CodeType
 * Référentiel ID: 895
 * Nombre d'items: 3
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété natureDuLienId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $natureDuLienId = null;
 */
trait NatureDuLienTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $natureDuLienId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $natureDuLienTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $natureDuLienReferenceCode = null;

    public function getNatureDuLienId(): ?int
    {
        return $this->natureDuLienId;
    }

    public function setNatureDuLienId(?int $natureDuLienId): self
    {
        $this->natureDuLienId = $natureDuLienId;
        return $this;
    }

    public function getNatureDuLienTitle(): ?string
    {
        return $this->natureDuLienTitle;
    }

    public function setNatureDuLienTitle(?string $natureDuLienTitle): self
    {
        $this->natureDuLienTitle = $natureDuLienTitle;
        return $this;
    }

    public function getNatureDuLienReferenceCode(): ?string
    {
        return $this->natureDuLienReferenceCode;
    }

    public function setNatureDuLienReferenceCode(?string $natureDuLienReferenceCode): self
    {
        $this->natureDuLienReferenceCode = $natureDuLienReferenceCode;
        return $this;
    }
}
