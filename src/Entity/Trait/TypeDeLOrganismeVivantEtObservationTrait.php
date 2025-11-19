<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Type de l'organisme vivant et observation"
 *
 * Repository Code: List_PestType_CodeType
 * Référentiel ID: 675
 * Nombre d'items: 10
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété typeDeLOrganismeVivantEtObservationId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $typeDeLOrganismeVivantEtObservationId = null;
 */
trait TypeDeLOrganismeVivantEtObservationTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $typeDeLOrganismeVivantEtObservationId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typeDeLOrganismeVivantEtObservationTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $typeDeLOrganismeVivantEtObservationReferenceCode = null;

    public function getTypeDeLOrganismeVivantEtObservationId(): ?int
    {
        return $this->typeDeLOrganismeVivantEtObservationId;
    }

    public function setTypeDeLOrganismeVivantEtObservationId(?int $typeDeLOrganismeVivantEtObservationId): self
    {
        $this->typeDeLOrganismeVivantEtObservationId = $typeDeLOrganismeVivantEtObservationId;
        return $this;
    }

    public function getTypeDeLOrganismeVivantEtObservationTitle(): ?string
    {
        return $this->typeDeLOrganismeVivantEtObservationTitle;
    }

    public function setTypeDeLOrganismeVivantEtObservationTitle(?string $typeDeLOrganismeVivantEtObservationTitle): self
    {
        $this->typeDeLOrganismeVivantEtObservationTitle = $typeDeLOrganismeVivantEtObservationTitle;
        return $this;
    }

    public function getTypeDeLOrganismeVivantEtObservationReferenceCode(): ?string
    {
        return $this->typeDeLOrganismeVivantEtObservationReferenceCode;
    }

    public function setTypeDeLOrganismeVivantEtObservationReferenceCode(?string $typeDeLOrganismeVivantEtObservationReferenceCode): self
    {
        $this->typeDeLOrganismeVivantEtObservationReferenceCode = $typeDeLOrganismeVivantEtObservationReferenceCode;
        return $this;
    }
}
