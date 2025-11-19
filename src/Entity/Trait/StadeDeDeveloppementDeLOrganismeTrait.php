<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Stade de développement de l’organisme"
 *
 * Repository Code: List_PestDevelopementStage_CodeType
 * Référentiel ID: 659
 * Nombre d'items: 79
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété stadeDeDeveloppementDeLOrganismeId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $stadeDeDeveloppementDeLOrganismeId = null;
 */
trait StadeDeDeveloppementDeLOrganismeTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $stadeDeDeveloppementDeLOrganismeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $stadeDeDeveloppementDeLOrganismeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $stadeDeDeveloppementDeLOrganismeReferenceCode = null;

    public function getStadeDeDeveloppementDeLOrganismeId(): ?int
    {
        return $this->stadeDeDeveloppementDeLOrganismeId;
    }

    public function setStadeDeDeveloppementDeLOrganismeId(?int $stadeDeDeveloppementDeLOrganismeId): self
    {
        $this->stadeDeDeveloppementDeLOrganismeId = $stadeDeDeveloppementDeLOrganismeId;
        return $this;
    }

    public function getStadeDeDeveloppementDeLOrganismeTitle(): ?string
    {
        return $this->stadeDeDeveloppementDeLOrganismeTitle;
    }

    public function setStadeDeDeveloppementDeLOrganismeTitle(?string $stadeDeDeveloppementDeLOrganismeTitle): self
    {
        $this->stadeDeDeveloppementDeLOrganismeTitle = $stadeDeDeveloppementDeLOrganismeTitle;
        return $this;
    }

    public function getStadeDeDeveloppementDeLOrganismeReferenceCode(): ?string
    {
        return $this->stadeDeDeveloppementDeLOrganismeReferenceCode;
    }

    public function setStadeDeDeveloppementDeLOrganismeReferenceCode(?string $stadeDeDeveloppementDeLOrganismeReferenceCode): self
    {
        $this->stadeDeDeveloppementDeLOrganismeReferenceCode = $stadeDeDeveloppementDeLOrganismeReferenceCode;
        return $this;
    }
}
