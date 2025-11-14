<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Type de message(document) échangé"
 *
 * Repository Code: List_Message_CodeType
 * Référentiel ID: 689
 * Nombre d'items: 6
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait TypedemessageechangeDocumentTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $typedemessageechangeDocumentId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typedemessageechangeDocumentTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $typedemessageechangeDocumentReferenceCode = null;

    public function getTypedemessageechangeDocumentId(): ?int
    {
        return $this->typedemessageechangeDocumentId;
    }

    public function setTypedemessageechangeDocumentId(?int $typedemessageechangeDocumentId): self
    {
        $this->typedemessageechangeDocumentId = $typedemessageechangeDocumentId;
        return $this;
    }

    public function getTypedemessageechangeDocumentTitle(): ?string
    {
        return $this->typedemessageechangeDocumentTitle;
    }

    public function setTypedemessageechangeDocumentTitle(?string $typedemessageechangeDocumentTitle): self
    {
        $this->typedemessageechangeDocumentTitle = $typedemessageechangeDocumentTitle;
        return $this;
    }

    public function getTypedemessageechangeDocumentReferenceCode(): ?string
    {
        return $this->typedemessageechangeDocumentReferenceCode;
    }

    public function setTypedemessageechangeDocumentReferenceCode(?string $typedemessageechangeDocumentReferenceCode): self
    {
        $this->typedemessageechangeDocumentReferenceCode = $typedemessageechangeDocumentReferenceCode;
        return $this;
    }
}
