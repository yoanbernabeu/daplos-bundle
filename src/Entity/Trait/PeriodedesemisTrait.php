<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Période de semis".
 *
 * Repository Code: List_SowingPeriodCode_CodeType
 * Référentiel ID: 631
 * Nombre d'items: 2
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait PeriodedesemisTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $periodedesemisId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $periodedesemisTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $periodedesemisReferenceCode = null;

    public function getPeriodedesemisId(): ?int
    {
        return $this->periodedesemisId;
    }

    public function setPeriodedesemisId(?int $periodedesemisId): self
    {
        $this->periodedesemisId = $periodedesemisId;

        return $this;
    }

    public function getPeriodedesemisTitle(): ?string
    {
        return $this->periodedesemisTitle;
    }

    public function setPeriodedesemisTitle(?string $periodedesemisTitle): self
    {
        $this->periodedesemisTitle = $periodedesemisTitle;

        return $this;
    }

    public function getPeriodedesemisReferenceCode(): ?string
    {
        return $this->periodedesemisReferenceCode;
    }

    public function setPeriodedesemisReferenceCode(?string $periodedesemisReferenceCode): self
    {
        $this->periodedesemisReferenceCode = $periodedesemisReferenceCode;

        return $this;
    }
}
