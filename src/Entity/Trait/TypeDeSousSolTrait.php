<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Type de sous-sol".
 *
 * Repository Code: List_SubSoilType_CodeType
 * Référentiel ID: 645
 * Nombre d'items: 18
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété typeDeSousSolId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $typeDeSousSolId = null;
 */
trait TypeDeSousSolTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $typeDeSousSolId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typeDeSousSolTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $typeDeSousSolReferenceCode = null;

    public function getTypeDeSousSolId(): ?int
    {
        return $this->typeDeSousSolId;
    }

    public function setTypeDeSousSolId(?int $typeDeSousSolId): self
    {
        $this->typeDeSousSolId = $typeDeSousSolId;

        return $this;
    }

    public function getTypeDeSousSolTitle(): ?string
    {
        return $this->typeDeSousSolTitle;
    }

    public function setTypeDeSousSolTitle(?string $typeDeSousSolTitle): self
    {
        $this->typeDeSousSolTitle = $typeDeSousSolTitle;

        return $this;
    }

    public function getTypeDeSousSolReferenceCode(): ?string
    {
        return $this->typeDeSousSolReferenceCode;
    }

    public function setTypeDeSousSolReferenceCode(?string $typeDeSousSolReferenceCode): self
    {
        $this->typeDeSousSolReferenceCode = $typeDeSousSolReferenceCode;

        return $this;
    }
}
