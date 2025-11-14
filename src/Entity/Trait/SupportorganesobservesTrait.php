<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;

/**
 * Trait pour le référentiel "Support_organes observés".
 *
 * Repository Code: List_AgroObsBasisType_CodeType
 * Référentiel ID: 661
 * Nombre d'items: 114
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait SupportorganesobservesTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    #[DaplosId]
    private ?int $supportorganesobservesId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $supportorganesobservesTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $supportorganesobservesReferenceCode = null;

    public function getSupportorganesobservesId(): ?int
    {
        return $this->supportorganesobservesId;
    }

    public function setSupportorganesobservesId(?int $supportorganesobservesId): self
    {
        $this->supportorganesobservesId = $supportorganesobservesId;

        return $this;
    }

    public function getSupportorganesobservesTitle(): ?string
    {
        return $this->supportorganesobservesTitle;
    }

    public function setSupportorganesobservesTitle(?string $supportorganesobservesTitle): self
    {
        $this->supportorganesobservesTitle = $supportorganesobservesTitle;

        return $this;
    }

    public function getSupportorganesobservesReferenceCode(): ?string
    {
        return $this->supportorganesobservesReferenceCode;
    }

    public function setSupportorganesobservesReferenceCode(?string $supportorganesobservesReferenceCode): self
    {
        $this->supportorganesobservesReferenceCode = $supportorganesobservesReferenceCode;

        return $this;
    }
}
