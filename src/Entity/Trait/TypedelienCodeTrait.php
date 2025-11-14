<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Type de lien (code)".
 *
 * Repository Code: List_linktype_CodeType
 * Référentiel ID: 895
 * Nombre d'items: 3
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait TypedelienCodeTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $typedelienCodeId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typedelienCodeTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $typedelienCodeReferenceCode = null;

    public function getTypedelienCodeId(): ?int
    {
        return $this->typedelienCodeId;
    }

    public function setTypedelienCodeId(?int $typedelienCodeId): self
    {
        $this->typedelienCodeId = $typedelienCodeId;

        return $this;
    }

    public function getTypedelienCodeTitle(): ?string
    {
        return $this->typedelienCodeTitle;
    }

    public function setTypedelienCodeTitle(?string $typedelienCodeTitle): self
    {
        $this->typedelienCodeTitle = $typedelienCodeTitle;

        return $this;
    }

    public function getTypedelienCodeReferenceCode(): ?string
    {
        return $this->typedelienCodeReferenceCode;
    }

    public function setTypedelienCodeReferenceCode(?string $typedelienCodeReferenceCode): self
    {
        $this->typedelienCodeReferenceCode = $typedelienCodeReferenceCode;

        return $this;
    }
}
