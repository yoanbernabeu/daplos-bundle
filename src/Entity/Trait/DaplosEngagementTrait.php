<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Engagement;

/**
 * Trait pour les entités représentant un engagement DAPLOS.
 *
 * Usage:
 *   use DaplosEngagementTrait;
 *
 * @author Yoan Bernabeu
 */
trait DaplosEngagementTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosLibelle = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosCodeEngagement = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateDebut = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateFin = null;

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

    public function getDaplosLibelle(): ?string
    {
        return $this->daplosLibelle;
    }

    public function setDaplosLibelle(?string $daplosLibelle): static
    {
        $this->daplosLibelle = $daplosLibelle;

        return $this;
    }

    public function getDaplosCodeEngagement(): ?string
    {
        return $this->daplosCodeEngagement;
    }

    public function setDaplosCodeEngagement(?string $daplosCodeEngagement): static
    {
        $this->daplosCodeEngagement = $daplosCodeEngagement;

        return $this;
    }

    public function getDaplosDateDebut(): ?\DateTimeImmutable
    {
        return $this->daplosDateDebut;
    }

    public function setDaplosDateDebut(?\DateTimeImmutable $daplosDateDebut): static
    {
        $this->daplosDateDebut = $daplosDateDebut;

        return $this;
    }

    public function getDaplosDateFin(): ?\DateTimeImmutable
    {
        return $this->daplosDateFin;
    }

    public function setDaplosDateFin(?\DateTimeImmutable $daplosDateFin): static
    {
        $this->daplosDateFin = $daplosDateFin;

        return $this;
    }

    /**
     * Hydrate l'entité depuis un DTO Engagement.
     */
    public function hydrateFromDaplosEngagement(Engagement $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosLibelle = $dto->libelle;
        $this->daplosCodeEngagement = $dto->codeEngagement;
        $this->daplosDateDebut = $dto->dateDebut;
        $this->daplosDateFin = $dto->dateFin;

        return $this;
    }
}
