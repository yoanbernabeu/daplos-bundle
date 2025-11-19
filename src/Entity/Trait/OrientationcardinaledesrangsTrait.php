<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Orientation cardinale des rangs".
 *
 * Repository Code: rep47
 * Référentiel ID: 649
 * Nombre d'items: 8
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 *
 * Pour utiliser ce trait avec le mapping automatique, ajoutez l'attribut #[DaplosId]
 * sur la propriété orientationCardinaleDesRangsId :
 *
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * #[DaplosId]
 * private ?int $orientationCardinaleDesRangsId = null;
 */
trait OrientationCardinaleDesRangsTrait
{
    #[DaplosId]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $orientationCardinaleDesRangsId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $orientationCardinaleDesRangsTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $orientationCardinaleDesRangsReferenceCode = null;

    public function getOrientationCardinaleDesRangsId(): ?int
    {
        return $this->orientationCardinaleDesRangsId;
    }

    public function setOrientationCardinaleDesRangsId(?int $orientationCardinaleDesRangsId): self
    {
        $this->orientationCardinaleDesRangsId = $orientationCardinaleDesRangsId;

        return $this;
    }

    public function getOrientationCardinaleDesRangsTitle(): ?string
    {
        return $this->orientationCardinaleDesRangsTitle;
    }

    public function setOrientationCardinaleDesRangsTitle(?string $orientationCardinaleDesRangsTitle): self
    {
        $this->orientationCardinaleDesRangsTitle = $orientationCardinaleDesRangsTitle;

        return $this;
    }

    public function getOrientationCardinaleDesRangsReferenceCode(): ?string
    {
        return $this->orientationCardinaleDesRangsReferenceCode;
    }

    public function setOrientationCardinaleDesRangsReferenceCode(?string $orientationCardinaleDesRangsReferenceCode): self
    {
        $this->orientationCardinaleDesRangsReferenceCode = $orientationCardinaleDesRangsReferenceCode;

        return $this;
    }
}
