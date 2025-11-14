<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Type de sol".
 *
 * Repository Code: List_SoilType_CodeType
 * Référentiel ID: 643
 * Nombre d'items: 21
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait TypedesolTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $typedesolId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typedesolTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $typedesolReferenceCode = null;

    public function getTypedesolId(): ?int
    {
        return $this->typedesolId;
    }

    public function setTypedesolId(?int $typedesolId): self
    {
        $this->typedesolId = $typedesolId;

        return $this;
    }

    public function getTypedesolTitle(): ?string
    {
        return $this->typedesolTitle;
    }

    public function setTypedesolTitle(?string $typedesolTitle): self
    {
        $this->typedesolTitle = $typedesolTitle;

        return $this;
    }

    public function getTypedesolReferenceCode(): ?string
    {
        return $this->typedesolReferenceCode;
    }

    public function setTypedesolReferenceCode(?string $typedesolReferenceCode): self
    {
        $this->typedesolReferenceCode = $typedesolReferenceCode;

        return $this;
    }
}
