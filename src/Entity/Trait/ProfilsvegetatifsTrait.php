<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Profils végétatifs"
 *
 * Repository Code: Profils végétatifs
 * Référentiel ID: 657
 * Nombre d'items: 57
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait ProfilsvegetatifsTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $profilsvegetatifsId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $profilsvegetatifsTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $profilsvegetatifsReferenceCode = null;

    public function getProfilsvegetatifsId(): ?int
    {
        return $this->profilsvegetatifsId;
    }

    public function setProfilsvegetatifsId(?int $profilsvegetatifsId): self
    {
        $this->profilsvegetatifsId = $profilsvegetatifsId;
        return $this;
    }

    public function getProfilsvegetatifsTitle(): ?string
    {
        return $this->profilsvegetatifsTitle;
    }

    public function setProfilsvegetatifsTitle(?string $profilsvegetatifsTitle): self
    {
        $this->profilsvegetatifsTitle = $profilsvegetatifsTitle;
        return $this;
    }

    public function getProfilsvegetatifsReferenceCode(): ?string
    {
        return $this->profilsvegetatifsReferenceCode;
    }

    public function setProfilsvegetatifsReferenceCode(?string $profilsvegetatifsReferenceCode): self
    {
        $this->profilsvegetatifsReferenceCode = $profilsvegetatifsReferenceCode;
        return $this;
    }
}
