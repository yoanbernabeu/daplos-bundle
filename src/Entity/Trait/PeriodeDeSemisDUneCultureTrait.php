<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Période de semis d’une culture".
 *
 * Repository Code: List_SowingPeriodCode_CodeType
 * Référentiel ID: 631
 * Nombre d'items: 2
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété periodeDeSemisDUneCultureId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $periodeDeSemisDUneCultureId = null;
 */
trait PeriodeDeSemisDUneCultureTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $periodeDeSemisDUneCultureId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $periodeDeSemisDUneCultureTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $periodeDeSemisDUneCultureReferenceCode = null;

    public function getPeriodeDeSemisDUneCultureId(): ?int
    {
        return $this->periodeDeSemisDUneCultureId;
    }

    public function setPeriodeDeSemisDUneCultureId(?int $periodeDeSemisDUneCultureId): self
    {
        $this->periodeDeSemisDUneCultureId = $periodeDeSemisDUneCultureId;

        return $this;
    }

    public function getPeriodeDeSemisDUneCultureTitle(): ?string
    {
        return $this->periodeDeSemisDUneCultureTitle;
    }

    public function setPeriodeDeSemisDUneCultureTitle(?string $periodeDeSemisDUneCultureTitle): self
    {
        $this->periodeDeSemisDUneCultureTitle = $periodeDeSemisDUneCultureTitle;

        return $this;
    }

    public function getPeriodeDeSemisDUneCultureReferenceCode(): ?string
    {
        return $this->periodeDeSemisDUneCultureReferenceCode;
    }

    public function setPeriodeDeSemisDUneCultureReferenceCode(?string $periodeDeSemisDUneCultureReferenceCode): self
    {
        $this->periodeDeSemisDUneCultureReferenceCode = $periodeDeSemisDUneCultureReferenceCode;

        return $this;
    }
}
