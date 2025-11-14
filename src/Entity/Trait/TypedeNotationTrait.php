<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Type de Notation".
 *
 * Repository Code: List_NotationType_CodeType
 * Référentiel ID: 665
 * Nombre d'items: 8
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait TypedeNotationTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $typedeNotationId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typedeNotationTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $typedeNotationReferenceCode = null;

    public function getTypedeNotationId(): ?int
    {
        return $this->typedeNotationId;
    }

    public function setTypedeNotationId(?int $typedeNotationId): self
    {
        $this->typedeNotationId = $typedeNotationId;

        return $this;
    }

    public function getTypedeNotationTitle(): ?string
    {
        return $this->typedeNotationTitle;
    }

    public function setTypedeNotationTitle(?string $typedeNotationTitle): self
    {
        $this->typedeNotationTitle = $typedeNotationTitle;

        return $this;
    }

    public function getTypedeNotationReferenceCode(): ?string
    {
        return $this->typedeNotationReferenceCode;
    }

    public function setTypedeNotationReferenceCode(?string $typedeNotationReferenceCode): self
    {
        $this->typedeNotationReferenceCode = $typedeNotationReferenceCode;

        return $this;
    }
}
