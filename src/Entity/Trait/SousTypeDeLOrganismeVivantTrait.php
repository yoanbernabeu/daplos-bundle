<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Sous-type de l'organisme vivant"
 *
 * Repository Code: List_PestSubType
 * Référentiel ID: 912
 * Nombre d'items: 20
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété sousTypeDeLOrganismeVivantId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $sousTypeDeLOrganismeVivantId = null;
 */
trait SousTypeDeLOrganismeVivantTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $sousTypeDeLOrganismeVivantId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $sousTypeDeLOrganismeVivantTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $sousTypeDeLOrganismeVivantReferenceCode = null;

    public function getSousTypeDeLOrganismeVivantId(): ?int
    {
        return $this->sousTypeDeLOrganismeVivantId;
    }

    public function setSousTypeDeLOrganismeVivantId(?int $sousTypeDeLOrganismeVivantId): self
    {
        $this->sousTypeDeLOrganismeVivantId = $sousTypeDeLOrganismeVivantId;
        return $this;
    }

    public function getSousTypeDeLOrganismeVivantTitle(): ?string
    {
        return $this->sousTypeDeLOrganismeVivantTitle;
    }

    public function setSousTypeDeLOrganismeVivantTitle(?string $sousTypeDeLOrganismeVivantTitle): self
    {
        $this->sousTypeDeLOrganismeVivantTitle = $sousTypeDeLOrganismeVivantTitle;
        return $this;
    }

    public function getSousTypeDeLOrganismeVivantReferenceCode(): ?string
    {
        return $this->sousTypeDeLOrganismeVivantReferenceCode;
    }

    public function setSousTypeDeLOrganismeVivantReferenceCode(?string $sousTypeDeLOrganismeVivantReferenceCode): self
    {
        $this->sousTypeDeLOrganismeVivantReferenceCode = $sousTypeDeLOrganismeVivantReferenceCode;
        return $this;
    }
}
