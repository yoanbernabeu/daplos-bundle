<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Type de message".
 *
 * Repository Code: List_Message_CodeType
 * Référentiel ID: 689
 * Nombre d'items: 6
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété typeDeMessageId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $typeDeMessageId = null;
 */
trait TypeDeMessageTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $typeDeMessageId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typeDeMessageTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $typeDeMessageReferenceCode = null;

    public function getTypeDeMessageId(): ?int
    {
        return $this->typeDeMessageId;
    }

    public function setTypeDeMessageId(?int $typeDeMessageId): self
    {
        $this->typeDeMessageId = $typeDeMessageId;

        return $this;
    }

    public function getTypeDeMessageTitle(): ?string
    {
        return $this->typeDeMessageTitle;
    }

    public function setTypeDeMessageTitle(?string $typeDeMessageTitle): self
    {
        $this->typeDeMessageTitle = $typeDeMessageTitle;

        return $this;
    }

    public function getTypeDeMessageReferenceCode(): ?string
    {
        return $this->typeDeMessageReferenceCode;
    }

    public function setTypeDeMessageReferenceCode(?string $typeDeMessageReferenceCode): self
    {
        $this->typeDeMessageReferenceCode = $typeDeMessageReferenceCode;

        return $this;
    }
}
