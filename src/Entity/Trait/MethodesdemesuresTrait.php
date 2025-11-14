<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Méthodes de mesures".
 *
 * Repository Code: List_MeasurementMethodCode_CodeType
 * Référentiel ID: 621
 * Nombre d'items: 8
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait MethodesdemesuresTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $methodesdemesuresId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $methodesdemesuresTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $methodesdemesuresReferenceCode = null;

    public function getMethodesdemesuresId(): ?int
    {
        return $this->methodesdemesuresId;
    }

    public function setMethodesdemesuresId(?int $methodesdemesuresId): self
    {
        $this->methodesdemesuresId = $methodesdemesuresId;

        return $this;
    }

    public function getMethodesdemesuresTitle(): ?string
    {
        return $this->methodesdemesuresTitle;
    }

    public function setMethodesdemesuresTitle(?string $methodesdemesuresTitle): self
    {
        $this->methodesdemesuresTitle = $methodesdemesuresTitle;

        return $this;
    }

    public function getMethodesdemesuresReferenceCode(): ?string
    {
        return $this->methodesdemesuresReferenceCode;
    }

    public function setMethodesdemesuresReferenceCode(?string $methodesdemesuresReferenceCode): self
    {
        $this->methodesdemesuresReferenceCode = $methodesdemesuresReferenceCode;

        return $this;
    }
}
