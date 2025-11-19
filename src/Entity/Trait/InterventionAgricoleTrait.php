<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Intervention agricole".
 *
 * Repository Code: List_AgriculturalProcessWorkItem_CodeType
 * Référentiel ID: 603
 * Nombre d'items: 134
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété interventionAgricoleId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $interventionAgricoleId = null;
 */
trait InterventionAgricoleTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $interventionAgricoleId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $interventionAgricoleTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $interventionAgricoleReferenceCode = null;

    public function getInterventionAgricoleId(): ?int
    {
        return $this->interventionAgricoleId;
    }

    public function setInterventionAgricoleId(?int $interventionAgricoleId): self
    {
        $this->interventionAgricoleId = $interventionAgricoleId;

        return $this;
    }

    public function getInterventionAgricoleTitle(): ?string
    {
        return $this->interventionAgricoleTitle;
    }

    public function setInterventionAgricoleTitle(?string $interventionAgricoleTitle): self
    {
        $this->interventionAgricoleTitle = $interventionAgricoleTitle;

        return $this;
    }

    public function getInterventionAgricoleReferenceCode(): ?string
    {
        return $this->interventionAgricoleReferenceCode;
    }

    public function setInterventionAgricoleReferenceCode(?string $interventionAgricoleReferenceCode): self
    {
        $this->interventionAgricoleReferenceCode = $interventionAgricoleReferenceCode;

        return $this;
    }
}
