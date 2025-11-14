<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Symptômes et dégâts observés".
 *
 * Repository Code: List_SymptomDamageObserved_CodeType
 * Référentiel ID: 669
 * Nombre d'items: 179
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait SymptomesetdegatsobservesTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $symptomesetdegatsobservesId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $symptomesetdegatsobservesTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $symptomesetdegatsobservesReferenceCode = null;

    public function getSymptomesetdegatsobservesId(): ?int
    {
        return $this->symptomesetdegatsobservesId;
    }

    public function setSymptomesetdegatsobservesId(?int $symptomesetdegatsobservesId): self
    {
        $this->symptomesetdegatsobservesId = $symptomesetdegatsobservesId;

        return $this;
    }

    public function getSymptomesetdegatsobservesTitle(): ?string
    {
        return $this->symptomesetdegatsobservesTitle;
    }

    public function setSymptomesetdegatsobservesTitle(?string $symptomesetdegatsobservesTitle): self
    {
        $this->symptomesetdegatsobservesTitle = $symptomesetdegatsobservesTitle;

        return $this;
    }

    public function getSymptomesetdegatsobservesReferenceCode(): ?string
    {
        return $this->symptomesetdegatsobservesReferenceCode;
    }

    public function setSymptomesetdegatsobservesReferenceCode(?string $symptomesetdegatsobservesReferenceCode): self
    {
        $this->symptomesetdegatsobservesReferenceCode = $symptomesetdegatsobservesReferenceCode;

        return $this;
    }
}
