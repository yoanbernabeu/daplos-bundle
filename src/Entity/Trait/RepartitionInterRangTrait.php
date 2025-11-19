<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Répartition inter rang".
 *
 * Repository Code: rep50
 * Référentiel ID: 655
 * Nombre d'items: 4
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété repartitionInterRangId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $repartitionInterRangId = null;
 */
trait RepartitionInterRangTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $repartitionInterRangId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $repartitionInterRangTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $repartitionInterRangReferenceCode = null;

    public function getRepartitionInterRangId(): ?int
    {
        return $this->repartitionInterRangId;
    }

    public function setRepartitionInterRangId(?int $repartitionInterRangId): self
    {
        $this->repartitionInterRangId = $repartitionInterRangId;

        return $this;
    }

    public function getRepartitionInterRangTitle(): ?string
    {
        return $this->repartitionInterRangTitle;
    }

    public function setRepartitionInterRangTitle(?string $repartitionInterRangTitle): self
    {
        $this->repartitionInterRangTitle = $repartitionInterRangTitle;

        return $this;
    }

    public function getRepartitionInterRangReferenceCode(): ?string
    {
        return $this->repartitionInterRangReferenceCode;
    }

    public function setRepartitionInterRangReferenceCode(?string $repartitionInterRangReferenceCode): self
    {
        $this->repartitionInterRangReferenceCode = $repartitionInterRangReferenceCode;

        return $this;
    }
}
