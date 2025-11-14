<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Intrant (Type)".
 *
 * Repository Code: List_AgriculturalProcessCropInput_CodeType
 * Référentiel ID: 593
 * Nombre d'items: 35
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait IntrantTypeTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $intrantTypeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $intrantTypeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $intrantTypeReferenceCode = null;

    public function getIntrantTypeId(): ?int
    {
        return $this->intrantTypeId;
    }

    public function setIntrantTypeId(?int $intrantTypeId): self
    {
        $this->intrantTypeId = $intrantTypeId;

        return $this;
    }

    public function getIntrantTypeTitle(): ?string
    {
        return $this->intrantTypeTitle;
    }

    public function setIntrantTypeTitle(?string $intrantTypeTitle): self
    {
        $this->intrantTypeTitle = $intrantTypeTitle;

        return $this;
    }

    public function getIntrantTypeReferenceCode(): ?string
    {
        return $this->intrantTypeReferenceCode;
    }

    public function setIntrantTypeReferenceCode(?string $intrantTypeReferenceCode): self
    {
        $this->intrantTypeReferenceCode = $intrantTypeReferenceCode;

        return $this;
    }
}
