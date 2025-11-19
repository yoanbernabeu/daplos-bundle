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
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété typeDeSolId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $typeDeSolId = null;
 */
trait TypeDeSolTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $typeDeSolId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typeDeSolTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $typeDeSolReferenceCode = null;

    public function getTypeDeSolId(): ?int
    {
        return $this->typeDeSolId;
    }

    public function setTypeDeSolId(?int $typeDeSolId): self
    {
        $this->typeDeSolId = $typeDeSolId;

        return $this;
    }

    public function getTypeDeSolTitle(): ?string
    {
        return $this->typeDeSolTitle;
    }

    public function setTypeDeSolTitle(?string $typeDeSolTitle): self
    {
        $this->typeDeSolTitle = $typeDeSolTitle;

        return $this;
    }

    public function getTypeDeSolReferenceCode(): ?string
    {
        return $this->typeDeSolReferenceCode;
    }

    public function setTypeDeSolReferenceCode(?string $typeDeSolReferenceCode): self
    {
        $this->typeDeSolReferenceCode = $typeDeSolReferenceCode;

        return $this;
    }
}
