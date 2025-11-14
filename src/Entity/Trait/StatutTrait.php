<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Statut"
 *
 * Repository Code: List_StatusCodeType
 * Référentiel ID: 679
 * Nombre d'items: 3
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait StatutTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $statutId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $statutTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $statutReferenceCode = null;

    public function getStatutId(): ?int
    {
        return $this->statutId;
    }

    public function setStatutId(?int $statutId): self
    {
        $this->statutId = $statutId;
        return $this;
    }

    public function getStatutTitle(): ?string
    {
        return $this->statutTitle;
    }

    public function setStatutTitle(?string $statutTitle): self
    {
        $this->statutTitle = $statutTitle;
        return $this;
    }

    public function getStatutReferenceCode(): ?string
    {
        return $this->statutReferenceCode;
    }

    public function setStatutReferenceCode(?string $statutReferenceCode): self
    {
        $this->statutReferenceCode = $statutReferenceCode;
        return $this;
    }
}
