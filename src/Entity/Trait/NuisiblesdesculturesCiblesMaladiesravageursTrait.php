<?php

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait pour le référentiel "Nuisibles des cultures - Cibles (maladies/ravageurs)".
 *
 * Repository Code: List_PestName_CodeType
 * Référentiel ID: 615
 * Nombre d'items: 2424
 *
 * Ce trait permet d'associer une entité avec les données du référentiel DAPLOS.
 */
trait NuisiblesdesculturesCiblesMaladiesravageursTrait
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $nuisiblesdesculturesCiblesMaladiesravageursId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $nuisiblesdesculturesCiblesMaladiesravageursTitle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $nuisiblesdesculturesCiblesMaladiesravageursReferenceCode = null;

    public function getNuisiblesdesculturesCiblesMaladiesravageursId(): ?int
    {
        return $this->nuisiblesdesculturesCiblesMaladiesravageursId;
    }

    public function setNuisiblesdesculturesCiblesMaladiesravageursId(?int $nuisiblesdesculturesCiblesMaladiesravageursId): self
    {
        $this->nuisiblesdesculturesCiblesMaladiesravageursId = $nuisiblesdesculturesCiblesMaladiesravageursId;

        return $this;
    }

    public function getNuisiblesdesculturesCiblesMaladiesravageursTitle(): ?string
    {
        return $this->nuisiblesdesculturesCiblesMaladiesravageursTitle;
    }

    public function setNuisiblesdesculturesCiblesMaladiesravageursTitle(?string $nuisiblesdesculturesCiblesMaladiesravageursTitle): self
    {
        $this->nuisiblesdesculturesCiblesMaladiesravageursTitle = $nuisiblesdesculturesCiblesMaladiesravageursTitle;

        return $this;
    }

    public function getNuisiblesdesculturesCiblesMaladiesravageursReferenceCode(): ?string
    {
        return $this->nuisiblesdesculturesCiblesMaladiesravageursReferenceCode;
    }

    public function setNuisiblesdesculturesCiblesMaladiesravageursReferenceCode(?string $nuisiblesdesculturesCiblesMaladiesravageursReferenceCode): self
    {
        $this->nuisiblesdesculturesCiblesMaladiesravageursReferenceCode = $nuisiblesdesculturesCiblesMaladiesravageursReferenceCode;

        return $this;
    }
}
