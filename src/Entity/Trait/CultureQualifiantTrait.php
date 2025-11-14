<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Culture (Qualifiant)".
 *
 * Repository Code: List_SupplementaryBotanicalSpecies_CodeType
 * Référentiel ID: 639
 * Nombre d'items: 112
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait CultureQualifiantTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $cultureQualifiantId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cultureQualifiantTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $cultureQualifiantReferenceCode = null;

    public function getCultureQualifiantId(): ?int
    {
        return $this->cultureQualifiantId;
    }

    public function setCultureQualifiantId(?int $cultureQualifiantId): self
    {
        $this->cultureQualifiantId = $cultureQualifiantId;

        return $this;
    }

    public function getCultureQualifiantTitle(): ?string
    {
        return $this->cultureQualifiantTitle;
    }

    public function setCultureQualifiantTitle(?string $cultureQualifiantTitle): self
    {
        $this->cultureQualifiantTitle = $cultureQualifiantTitle;

        return $this;
    }

    public function getCultureQualifiantReferenceCode(): ?string
    {
        return $this->cultureQualifiantReferenceCode;
    }

    public function setCultureQualifiantReferenceCode(?string $cultureQualifiantReferenceCode): self
    {
        $this->cultureQualifiantReferenceCode = $cultureQualifiantReferenceCode;

        return $this;
    }
}
