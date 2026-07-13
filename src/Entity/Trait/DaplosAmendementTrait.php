<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Amendement;

/**
 * Trait pour les entités représentant un amendement/résidus DAPLOS.
 *
 * Usage:
 *   use DaplosAmendementTrait;
 *
 * @author Yoan Bernabeu
 */
trait DaplosAmendementTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosCodeAmendement = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosQuantite = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeUnite = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosComplementTypeAmendement = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateAmendement = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosOrigineRaisonSociale1 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosOrigineRaisonSociale2 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosOrigineAdresseRue1 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosOrigineAdresseRue2 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosOrigineVille = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosOrigineCodePostal = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosOriginePays = null;

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

    public function getDaplosCodeAmendement(): ?string
    {
        return $this->daplosCodeAmendement;
    }

    public function setDaplosCodeAmendement(?string $daplosCodeAmendement): static
    {
        $this->daplosCodeAmendement = $daplosCodeAmendement;

        return $this;
    }

    public function getDaplosQuantite(): ?string
    {
        return $this->daplosQuantite;
    }

    public function setDaplosQuantite(float|string|null $daplosQuantite): static
    {
        $this->daplosQuantite = null !== $daplosQuantite ? (string) $daplosQuantite : null;

        return $this;
    }

    public function getDaplosCodeUnite(): ?string
    {
        return $this->daplosCodeUnite;
    }

    public function setDaplosCodeUnite(?string $daplosCodeUnite): static
    {
        $this->daplosCodeUnite = $daplosCodeUnite;

        return $this;
    }

    public function getDaplosComplementTypeAmendement(): ?string
    {
        return $this->daplosComplementTypeAmendement;
    }

    public function setDaplosComplementTypeAmendement(?string $daplosComplementTypeAmendement): static
    {
        $this->daplosComplementTypeAmendement = $daplosComplementTypeAmendement;

        return $this;
    }

    public function getDaplosDateAmendement(): ?\DateTimeImmutable
    {
        return $this->daplosDateAmendement;
    }

    public function setDaplosDateAmendement(?\DateTimeImmutable $daplosDateAmendement): static
    {
        $this->daplosDateAmendement = $daplosDateAmendement;

        return $this;
    }

    public function getDaplosOrigineRaisonSociale1(): ?string
    {
        return $this->daplosOrigineRaisonSociale1;
    }

    public function setDaplosOrigineRaisonSociale1(?string $daplosOrigineRaisonSociale1): static
    {
        $this->daplosOrigineRaisonSociale1 = $daplosOrigineRaisonSociale1;

        return $this;
    }

    public function getDaplosOrigineRaisonSociale2(): ?string
    {
        return $this->daplosOrigineRaisonSociale2;
    }

    public function setDaplosOrigineRaisonSociale2(?string $daplosOrigineRaisonSociale2): static
    {
        $this->daplosOrigineRaisonSociale2 = $daplosOrigineRaisonSociale2;

        return $this;
    }

    public function getDaplosOrigineAdresseRue1(): ?string
    {
        return $this->daplosOrigineAdresseRue1;
    }

    public function setDaplosOrigineAdresseRue1(?string $daplosOrigineAdresseRue1): static
    {
        $this->daplosOrigineAdresseRue1 = $daplosOrigineAdresseRue1;

        return $this;
    }

    public function getDaplosOrigineAdresseRue2(): ?string
    {
        return $this->daplosOrigineAdresseRue2;
    }

    public function setDaplosOrigineAdresseRue2(?string $daplosOrigineAdresseRue2): static
    {
        $this->daplosOrigineAdresseRue2 = $daplosOrigineAdresseRue2;

        return $this;
    }

    public function getDaplosOrigineVille(): ?string
    {
        return $this->daplosOrigineVille;
    }

    public function setDaplosOrigineVille(?string $daplosOrigineVille): static
    {
        $this->daplosOrigineVille = $daplosOrigineVille;

        return $this;
    }

    public function getDaplosOrigineCodePostal(): ?string
    {
        return $this->daplosOrigineCodePostal;
    }

    public function setDaplosOrigineCodePostal(?string $daplosOrigineCodePostal): static
    {
        $this->daplosOrigineCodePostal = $daplosOrigineCodePostal;

        return $this;
    }

    public function getDaplosOriginePays(): ?string
    {
        return $this->daplosOriginePays;
    }

    public function setDaplosOriginePays(?string $daplosOriginePays): static
    {
        $this->daplosOriginePays = $daplosOriginePays;

        return $this;
    }

    /**
     * Hydrate l'entité depuis un DTO Amendement.
     */
    public function hydrateFromDaplosAmendement(Amendement $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosCodeAmendement = $dto->codeAmendement;
        $this->daplosQuantite = null !== $dto->quantite ? (string) $dto->quantite : null;
        $this->daplosCodeUnite = $dto->codeUnite;
        $this->daplosComplementTypeAmendement = $dto->complementTypeAmendement;
        $this->daplosDateAmendement = $dto->dateAmendement;
        $this->daplosOrigineRaisonSociale1 = $dto->origineRaisonSociale1;
        $this->daplosOrigineRaisonSociale2 = $dto->origineRaisonSociale2;
        $this->daplosOrigineAdresseRue1 = $dto->origineAdresseRue1;
        $this->daplosOrigineAdresseRue2 = $dto->origineAdresseRue2;
        $this->daplosOrigineVille = $dto->origineVille;
        $this->daplosOrigineCodePostal = $dto->origineCodePostal;
        $this->daplosOriginePays = $dto->originePays;

        return $this;
    }
}
