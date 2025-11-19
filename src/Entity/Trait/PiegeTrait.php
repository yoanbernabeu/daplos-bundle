<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Piège".
 *
 * Repository Code: List_TrapType_CodeType
 * Référentiel ID: 667
 * Nombre d'items: 40
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété piegeId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $piegeId = null;
 */
trait PiegeTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $piegeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $piegeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $piegeReferenceCode = null;

    public function getPiegeId(): ?int
    {
        return $this->piegeId;
    }

    public function setPiegeId(?int $piegeId): self
    {
        $this->piegeId = $piegeId;

        return $this;
    }

    public function getPiegeTitle(): ?string
    {
        return $this->piegeTitle;
    }

    public function setPiegeTitle(?string $piegeTitle): self
    {
        $this->piegeTitle = $piegeTitle;

        return $this;
    }

    public function getPiegeReferenceCode(): ?string
    {
        return $this->piegeReferenceCode;
    }

    public function setPiegeReferenceCode(?string $piegeReferenceCode): self
    {
        $this->piegeReferenceCode = $piegeReferenceCode;

        return $this;
    }
}
