<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Zone rattachée à la parcelle culturale".
 *
 * Repository Code: List_AgriculturalCountrySubdivision_CodeType
 * Référentiel ID: 687
 * Nombre d'items: 2
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété zoneRattacheeALaParcelleCulturaleId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $zoneRattacheeALaParcelleCulturaleId = null;
 */
trait ZoneRattacheeALaParcelleCulturaleTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $zoneRattacheeALaParcelleCulturaleId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $zoneRattacheeALaParcelleCulturaleTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $zoneRattacheeALaParcelleCulturaleReferenceCode = null;

    public function getZoneRattacheeALaParcelleCulturaleId(): ?int
    {
        return $this->zoneRattacheeALaParcelleCulturaleId;
    }

    public function setZoneRattacheeALaParcelleCulturaleId(?int $zoneRattacheeALaParcelleCulturaleId): self
    {
        $this->zoneRattacheeALaParcelleCulturaleId = $zoneRattacheeALaParcelleCulturaleId;

        return $this;
    }

    public function getZoneRattacheeALaParcelleCulturaleTitle(): ?string
    {
        return $this->zoneRattacheeALaParcelleCulturaleTitle;
    }

    public function setZoneRattacheeALaParcelleCulturaleTitle(?string $zoneRattacheeALaParcelleCulturaleTitle): self
    {
        $this->zoneRattacheeALaParcelleCulturaleTitle = $zoneRattacheeALaParcelleCulturaleTitle;

        return $this;
    }

    public function getZoneRattacheeALaParcelleCulturaleReferenceCode(): ?string
    {
        return $this->zoneRattacheeALaParcelleCulturaleReferenceCode;
    }

    public function setZoneRattacheeALaParcelleCulturaleReferenceCode(?string $zoneRattacheeALaParcelleCulturaleReferenceCode): self
    {
        $this->zoneRattacheeALaParcelleCulturaleReferenceCode = $zoneRattacheeALaParcelleCulturaleReferenceCode;

        return $this;
    }
}
