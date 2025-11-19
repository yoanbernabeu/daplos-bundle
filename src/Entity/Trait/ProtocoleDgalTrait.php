<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Protocole DGAL".
 *
 * Repository Code: List_ProtocoleFormTemplate_CodeType
 * Référentiel ID: 683
 * Nombre d'items: 2
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété protocoleDgalId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $protocoleDgalId = null;
 */
trait ProtocoleDgalTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $protocoleDgalId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $protocoleDgalTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $protocoleDgalReferenceCode = null;

    public function getProtocoleDgalId(): ?int
    {
        return $this->protocoleDgalId;
    }

    public function setProtocoleDgalId(?int $protocoleDgalId): self
    {
        $this->protocoleDgalId = $protocoleDgalId;

        return $this;
    }

    public function getProtocoleDgalTitle(): ?string
    {
        return $this->protocoleDgalTitle;
    }

    public function setProtocoleDgalTitle(?string $protocoleDgalTitle): self
    {
        $this->protocoleDgalTitle = $protocoleDgalTitle;

        return $this;
    }

    public function getProtocoleDgalReferenceCode(): ?string
    {
        return $this->protocoleDgalReferenceCode;
    }

    public function setProtocoleDgalReferenceCode(?string $protocoleDgalReferenceCode): self
    {
        $this->protocoleDgalReferenceCode = $protocoleDgalReferenceCode;

        return $this;
    }
}
