<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Orientation cardinale des rangs".
 *
 * Repository Code: rep47
 * Référentiel ID: 649
 * Nombre d'items: 8
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait OrientationcardinaledesrangsTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $orientationcardinaledesrangsId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $orientationcardinaledesrangsTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $orientationcardinaledesrangsReferenceCode = null;

    public function getOrientationcardinaledesrangsId(): ?int
    {
        return $this->orientationcardinaledesrangsId;
    }

    public function setOrientationcardinaledesrangsId(?int $orientationcardinaledesrangsId): self
    {
        $this->orientationcardinaledesrangsId = $orientationcardinaledesrangsId;

        return $this;
    }

    public function getOrientationcardinaledesrangsTitle(): ?string
    {
        return $this->orientationcardinaledesrangsTitle;
    }

    public function setOrientationcardinaledesrangsTitle(?string $orientationcardinaledesrangsTitle): self
    {
        $this->orientationcardinaledesrangsTitle = $orientationcardinaledesrangsTitle;

        return $this;
    }

    public function getOrientationcardinaledesrangsReferenceCode(): ?string
    {
        return $this->orientationcardinaledesrangsReferenceCode;
    }

    public function setOrientationcardinaledesrangsReferenceCode(?string $orientationcardinaledesrangsReferenceCode): self
    {
        $this->orientationcardinaledesrangsReferenceCode = $orientationcardinaledesrangsReferenceCode;

        return $this;
    }
}
