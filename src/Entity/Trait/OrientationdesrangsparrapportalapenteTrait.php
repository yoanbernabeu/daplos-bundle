<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Orientation des rangs par rapport à la pente"
 *
 * Repository Code: rep48
 * Référentiel ID: 651
 * Nombre d'items: 3
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété orientationDesRangsParRapportALaPenteId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $orientationDesRangsParRapportALaPenteId = null;
 */
trait OrientationDesRangsParRapportALaPenteTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $orientationDesRangsParRapportALaPenteId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $orientationDesRangsParRapportALaPenteTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $orientationDesRangsParRapportALaPenteReferenceCode = null;

    public function getOrientationDesRangsParRapportALaPenteId(): ?int
    {
        return $this->orientationDesRangsParRapportALaPenteId;
    }

    public function setOrientationDesRangsParRapportALaPenteId(?int $orientationDesRangsParRapportALaPenteId): self
    {
        $this->orientationDesRangsParRapportALaPenteId = $orientationDesRangsParRapportALaPenteId;
        return $this;
    }

    public function getOrientationDesRangsParRapportALaPenteTitle(): ?string
    {
        return $this->orientationDesRangsParRapportALaPenteTitle;
    }

    public function setOrientationDesRangsParRapportALaPenteTitle(?string $orientationDesRangsParRapportALaPenteTitle): self
    {
        $this->orientationDesRangsParRapportALaPenteTitle = $orientationDesRangsParRapportALaPenteTitle;
        return $this;
    }

    public function getOrientationDesRangsParRapportALaPenteReferenceCode(): ?string
    {
        return $this->orientationDesRangsParRapportALaPenteReferenceCode;
    }

    public function setOrientationDesRangsParRapportALaPenteReferenceCode(?string $orientationDesRangsParRapportALaPenteReferenceCode): self
    {
        $this->orientationDesRangsParRapportALaPenteReferenceCode = $orientationDesRangsParRapportALaPenteReferenceCode;
        return $this;
    }
}
