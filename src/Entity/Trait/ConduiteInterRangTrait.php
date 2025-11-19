<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Conduite inter rang".
 *
 * Repository Code: rep49
 * Référentiel ID: 653
 * Nombre d'items: 5
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété conduiteInterRangId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $conduiteInterRangId = null;
 */
trait ConduiteInterRangTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $conduiteInterRangId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $conduiteInterRangTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $conduiteInterRangReferenceCode = null;

    public function getConduiteInterRangId(): ?int
    {
        return $this->conduiteInterRangId;
    }

    public function setConduiteInterRangId(?int $conduiteInterRangId): self
    {
        $this->conduiteInterRangId = $conduiteInterRangId;

        return $this;
    }

    public function getConduiteInterRangTitle(): ?string
    {
        return $this->conduiteInterRangTitle;
    }

    public function setConduiteInterRangTitle(?string $conduiteInterRangTitle): self
    {
        $this->conduiteInterRangTitle = $conduiteInterRangTitle;

        return $this;
    }

    public function getConduiteInterRangReferenceCode(): ?string
    {
        return $this->conduiteInterRangReferenceCode;
    }

    public function setConduiteInterRangReferenceCode(?string $conduiteInterRangReferenceCode): self
    {
        $this->conduiteInterRangReferenceCode = $conduiteInterRangReferenceCode;

        return $this;
    }
}
