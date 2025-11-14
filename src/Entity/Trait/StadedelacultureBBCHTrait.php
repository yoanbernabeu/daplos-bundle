<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Stade de la culture (BBCH)".
 *
 * Repository Code: List_CropStage_CodeType
 * Référentiel ID: 597
 * Nombre d'items: 3769
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait StadedelacultureBBCHTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $stadedelacultureBBCHId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $stadedelacultureBBCHTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $stadedelacultureBBCHReferenceCode = null;

    public function getStadedelacultureBBCHId(): ?int
    {
        return $this->stadedelacultureBBCHId;
    }

    public function setStadedelacultureBBCHId(?int $stadedelacultureBBCHId): self
    {
        $this->stadedelacultureBBCHId = $stadedelacultureBBCHId;

        return $this;
    }

    public function getStadedelacultureBBCHTitle(): ?string
    {
        return $this->stadedelacultureBBCHTitle;
    }

    public function setStadedelacultureBBCHTitle(?string $stadedelacultureBBCHTitle): self
    {
        $this->stadedelacultureBBCHTitle = $stadedelacultureBBCHTitle;

        return $this;
    }

    public function getStadedelacultureBBCHReferenceCode(): ?string
    {
        return $this->stadedelacultureBBCHReferenceCode;
    }

    public function setStadedelacultureBBCHReferenceCode(?string $stadedelacultureBBCHReferenceCode): self
    {
        $this->stadedelacultureBBCHReferenceCode = $stadedelacultureBBCHReferenceCode;

        return $this;
    }
}
