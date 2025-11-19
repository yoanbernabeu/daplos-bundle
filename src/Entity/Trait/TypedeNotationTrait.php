<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Type de notation".
 *
 * Repository Code: List_NotationType_CodeType
 * Référentiel ID: 665
 * Nombre d'items: 8
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété typeDeNotationId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $typeDeNotationId = null;
 */
trait TypeDeNotationTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $typeDeNotationId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typeDeNotationTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $typeDeNotationReferenceCode = null;

    public function getTypeDeNotationId(): ?int
    {
        return $this->typeDeNotationId;
    }

    public function setTypeDeNotationId(?int $typeDeNotationId): self
    {
        $this->typeDeNotationId = $typeDeNotationId;

        return $this;
    }

    public function getTypeDeNotationTitle(): ?string
    {
        return $this->typeDeNotationTitle;
    }

    public function setTypeDeNotationTitle(?string $typeDeNotationTitle): self
    {
        $this->typeDeNotationTitle = $typeDeNotationTitle;

        return $this;
    }

    public function getTypeDeNotationReferenceCode(): ?string
    {
        return $this->typeDeNotationReferenceCode;
    }

    public function setTypeDeNotationReferenceCode(?string $typeDeNotationReferenceCode): self
    {
        $this->typeDeNotationReferenceCode = $typeDeNotationReferenceCode;

        return $this;
    }
}
