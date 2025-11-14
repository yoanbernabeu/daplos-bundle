<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Type de sous-sol".
 *
 * Repository Code: List_SubSoilType_CodeType
 * Référentiel ID: 645
 * Nombre d'items: 18
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait TypedesoussolTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $typedesoussolId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typedesoussolTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $typedesoussolReferenceCode = null;

    public function getTypedesoussolId(): ?int
    {
        return $this->typedesoussolId;
    }

    public function setTypedesoussolId(?int $typedesoussolId): self
    {
        $this->typedesoussolId = $typedesoussolId;

        return $this;
    }

    public function getTypedesoussolTitle(): ?string
    {
        return $this->typedesoussolTitle;
    }

    public function setTypedesoussolTitle(?string $typedesoussolTitle): self
    {
        $this->typedesoussolTitle = $typedesoussolTitle;

        return $this;
    }

    public function getTypedesoussolReferenceCode(): ?string
    {
        return $this->typedesoussolReferenceCode;
    }

    public function setTypedesoussolReferenceCode(?string $typedesoussolReferenceCode): self
    {
        $this->typedesoussolReferenceCode = $typedesoussolReferenceCode;

        return $this;
    }
}
