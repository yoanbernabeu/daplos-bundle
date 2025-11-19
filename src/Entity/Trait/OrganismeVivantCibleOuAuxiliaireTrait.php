<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Organisme vivant (cible ou auxiliaire)"
 *
 * Repository Code: List_PestName_CodeType
 * Référentiel ID: 615
 * Nombre d'items: 2424
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété organismeVivantCibleOuAuxiliaireId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $organismeVivantCibleOuAuxiliaireId = null;
 */
trait OrganismeVivantCibleOuAuxiliaireTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $organismeVivantCibleOuAuxiliaireId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $organismeVivantCibleOuAuxiliaireTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $organismeVivantCibleOuAuxiliaireReferenceCode = null;

    public function getOrganismeVivantCibleOuAuxiliaireId(): ?int
    {
        return $this->organismeVivantCibleOuAuxiliaireId;
    }

    public function setOrganismeVivantCibleOuAuxiliaireId(?int $organismeVivantCibleOuAuxiliaireId): self
    {
        $this->organismeVivantCibleOuAuxiliaireId = $organismeVivantCibleOuAuxiliaireId;
        return $this;
    }

    public function getOrganismeVivantCibleOuAuxiliaireTitle(): ?string
    {
        return $this->organismeVivantCibleOuAuxiliaireTitle;
    }

    public function setOrganismeVivantCibleOuAuxiliaireTitle(?string $organismeVivantCibleOuAuxiliaireTitle): self
    {
        $this->organismeVivantCibleOuAuxiliaireTitle = $organismeVivantCibleOuAuxiliaireTitle;
        return $this;
    }

    public function getOrganismeVivantCibleOuAuxiliaireReferenceCode(): ?string
    {
        return $this->organismeVivantCibleOuAuxiliaireReferenceCode;
    }

    public function setOrganismeVivantCibleOuAuxiliaireReferenceCode(?string $organismeVivantCibleOuAuxiliaireReferenceCode): self
    {
        $this->organismeVivantCibleOuAuxiliaireReferenceCode = $organismeVivantCibleOuAuxiliaireReferenceCode;
        return $this;
    }
}
