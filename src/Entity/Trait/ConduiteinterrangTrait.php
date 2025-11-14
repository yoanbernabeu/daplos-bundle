<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Conduite inter rang".
 *
 * Repository Code: rep49
 * Référentiel ID: 653
 * Nombre d'items: 5
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait ConduiteinterrangTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $conduiteinterrangId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $conduiteinterrangTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $conduiteinterrangReferenceCode = null;

    public function getConduiteinterrangId(): ?int
    {
        return $this->conduiteinterrangId;
    }

    public function setConduiteinterrangId(?int $conduiteinterrangId): self
    {
        $this->conduiteinterrangId = $conduiteinterrangId;

        return $this;
    }

    public function getConduiteinterrangTitle(): ?string
    {
        return $this->conduiteinterrangTitle;
    }

    public function setConduiteinterrangTitle(?string $conduiteinterrangTitle): self
    {
        $this->conduiteinterrangTitle = $conduiteinterrangTitle;

        return $this;
    }

    public function getConduiteinterrangReferenceCode(): ?string
    {
        return $this->conduiteinterrangReferenceCode;
    }

    public function setConduiteinterrangReferenceCode(?string $conduiteinterrangReferenceCode): self
    {
        $this->conduiteinterrangReferenceCode = $conduiteinterrangReferenceCode;

        return $this;
    }
}
