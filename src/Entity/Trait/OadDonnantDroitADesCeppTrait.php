<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "OAD donnant droit à des CEPP".
 *
 * Repository Code: List_OAD_CEPP
 * Référentiel ID: 910
 * Nombre d'items: 0
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété oadDonnantDroitADesCeppId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $oadDonnantDroitADesCeppId = null;
 */
trait OadDonnantDroitADesCeppTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $oadDonnantDroitADesCeppId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $oadDonnantDroitADesCeppTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $oadDonnantDroitADesCeppReferenceCode = null;

    public function getOadDonnantDroitADesCeppId(): ?int
    {
        return $this->oadDonnantDroitADesCeppId;
    }

    public function setOadDonnantDroitADesCeppId(?int $oadDonnantDroitADesCeppId): self
    {
        $this->oadDonnantDroitADesCeppId = $oadDonnantDroitADesCeppId;

        return $this;
    }

    public function getOadDonnantDroitADesCeppTitle(): ?string
    {
        return $this->oadDonnantDroitADesCeppTitle;
    }

    public function setOadDonnantDroitADesCeppTitle(?string $oadDonnantDroitADesCeppTitle): self
    {
        $this->oadDonnantDroitADesCeppTitle = $oadDonnantDroitADesCeppTitle;

        return $this;
    }

    public function getOadDonnantDroitADesCeppReferenceCode(): ?string
    {
        return $this->oadDonnantDroitADesCeppReferenceCode;
    }

    public function setOadDonnantDroitADesCeppReferenceCode(?string $oadDonnantDroitADesCeppReferenceCode): self
    {
        $this->oadDonnantDroitADesCeppReferenceCode = $oadDonnantDroitADesCeppReferenceCode;

        return $this;
    }
}
