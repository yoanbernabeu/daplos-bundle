<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Type de protocoles d'observations".
 *
 * Repository Code: List_ProtocoleFormTemplate_CodeType
 * Référentiel ID: 683
 * Nombre d'items: 2
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait TypedeprotocolesdobservationsTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $typedeprotocolesdobservationsId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $typedeprotocolesdobservationsTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $typedeprotocolesdobservationsReferenceCode = null;

    public function getTypedeprotocolesdobservationsId(): ?int
    {
        return $this->typedeprotocolesdobservationsId;
    }

    public function setTypedeprotocolesdobservationsId(?int $typedeprotocolesdobservationsId): self
    {
        $this->typedeprotocolesdobservationsId = $typedeprotocolesdobservationsId;

        return $this;
    }

    public function getTypedeprotocolesdobservationsTitle(): ?string
    {
        return $this->typedeprotocolesdobservationsTitle;
    }

    public function setTypedeprotocolesdobservationsTitle(?string $typedeprotocolesdobservationsTitle): self
    {
        $this->typedeprotocolesdobservationsTitle = $typedeprotocolesdobservationsTitle;

        return $this;
    }

    public function getTypedeprotocolesdobservationsReferenceCode(): ?string
    {
        return $this->typedeprotocolesdobservationsReferenceCode;
    }

    public function setTypedeprotocolesdobservationsReferenceCode(?string $typedeprotocolesdobservationsReferenceCode): self
    {
        $this->typedeprotocolesdobservationsReferenceCode = $typedeprotocolesdobservationsReferenceCode;

        return $this;
    }
}
