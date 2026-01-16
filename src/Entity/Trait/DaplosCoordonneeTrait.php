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
    private ?string $daplosX = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 8, nullable: true)]
    private ?string $daplosY = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $daplosRefIntervention = null;

    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosNumeroParcelleCadastrale = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $daplosAltitude = null;

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

    public function getDaplosX(): ?string
    {
        return $this->daplosX;
    }

    public function setDaplosX(float|string|null $daplosX): static
    {
        $this->daplosX = null !== $daplosX ? (string) $daplosX : null;

        return $this;
    }

    public function getDaplosY(): ?string
    {
        return $this->daplosY;
    }

    public function setDaplosY(float|string|null $daplosY): static
    {
        $this->daplosY = null !== $daplosY ? (string) $daplosY : null;

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

    public function getDaplosNumeroParcelleCadastrale(): ?string
    {
        return $this->daplosNumeroParcelleCadastrale;
    }

    public function setDaplosNumeroParcelleCadastrale(?string $daplosNumeroParcelleCadastrale): static
    {
        $this->daplosNumeroParcelleCadastrale = $daplosNumeroParcelleCadastrale;

        return $this;
    }

    public function getDaplosAltitude(): ?string
    {
        return $this->daplosAltitude;
    }

    public function setDaplosAltitude(float|string|null $daplosAltitude): static
    {
        $this->daplosAltitude = null !== $daplosAltitude ? (string) $daplosAltitude : null;

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
        $this->daplosX = null !== $dto->x ? (string) $dto->x : null;
        $this->daplosY = null !== $dto->y ? (string) $dto->y : null;
        $this->daplosRefIntervention = $dto->refIntervention;
        $this->daplosNumeroParcelleCadastrale = $dto->numeroParcelleCadastrale;
        $this->daplosAltitude = null !== $dto->altitude ? (string) $dto->altitude : null;

        return $this;
    }
}
