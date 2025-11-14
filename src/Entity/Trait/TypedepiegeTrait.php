<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Type de piège"
 *
 * Repository Code: List_TrapType_CodeType
 * Référentiel ID: 667
 * Nombre d'items: 40
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait TypedepiegeTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $typedepiegeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typedepiegeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $typedepiegeReferenceCode = null;

    public function getTypedepiegeId(): ?int
    {
        return $this->typedepiegeId;
    }

    public function setTypedepiegeId(?int $typedepiegeId): self
    {
        $this->typedepiegeId = $typedepiegeId;
        return $this;
    }

    public function getTypedepiegeTitle(): ?string
    {
        return $this->typedepiegeTitle;
    }

    public function setTypedepiegeTitle(?string $typedepiegeTitle): self
    {
        $this->typedepiegeTitle = $typedepiegeTitle;
        return $this;
    }

    public function getTypedepiegeReferenceCode(): ?string
    {
        return $this->typedepiegeReferenceCode;
    }

    public function setTypedepiegeReferenceCode(?string $typedepiegeReferenceCode): self
    {
        $this->typedepiegeReferenceCode = $typedepiegeReferenceCode;
        return $this;
    }
}
