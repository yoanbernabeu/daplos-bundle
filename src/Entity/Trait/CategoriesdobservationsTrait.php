<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Catégories d'observations"
 *
 * Repository Code: List_PestType_CodeType
 * Référentiel ID: 675
 * Nombre d'items: 8
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait CategoriesdobservationsTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $categoriesdobservationsId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $categoriesdobservationsTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $categoriesdobservationsReferenceCode = null;

    public function getCategoriesdobservationsId(): ?int
    {
        return $this->categoriesdobservationsId;
    }

    public function setCategoriesdobservationsId(?int $categoriesdobservationsId): self
    {
        $this->categoriesdobservationsId = $categoriesdobservationsId;
        return $this;
    }

    public function getCategoriesdobservationsTitle(): ?string
    {
        return $this->categoriesdobservationsTitle;
    }

    public function setCategoriesdobservationsTitle(?string $categoriesdobservationsTitle): self
    {
        $this->categoriesdobservationsTitle = $categoriesdobservationsTitle;
        return $this;
    }

    public function getCategoriesdobservationsReferenceCode(): ?string
    {
        return $this->categoriesdobservationsReferenceCode;
    }

    public function setCategoriesdobservationsReferenceCode(?string $categoriesdobservationsReferenceCode): self
    {
        $this->categoriesdobservationsReferenceCode = $categoriesdobservationsReferenceCode;
        return $this;
    }
}
