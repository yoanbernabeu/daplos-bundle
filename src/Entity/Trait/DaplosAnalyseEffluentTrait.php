<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Intrant\AnalyseEffluent;

/**
 * Trait pour les entités représentant une analyse d'effluent DAPLOS.
 *
 * Usage:
 *   use DaplosAnalyseEffluentTrait;
 *
 * @author Yoan Bernabeu
 */
trait DaplosAnalyseEffluentTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $daplosRefIntervention = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosTypeAnalyse = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeElement = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosValeur = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeUnite = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosNumeroBordereau = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosIdentificationLaboratoire = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosLaboratoireRaisonSociale1 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosLaboratoireRaisonSociale2 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosLaboratoireAdresse1 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosLaboratoireAdresse2 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosLaboratoireVille = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosLaboratoireCodePostal = null;

    #[ORM\Column(type: 'string', length: 2, nullable: true)]
    private ?string $daplosLaboratoirePays = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateAnalyse = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDatePrelevement = null;

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

    public function getDaplosRefIntervention(): ?string
    {
        return $this->daplosRefIntervention;
    }

    public function setDaplosRefIntervention(?string $daplosRefIntervention): static
    {
        $this->daplosRefIntervention = $daplosRefIntervention;

        return $this;
    }

    public function getDaplosTypeAnalyse(): ?string
    {
        return $this->daplosTypeAnalyse;
    }

    public function setDaplosTypeAnalyse(?string $daplosTypeAnalyse): static
    {
        $this->daplosTypeAnalyse = $daplosTypeAnalyse;

        return $this;
    }

    public function getDaplosCodeElement(): ?string
    {
        return $this->daplosCodeElement;
    }

    public function setDaplosCodeElement(?string $daplosCodeElement): static
    {
        $this->daplosCodeElement = $daplosCodeElement;

        return $this;
    }

    public function getDaplosValeur(): ?string
    {
        return $this->daplosValeur;
    }

    public function setDaplosValeur(float|string|null $daplosValeur): static
    {
        $this->daplosValeur = null !== $daplosValeur ? (string) $daplosValeur : null;

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

    public function getDaplosNumeroBordereau(): ?string
    {
        return $this->daplosNumeroBordereau;
    }

    public function setDaplosNumeroBordereau(?string $daplosNumeroBordereau): static
    {
        $this->daplosNumeroBordereau = $daplosNumeroBordereau;

        return $this;
    }

    public function getDaplosIdentificationLaboratoire(): ?string
    {
        return $this->daplosIdentificationLaboratoire;
    }

    public function setDaplosIdentificationLaboratoire(?string $daplosIdentificationLaboratoire): static
    {
        $this->daplosIdentificationLaboratoire = $daplosIdentificationLaboratoire;

        return $this;
    }

    public function getDaplosLaboratoireRaisonSociale1(): ?string
    {
        return $this->daplosLaboratoireRaisonSociale1;
    }

    public function setDaplosLaboratoireRaisonSociale1(?string $daplosLaboratoireRaisonSociale1): static
    {
        $this->daplosLaboratoireRaisonSociale1 = $daplosLaboratoireRaisonSociale1;

        return $this;
    }

    public function getDaplosLaboratoireRaisonSociale2(): ?string
    {
        return $this->daplosLaboratoireRaisonSociale2;
    }

    public function setDaplosLaboratoireRaisonSociale2(?string $daplosLaboratoireRaisonSociale2): static
    {
        $this->daplosLaboratoireRaisonSociale2 = $daplosLaboratoireRaisonSociale2;

        return $this;
    }

    public function getDaplosLaboratoireAdresse1(): ?string
    {
        return $this->daplosLaboratoireAdresse1;
    }

    public function setDaplosLaboratoireAdresse1(?string $daplosLaboratoireAdresse1): static
    {
        $this->daplosLaboratoireAdresse1 = $daplosLaboratoireAdresse1;

        return $this;
    }

    public function getDaplosLaboratoireAdresse2(): ?string
    {
        return $this->daplosLaboratoireAdresse2;
    }

    public function setDaplosLaboratoireAdresse2(?string $daplosLaboratoireAdresse2): static
    {
        $this->daplosLaboratoireAdresse2 = $daplosLaboratoireAdresse2;

        return $this;
    }

    public function getDaplosLaboratoireVille(): ?string
    {
        return $this->daplosLaboratoireVille;
    }

    public function setDaplosLaboratoireVille(?string $daplosLaboratoireVille): static
    {
        $this->daplosLaboratoireVille = $daplosLaboratoireVille;

        return $this;
    }

    public function getDaplosLaboratoireCodePostal(): ?string
    {
        return $this->daplosLaboratoireCodePostal;
    }

    public function setDaplosLaboratoireCodePostal(?string $daplosLaboratoireCodePostal): static
    {
        $this->daplosLaboratoireCodePostal = $daplosLaboratoireCodePostal;

        return $this;
    }

    public function getDaplosLaboratoirePays(): ?string
    {
        return $this->daplosLaboratoirePays;
    }

    public function setDaplosLaboratoirePays(?string $daplosLaboratoirePays): static
    {
        $this->daplosLaboratoirePays = $daplosLaboratoirePays;

        return $this;
    }

    public function getDaplosDateAnalyse(): ?\DateTimeImmutable
    {
        return $this->daplosDateAnalyse;
    }

    public function setDaplosDateAnalyse(?\DateTimeImmutable $daplosDateAnalyse): static
    {
        $this->daplosDateAnalyse = $daplosDateAnalyse;

        return $this;
    }

    public function getDaplosDatePrelevement(): ?\DateTimeImmutable
    {
        return $this->daplosDatePrelevement;
    }

    public function setDaplosDatePrelevement(?\DateTimeImmutable $daplosDatePrelevement): static
    {
        $this->daplosDatePrelevement = $daplosDatePrelevement;

        return $this;
    }

    /**
     * Hydrate l'entité depuis un DTO AnalyseEffluent.
     */
    public function hydrateFromDaplosAnalyseEffluent(AnalyseEffluent $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosRefIntervention = $dto->refIntervention;
        $this->daplosTypeAnalyse = $dto->typeAnalyse;
        $this->daplosCodeElement = $dto->codeElement;
        $this->daplosValeur = null !== $dto->valeur ? (string) $dto->valeur : null;
        $this->daplosCodeUnite = $dto->codeUnite;
        $this->daplosNumeroBordereau = $dto->numeroBordereau;
        $this->daplosIdentificationLaboratoire = $dto->identificationLaboratoire;
        $this->daplosLaboratoireRaisonSociale1 = $dto->laboratoireRaisonSociale1;
        $this->daplosLaboratoireRaisonSociale2 = $dto->laboratoireRaisonSociale2;
        $this->daplosLaboratoireAdresse1 = $dto->laboratoireAdresse1;
        $this->daplosLaboratoireAdresse2 = $dto->laboratoireAdresse2;
        $this->daplosLaboratoireVille = $dto->laboratoireVille;
        $this->daplosLaboratoireCodePostal = $dto->laboratoireCodePostal;
        $this->daplosLaboratoirePays = $dto->laboratoirePays;
        $this->daplosDateAnalyse = $dto->dateAnalyse;
        $this->daplosDatePrelevement = $dto->datePrelevement;

        return $this;
    }
}
