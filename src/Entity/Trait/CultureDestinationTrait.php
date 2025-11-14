<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Culture (Destination)".
 *
 * Repository Code: List_PurposeCode_CodeType
 * Référentiel ID: 627
 * Nombre d'items: 50
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait CultureDestinationTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $cultureDestinationId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cultureDestinationTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $cultureDestinationReferenceCode = null;

    public function getCultureDestinationId(): ?int
    {
        return $this->cultureDestinationId;
    }

    public function setCultureDestinationId(?int $cultureDestinationId): self
    {
        $this->cultureDestinationId = $cultureDestinationId;

        return $this;
    }

    public function getCultureDestinationTitle(): ?string
    {
        return $this->cultureDestinationTitle;
    }

    public function setCultureDestinationTitle(?string $cultureDestinationTitle): self
    {
        $this->cultureDestinationTitle = $cultureDestinationTitle;

        return $this;
    }

    public function getCultureDestinationReferenceCode(): ?string
    {
        return $this->cultureDestinationReferenceCode;
    }

    public function setCultureDestinationReferenceCode(?string $cultureDestinationReferenceCode): self
    {
        $this->cultureDestinationReferenceCode = $cultureDestinationReferenceCode;

        return $this;
    }
}
