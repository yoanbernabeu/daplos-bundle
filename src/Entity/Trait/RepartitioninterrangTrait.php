<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Répartition inter rang"
 *
 * Repository Code: rep50
 * Référentiel ID: 655
 * Nombre d'items: 4
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait RepartitioninterrangTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $repartitioninterrangId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $repartitioninterrangTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $repartitioninterrangReferenceCode = null;

    public function getRepartitioninterrangId(): ?int
    {
        return $this->repartitioninterrangId;
    }

    public function setRepartitioninterrangId(?int $repartitioninterrangId): self
    {
        $this->repartitioninterrangId = $repartitioninterrangId;
        return $this;
    }

    public function getRepartitioninterrangTitle(): ?string
    {
        return $this->repartitioninterrangTitle;
    }

    public function setRepartitioninterrangTitle(?string $repartitioninterrangTitle): self
    {
        $this->repartitioninterrangTitle = $repartitioninterrangTitle;
        return $this;
    }

    public function getRepartitioninterrangReferenceCode(): ?string
    {
        return $this->repartitioninterrangReferenceCode;
    }

    public function setRepartitioninterrangReferenceCode(?string $repartitioninterrangReferenceCode): self
    {
        $this->repartitioninterrangReferenceCode = $repartitioninterrangReferenceCode;
        return $this;
    }
}
