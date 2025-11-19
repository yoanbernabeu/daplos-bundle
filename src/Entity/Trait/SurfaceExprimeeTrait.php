<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Surface exprimée".
 *
 * Repository Code: List_AgriculturalArea_CodeType
 * Référentiel ID: 641
 * Nombre d'items: 17
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété surfaceExprimeeId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $surfaceExprimeeId = null;
 */
trait SurfaceExprimeeTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $surfaceExprimeeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $surfaceExprimeeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $surfaceExprimeeReferenceCode = null;

    public function getSurfaceExprimeeId(): ?int
    {
        return $this->surfaceExprimeeId;
    }

    public function setSurfaceExprimeeId(?int $surfaceExprimeeId): self
    {
        $this->surfaceExprimeeId = $surfaceExprimeeId;

        return $this;
    }

    public function getSurfaceExprimeeTitle(): ?string
    {
        return $this->surfaceExprimeeTitle;
    }

    public function setSurfaceExprimeeTitle(?string $surfaceExprimeeTitle): self
    {
        $this->surfaceExprimeeTitle = $surfaceExprimeeTitle;

        return $this;
    }

    public function getSurfaceExprimeeReferenceCode(): ?string
    {
        return $this->surfaceExprimeeReferenceCode;
    }

    public function setSurfaceExprimeeReferenceCode(?string $surfaceExprimeeReferenceCode): self
    {
        $this->surfaceExprimeeReferenceCode = $surfaceExprimeeReferenceCode;

        return $this;
    }
}
