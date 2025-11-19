<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Destination d'une culture".
 *
 * Repository Code: List_PurposeCode_CodeType
 * Référentiel ID: 627
 * Nombre d'items: 50
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété destinationDUneCultureId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $destinationDUneCultureId = null;
 */
trait DestinationDUneCultureTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $destinationDUneCultureId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $destinationDUneCultureTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $destinationDUneCultureReferenceCode = null;

    public function getDestinationDUneCultureId(): ?int
    {
        return $this->destinationDUneCultureId;
    }

    public function setDestinationDUneCultureId(?int $destinationDUneCultureId): self
    {
        $this->destinationDUneCultureId = $destinationDUneCultureId;

        return $this;
    }

    public function getDestinationDUneCultureTitle(): ?string
    {
        return $this->destinationDUneCultureTitle;
    }

    public function setDestinationDUneCultureTitle(?string $destinationDUneCultureTitle): self
    {
        $this->destinationDUneCultureTitle = $destinationDUneCultureTitle;

        return $this;
    }

    public function getDestinationDUneCultureReferenceCode(): ?string
    {
        return $this->destinationDUneCultureReferenceCode;
    }

    public function setDestinationDUneCultureReferenceCode(?string $destinationDUneCultureReferenceCode): self
    {
        $this->destinationDUneCultureReferenceCode = $destinationDUneCultureReferenceCode;

        return $this;
    }
}
