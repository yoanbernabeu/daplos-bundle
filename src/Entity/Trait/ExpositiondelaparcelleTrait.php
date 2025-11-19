<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Exposition de la parcelle"
 *
 * Repository Code: rep46
 * Référentiel ID: 647
 * Nombre d'items: 17
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété expositionDeLaParcelleId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $expositionDeLaParcelleId = null;
 */
trait ExpositionDeLaParcelleTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $expositionDeLaParcelleId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $expositionDeLaParcelleTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $expositionDeLaParcelleReferenceCode = null;

    public function getExpositionDeLaParcelleId(): ?int
    {
        return $this->expositionDeLaParcelleId;
    }

    public function setExpositionDeLaParcelleId(?int $expositionDeLaParcelleId): self
    {
        $this->expositionDeLaParcelleId = $expositionDeLaParcelleId;
        return $this;
    }

    public function getExpositionDeLaParcelleTitle(): ?string
    {
        return $this->expositionDeLaParcelleTitle;
    }

    public function setExpositionDeLaParcelleTitle(?string $expositionDeLaParcelleTitle): self
    {
        $this->expositionDeLaParcelleTitle = $expositionDeLaParcelleTitle;
        return $this;
    }

    public function getExpositionDeLaParcelleReferenceCode(): ?string
    {
        return $this->expositionDeLaParcelleReferenceCode;
    }

    public function setExpositionDeLaParcelleReferenceCode(?string $expositionDeLaParcelleReferenceCode): self
    {
        $this->expositionDeLaParcelleReferenceCode = $expositionDeLaParcelleReferenceCode;
        return $this;
    }
}
