<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Stade de développement de l'élément observé".
 *
 * Repository Code: List_PestDevelopementStage_CodeType
 * Référentiel ID: 659
 * Nombre d'items: 79
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait StadededeveloppementdelelementobserveTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $stadededeveloppementdelelementobserveId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $stadededeveloppementdelelementobserveTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $stadededeveloppementdelelementobserveReferenceCode = null;

    public function getStadededeveloppementdelelementobserveId(): ?int
    {
        return $this->stadededeveloppementdelelementobserveId;
    }

    public function setStadededeveloppementdelelementobserveId(?int $stadededeveloppementdelelementobserveId): self
    {
        $this->stadededeveloppementdelelementobserveId = $stadededeveloppementdelelementobserveId;

        return $this;
    }

    public function getStadededeveloppementdelelementobserveTitle(): ?string
    {
        return $this->stadededeveloppementdelelementobserveTitle;
    }

    public function setStadededeveloppementdelelementobserveTitle(?string $stadededeveloppementdelelementobserveTitle): self
    {
        $this->stadededeveloppementdelelementobserveTitle = $stadededeveloppementdelelementobserveTitle;

        return $this;
    }

    public function getStadededeveloppementdelelementobserveReferenceCode(): ?string
    {
        return $this->stadededeveloppementdelelementobserveReferenceCode;
    }

    public function setStadededeveloppementdelelementobserveReferenceCode(?string $stadededeveloppementdelelementobserveReferenceCode): self
    {
        $this->stadededeveloppementdelelementobserveReferenceCode = $stadededeveloppementdelelementobserveReferenceCode;

        return $this;
    }
}
