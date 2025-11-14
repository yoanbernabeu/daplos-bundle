<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Indicateur".
 *
 * Repository Code: List_IndicatorType
 * Référentiel ID: 619
 * Nombre d'items: 2
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait IndicateurTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $indicateurId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $indicateurTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $indicateurReferenceCode = null;

    public function getIndicateurId(): ?int
    {
        return $this->indicateurId;
    }

    public function setIndicateurId(?int $indicateurId): self
    {
        $this->indicateurId = $indicateurId;

        return $this;
    }

    public function getIndicateurTitle(): ?string
    {
        return $this->indicateurTitle;
    }

    public function setIndicateurTitle(?string $indicateurTitle): self
    {
        $this->indicateurTitle = $indicateurTitle;

        return $this;
    }

    public function getIndicateurReferenceCode(): ?string
    {
        return $this->indicateurReferenceCode;
    }

    public function setIndicateurReferenceCode(?string $indicateurReferenceCode): self
    {
        $this->indicateurReferenceCode = $indicateurReferenceCode;

        return $this;
    }
}
