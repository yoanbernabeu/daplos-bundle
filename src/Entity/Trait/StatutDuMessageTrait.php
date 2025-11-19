<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Statut du message"
 *
 * Repository Code: List_StatusCodeType
 * Référentiel ID: 679
 * Nombre d'items: 3
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 * 
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété statutDuMessageId :
 * 
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 * 
 * #[DaplosId]
 * private ?int $statutDuMessageId = null;
 */
trait StatutDuMessageTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $statutDuMessageId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $statutDuMessageTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $statutDuMessageReferenceCode = null;

    public function getStatutDuMessageId(): ?int
    {
        return $this->statutDuMessageId;
    }

    public function setStatutDuMessageId(?int $statutDuMessageId): self
    {
        $this->statutDuMessageId = $statutDuMessageId;
        return $this;
    }

    public function getStatutDuMessageTitle(): ?string
    {
        return $this->statutDuMessageTitle;
    }

    public function setStatutDuMessageTitle(?string $statutDuMessageTitle): self
    {
        $this->statutDuMessageTitle = $statutDuMessageTitle;
        return $this;
    }

    public function getStatutDuMessageReferenceCode(): ?string
    {
        return $this->statutDuMessageReferenceCode;
    }

    public function setStatutDuMessageReferenceCode(?string $statutDuMessageReferenceCode): self
    {
        $this->statutDuMessageReferenceCode = $statutDuMessageReferenceCode;
        return $this;
    }
}
