<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Type de produit récolté"
 *
 * Repository Code: List_AgriculturalProduce_CodeType
 * Référentiel ID: 605
 * Nombre d'items: 6
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété typeDeProduitRecolteId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $typeDeProduitRecolteId = null;
 */
trait TypeDeProduitRecolteTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $typeDeProduitRecolteId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typeDeProduitRecolteTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $typeDeProduitRecolteReferenceCode = null;

    public function getTypeDeProduitRecolteId(): ?int
    {
        return $this->typeDeProduitRecolteId;
    }

    public function setTypeDeProduitRecolteId(?int $typeDeProduitRecolteId): self
    {
        $this->typeDeProduitRecolteId = $typeDeProduitRecolteId;
        return $this;
    }

    public function getTypeDeProduitRecolteTitle(): ?string
    {
        return $this->typeDeProduitRecolteTitle;
    }

    public function setTypeDeProduitRecolteTitle(?string $typeDeProduitRecolteTitle): self
    {
        $this->typeDeProduitRecolteTitle = $typeDeProduitRecolteTitle;
        return $this;
    }

    public function getTypeDeProduitRecolteReferenceCode(): ?string
    {
        return $this->typeDeProduitRecolteReferenceCode;
    }

    public function setTypeDeProduitRecolteReferenceCode(?string $typeDeProduitRecolteReferenceCode): self
    {
        $this->typeDeProduitRecolteReferenceCode = $typeDeProduitRecolteReferenceCode;
        return $this;
    }
}
