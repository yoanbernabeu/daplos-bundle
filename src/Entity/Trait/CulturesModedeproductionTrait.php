<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Cultures Mode de production".
 *
 * Repository Code: List_ProductionType_CodeType
 * Référentiel ID: 703
 * Nombre d'items: 5
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait CulturesModedeproductionTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $culturesModedeproductionId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $culturesModedeproductionTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $culturesModedeproductionReferenceCode = null;

    public function getCulturesModedeproductionId(): ?int
    {
        return $this->culturesModedeproductionId;
    }

    public function setCulturesModedeproductionId(?int $culturesModedeproductionId): self
    {
        $this->culturesModedeproductionId = $culturesModedeproductionId;

        return $this;
    }

    public function getCulturesModedeproductionTitle(): ?string
    {
        return $this->culturesModedeproductionTitle;
    }

    public function setCulturesModedeproductionTitle(?string $culturesModedeproductionTitle): self
    {
        $this->culturesModedeproductionTitle = $culturesModedeproductionTitle;

        return $this;
    }

    public function getCulturesModedeproductionReferenceCode(): ?string
    {
        return $this->culturesModedeproductionReferenceCode;
    }

    public function setCulturesModedeproductionReferenceCode(?string $culturesModedeproductionReferenceCode): self
    {
        $this->culturesModedeproductionReferenceCode = $culturesModedeproductionReferenceCode;

        return $this;
    }
}
