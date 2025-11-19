<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Symptôme et dégât".
 *
 * Repository Code: List_SymptomDamageObserved_CodeType
 * Référentiel ID: 669
 * Nombre d'items: 179
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété symptomeEtDegatId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $symptomeEtDegatId = null;
 */
trait SymptomeEtDegatTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $symptomeEtDegatId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $symptomeEtDegatTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $symptomeEtDegatReferenceCode = null;

    public function getSymptomeEtDegatId(): ?int
    {
        return $this->symptomeEtDegatId;
    }

    public function setSymptomeEtDegatId(?int $symptomeEtDegatId): self
    {
        $this->symptomeEtDegatId = $symptomeEtDegatId;

        return $this;
    }

    public function getSymptomeEtDegatTitle(): ?string
    {
        return $this->symptomeEtDegatTitle;
    }

    public function setSymptomeEtDegatTitle(?string $symptomeEtDegatTitle): self
    {
        $this->symptomeEtDegatTitle = $symptomeEtDegatTitle;

        return $this;
    }

    public function getSymptomeEtDegatReferenceCode(): ?string
    {
        return $this->symptomeEtDegatReferenceCode;
    }

    public function setSymptomeEtDegatReferenceCode(?string $symptomeEtDegatReferenceCode): self
    {
        $this->symptomeEtDegatReferenceCode = $symptomeEtDegatReferenceCode;

        return $this;
    }
}
