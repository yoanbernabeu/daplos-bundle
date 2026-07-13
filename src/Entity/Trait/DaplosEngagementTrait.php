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

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosNumeroContrat = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateContrat = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosIdentificationContractant = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosTypeIdentificationContractant = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosContractantRaisonSociale1 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosContractantRaisonSociale2 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosContractantAdresseRue1 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosContractantAdresseRue2 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosContractantVille = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosContractantCodePostal = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosContractantPays = null;

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

    public function getDaplosNumeroContrat(): ?string
    {
        return $this->daplosNumeroContrat;
    }

    public function setDaplosNumeroContrat(?string $daplosNumeroContrat): static
    {
        $this->daplosNumeroContrat = $daplosNumeroContrat;

        return $this;
    }

    public function getDaplosDateContrat(): ?\DateTimeImmutable
    {
        return $this->daplosDateContrat;
    }

    public function setDaplosDateContrat(?\DateTimeImmutable $daplosDateContrat): static
    {
        $this->daplosDateContrat = $daplosDateContrat;

        return $this;
    }

    public function getDaplosIdentificationContractant(): ?string
    {
        return $this->daplosIdentificationContractant;
    }

    public function setDaplosIdentificationContractant(?string $daplosIdentificationContractant): static
    {
        $this->daplosIdentificationContractant = $daplosIdentificationContractant;

        return $this;
    }

    public function getDaplosTypeIdentificationContractant(): ?string
    {
        return $this->daplosTypeIdentificationContractant;
    }

    public function setDaplosTypeIdentificationContractant(?string $daplosTypeIdentificationContractant): static
    {
        $this->daplosTypeIdentificationContractant = $daplosTypeIdentificationContractant;

        return $this;
    }

    public function getDaplosContractantRaisonSociale1(): ?string
    {
        return $this->daplosContractantRaisonSociale1;
    }

    public function setDaplosContractantRaisonSociale1(?string $daplosContractantRaisonSociale1): static
    {
        $this->daplosContractantRaisonSociale1 = $daplosContractantRaisonSociale1;

        return $this;
    }

    public function getDaplosContractantRaisonSociale2(): ?string
    {
        return $this->daplosContractantRaisonSociale2;
    }

    public function setDaplosContractantRaisonSociale2(?string $daplosContractantRaisonSociale2): static
    {
        $this->daplosContractantRaisonSociale2 = $daplosContractantRaisonSociale2;

        return $this;
    }

    public function getDaplosContractantAdresseRue1(): ?string
    {
        return $this->daplosContractantAdresseRue1;
    }

    public function setDaplosContractantAdresseRue1(?string $daplosContractantAdresseRue1): static
    {
        $this->daplosContractantAdresseRue1 = $daplosContractantAdresseRue1;

        return $this;
    }

    public function getDaplosContractantAdresseRue2(): ?string
    {
        return $this->daplosContractantAdresseRue2;
    }

    public function setDaplosContractantAdresseRue2(?string $daplosContractantAdresseRue2): static
    {
        $this->daplosContractantAdresseRue2 = $daplosContractantAdresseRue2;

        return $this;
    }

    public function getDaplosContractantVille(): ?string
    {
        return $this->daplosContractantVille;
    }

    public function setDaplosContractantVille(?string $daplosContractantVille): static
    {
        $this->daplosContractantVille = $daplosContractantVille;

        return $this;
    }

    public function getDaplosContractantCodePostal(): ?string
    {
        return $this->daplosContractantCodePostal;
    }

    public function setDaplosContractantCodePostal(?string $daplosContractantCodePostal): static
    {
        $this->daplosContractantCodePostal = $daplosContractantCodePostal;

        return $this;
    }

    public function getDaplosContractantPays(): ?string
    {
        return $this->daplosContractantPays;
    }

    public function setDaplosContractantPays(?string $daplosContractantPays): static
    {
        $this->daplosContractantPays = $daplosContractantPays;

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
        $this->daplosNumeroContrat = $dto->numeroContrat;
        $this->daplosDateContrat = $dto->dateContrat;
        $this->daplosIdentificationContractant = $dto->identificationContractant;
        $this->daplosTypeIdentificationContractant = $dto->typeIdentificationContractant;
        $this->daplosContractantRaisonSociale1 = $dto->contractantRaisonSociale1;
        $this->daplosContractantRaisonSociale2 = $dto->contractantRaisonSociale2;
        $this->daplosContractantAdresseRue1 = $dto->contractantAdresseRue1;
        $this->daplosContractantAdresseRue2 = $dto->contractantAdresseRue2;
        $this->daplosContractantVille = $dto->contractantVille;
        $this->daplosContractantCodePostal = $dto->contractantCodePostal;
        $this->daplosContractantPays = $dto->contractantPays;

        return $this;
    }
}
