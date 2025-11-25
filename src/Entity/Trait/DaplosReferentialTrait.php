<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;

/**
 * Trait unifié pour les entités de référentiels DAPLOS.
 *
 *
 * Usage:
 *   use DaplosReferentialTrait;
 *
 * L'entité aura alors les propriétés :
 *   - daplosId : ID de l'item dans l'API DAPLOS
 *   - daplosTitle : Libellé de l'item
 *   - daplosReferenceCode : Code de référence
 *   - referentialType : Type de référentiel (enum)
 *
 * @author Yoan Bernabeu
 */
trait DaplosReferentialTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer')]
    private ?int $daplosId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosTitle = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $daplosReferenceCode = null;

    #[ORM\Column(type: 'string', length: 100, enumType: DaplosReferentialType::class)]
    private ?DaplosReferentialType $referentialType = null;

    public function getDaplosId(): ?int
    {
        return $this->daplosId;
    }

    public function setDaplosId(?int $daplosId): static
    {
        $this->daplosId = $daplosId;

        return $this;
    }

    public function getDaplosTitle(): ?string
    {
        return $this->daplosTitle;
    }

    public function setDaplosTitle(?string $daplosTitle): static
    {
        $this->daplosTitle = $daplosTitle;

        return $this;
    }

    public function getDaplosReferenceCode(): ?string
    {
        return $this->daplosReferenceCode;
    }

    public function setDaplosReferenceCode(?string $daplosReferenceCode): static
    {
        $this->daplosReferenceCode = $daplosReferenceCode;

        return $this;
    }

    public function getReferentialType(): ?DaplosReferentialType
    {
        return $this->referentialType;
    }

    public function setReferentialType(?DaplosReferentialType $referentialType): static
    {
        $this->referentialType = $referentialType;

        return $this;
    }
}

