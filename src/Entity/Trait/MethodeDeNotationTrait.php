<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Méthode de notation".
 *
 * Repository Code: List_NotationMethodology_CodeType
 * Référentiel ID: 663
 * Nombre d'items: 4
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété methodeDeNotationId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $methodeDeNotationId = null;
 */
trait MethodeDeNotationTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $methodeDeNotationId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $methodeDeNotationTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $methodeDeNotationReferenceCode = null;

    public function getMethodeDeNotationId(): ?int
    {
        return $this->methodeDeNotationId;
    }

    public function setMethodeDeNotationId(?int $methodeDeNotationId): self
    {
        $this->methodeDeNotationId = $methodeDeNotationId;

        return $this;
    }

    public function getMethodeDeNotationTitle(): ?string
    {
        return $this->methodeDeNotationTitle;
    }

    public function setMethodeDeNotationTitle(?string $methodeDeNotationTitle): self
    {
        $this->methodeDeNotationTitle = $methodeDeNotationTitle;

        return $this;
    }

    public function getMethodeDeNotationReferenceCode(): ?string
    {
        return $this->methodeDeNotationReferenceCode;
    }

    public function setMethodeDeNotationReferenceCode(?string $methodeDeNotationReferenceCode): self
    {
        $this->methodeDeNotationReferenceCode = $methodeDeNotationReferenceCode;

        return $this;
    }
}
