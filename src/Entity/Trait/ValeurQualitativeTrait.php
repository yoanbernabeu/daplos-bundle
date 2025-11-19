<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Valeur qualitative".
 *
 * Repository Code: List_QualitativeValue_CodeType
 * Référentiel ID: 673
 * Nombre d'items: 737
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété valeurQualitativeId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $valeurQualitativeId = null;
 */
trait ValeurQualitativeTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $valeurQualitativeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $valeurQualitativeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $valeurQualitativeReferenceCode = null;

    public function getValeurQualitativeId(): ?int
    {
        return $this->valeurQualitativeId;
    }

    public function setValeurQualitativeId(?int $valeurQualitativeId): self
    {
        $this->valeurQualitativeId = $valeurQualitativeId;

        return $this;
    }

    public function getValeurQualitativeTitle(): ?string
    {
        return $this->valeurQualitativeTitle;
    }

    public function setValeurQualitativeTitle(?string $valeurQualitativeTitle): self
    {
        $this->valeurQualitativeTitle = $valeurQualitativeTitle;

        return $this;
    }

    public function getValeurQualitativeReferenceCode(): ?string
    {
        return $this->valeurQualitativeReferenceCode;
    }

    public function setValeurQualitativeReferenceCode(?string $valeurQualitativeReferenceCode): self
    {
        $this->valeurQualitativeReferenceCode = $valeurQualitativeReferenceCode;

        return $this;
    }
}
