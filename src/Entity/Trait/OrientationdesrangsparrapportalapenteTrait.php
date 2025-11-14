<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Orientation des rangs par rapport à la pente".
 *
 * Repository Code: rep48
 * Référentiel ID: 651
 * Nombre d'items: 3
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait OrientationdesrangsparrapportalapenteTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $orientationdesrangsparrapportalapenteId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $orientationdesrangsparrapportalapenteTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $orientationdesrangsparrapportalapenteReferenceCode = null;

    public function getOrientationdesrangsparrapportalapenteId(): ?int
    {
        return $this->orientationdesrangsparrapportalapenteId;
    }

    public function setOrientationdesrangsparrapportalapenteId(?int $orientationdesrangsparrapportalapenteId): self
    {
        $this->orientationdesrangsparrapportalapenteId = $orientationdesrangsparrapportalapenteId;

        return $this;
    }

    public function getOrientationdesrangsparrapportalapenteTitle(): ?string
    {
        return $this->orientationdesrangsparrapportalapenteTitle;
    }

    public function setOrientationdesrangsparrapportalapenteTitle(?string $orientationdesrangsparrapportalapenteTitle): self
    {
        $this->orientationdesrangsparrapportalapenteTitle = $orientationdesrangsparrapportalapenteTitle;

        return $this;
    }

    public function getOrientationdesrangsparrapportalapenteReferenceCode(): ?string
    {
        return $this->orientationdesrangsparrapportalapenteReferenceCode;
    }

    public function setOrientationdesrangsparrapportalapenteReferenceCode(?string $orientationdesrangsparrapportalapenteReferenceCode): self
    {
        $this->orientationdesrangsparrapportalapenteReferenceCode = $orientationdesrangsparrapportalapenteReferenceCode;

        return $this;
    }
}
