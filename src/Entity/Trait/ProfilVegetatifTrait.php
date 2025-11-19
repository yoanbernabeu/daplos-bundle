<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Profil végétatif"
 *
 * Repository Code: Profils végétatifs
 * Référentiel ID: 657
 * Nombre d'items: 57
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété profilVegetatifId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $profilVegetatifId = null;
 */
trait ProfilVegetatifTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $profilVegetatifId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $profilVegetatifTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $profilVegetatifReferenceCode = null;

    public function getProfilVegetatifId(): ?int
    {
        return $this->profilVegetatifId;
    }

    public function setProfilVegetatifId(?int $profilVegetatifId): self
    {
        $this->profilVegetatifId = $profilVegetatifId;
        return $this;
    }

    public function getProfilVegetatifTitle(): ?string
    {
        return $this->profilVegetatifTitle;
    }

    public function setProfilVegetatifTitle(?string $profilVegetatifTitle): self
    {
        $this->profilVegetatifTitle = $profilVegetatifTitle;
        return $this;
    }

    public function getProfilVegetatifReferenceCode(): ?string
    {
        return $this->profilVegetatifReferenceCode;
    }

    public function setProfilVegetatifReferenceCode(?string $profilVegetatifReferenceCode): self
    {
        $this->profilVegetatifReferenceCode = $profilVegetatifReferenceCode;
        return $this;
    }
}
