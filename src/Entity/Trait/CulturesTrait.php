<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Cultures".
 *
 * Repository Code: List_BotanicalSpecies_CodeType
 * Référentiel ID: 611
 * Nombre d'items: 716
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait CulturesTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $culturesId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $culturesTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $culturesReferenceCode = null;

    public function getCulturesId(): ?int
    {
        return $this->culturesId;
    }

    public function setCulturesId(?int $culturesId): self
    {
        $this->culturesId = $culturesId;

        return $this;
    }

    public function getCulturesTitle(): ?string
    {
        return $this->culturesTitle;
    }

    public function setCulturesTitle(?string $culturesTitle): self
    {
        $this->culturesTitle = $culturesTitle;

        return $this;
    }

    public function getCulturesReferenceCode(): ?string
    {
        return $this->culturesReferenceCode;
    }

    public function setCulturesReferenceCode(?string $culturesReferenceCode): self
    {
        $this->culturesReferenceCode = $culturesReferenceCode;

        return $this;
    }
}
