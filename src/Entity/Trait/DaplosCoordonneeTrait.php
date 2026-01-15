<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Coordonnee;

/**
 * Trait pour les entités représentant une coordonnée DAPLOS.
 *
 * Usage:
 *   use DaplosCoordonneeTrait;
 *
 * @author Yoan Bernabeu
 */
trait DaplosCoordonneeTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosSystemeCoordonnees = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 8, nullable: true)]
    private ?float $daplosX = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 8, nullable: true)]
    private ?float $daplosY = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $daplosRefIntervention = null;

    public function getDaplosIdentifiantParcelle(): ?string
    {
        return $this->daplosIdentifiantParcelle;
    }

    public function setDaplosIdentifiantParcelle(?string $daplosIdentifiantParcelle): static
    {
        $this->daplosIdentifiantParcelle = $daplosIdentifiantParcelle;

        return $this;
    }

    public function getDaplosAnnee(): ?int
    {
        return $this->daplosAnnee;
    }

    public function setDaplosAnnee(?int $daplosAnnee): static
    {
        $this->daplosAnnee = $daplosAnnee;

        return $this;
    }

    public function getDaplosSystemeCoordonnees(): ?string
    {
        return $this->daplosSystemeCoordonnees;
    }

    public function setDaplosSystemeCoordonnees(?string $daplosSystemeCoordonnees): static
    {
        $this->daplosSystemeCoordonnees = $daplosSystemeCoordonnees;

        return $this;
    }

    public function getDaplosX(): ?float
    {
        return $this->daplosX;
    }

    public function setDaplosX(?float $daplosX): static
    {
        $this->daplosX = $daplosX;

        return $this;
    }

    public function getDaplosY(): ?float
    {
        return $this->daplosY;
    }

    public function setDaplosY(?float $daplosY): static
    {
        $this->daplosY = $daplosY;

        return $this;
    }

    public function getDaplosRefIntervention(): ?string
    {
        return $this->daplosRefIntervention;
    }

    public function setDaplosRefIntervention(?string $daplosRefIntervention): static
    {
        $this->daplosRefIntervention = $daplosRefIntervention;

        return $this;
    }

    /**
     * Hydrate l'entité depuis un DTO Coordonnee.
     */
    public function hydrateFromDaplosCoordonnee(Coordonnee $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosSystemeCoordonnees = $dto->systemeCoordonnees;
        $this->daplosX = $dto->x;
        $this->daplosY = $dto->y;
        $this->daplosRefIntervention = $dto->refIntervention;

        return $this;
    }
}
