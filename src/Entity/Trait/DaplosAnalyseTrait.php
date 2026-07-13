<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Analyse;

/**
 * Trait pour les entités représentant une analyse de sol DAPLOS.
 *
 * Usage:
 *   use DaplosAnalyseTrait;
 *
 * @author Yoan Bernabeu
 */
trait DaplosAnalyseTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    /** @deprecated champ hors guide v0.95, plus jamais rempli — voir $daplosNumeroBordereau */
    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosTypeAnalyse = null;

    /** @deprecated champ hors guide v0.95, plus jamais rempli — voir $daplosLaboratoireRaisonSociale1 */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosLaboratoire = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDatePrelevement = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateAnalyse = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosNumeroBordereau = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosIdentificationLaboratoire = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosLaboratoireRaisonSociale1 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosLaboratoireRaisonSociale2 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosLaboratoireAdresseRue1 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosLaboratoireAdresseRue2 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosLaboratoireVille = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosLaboratoireCodePostal = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosLaboratoirePays = null;

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

    public function getDaplosTypeAnalyse(): ?string
    {
        return $this->daplosTypeAnalyse;
    }

    public function setDaplosTypeAnalyse(?string $daplosTypeAnalyse): static
    {
        $this->daplosTypeAnalyse = $daplosTypeAnalyse;

        return $this;
    }

    public function getDaplosLaboratoire(): ?string
    {
        return $this->daplosLaboratoire;
    }

    public function setDaplosLaboratoire(?string $daplosLaboratoire): static
    {
        $this->daplosLaboratoire = $daplosLaboratoire;

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

    public function getDaplosDateAnalyse(): ?\DateTimeImmutable
    {
        return $this->daplosDateAnalyse;
    }

    public function setDaplosDateAnalyse(?\DateTimeImmutable $daplosDateAnalyse): static
    {
        $this->daplosDateAnalyse = $daplosDateAnalyse;

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

    public function getDaplosLaboratoireAdresseRue1(): ?string
    {
        return $this->daplosLaboratoireAdresseRue1;
    }

    public function setDaplosLaboratoireAdresseRue1(?string $daplosLaboratoireAdresseRue1): static
    {
        $this->daplosLaboratoireAdresseRue1 = $daplosLaboratoireAdresseRue1;

        return $this;
    }

    public function getDaplosLaboratoireAdresseRue2(): ?string
    {
        return $this->daplosLaboratoireAdresseRue2;
    }

    public function setDaplosLaboratoireAdresseRue2(?string $daplosLaboratoireAdresseRue2): static
    {
        $this->daplosLaboratoireAdresseRue2 = $daplosLaboratoireAdresseRue2;

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

    /**
     * Hydrate l'entité depuis un DTO Analyse.
     */
    public function hydrateFromDaplosAnalyse(Analyse $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosTypeAnalyse = $dto->typeAnalyse;
        $this->daplosLaboratoire = $dto->laboratoire;
        $this->daplosDatePrelevement = $dto->datePrelevement;
        $this->daplosDateAnalyse = $dto->dateAnalyse;
        $this->daplosNumeroBordereau = $dto->numeroBordereau;
        $this->daplosIdentificationLaboratoire = $dto->identificationLaboratoire;
        $this->daplosLaboratoireRaisonSociale1 = $dto->laboratoireRaisonSociale1;
        $this->daplosLaboratoireRaisonSociale2 = $dto->laboratoireRaisonSociale2;
        $this->daplosLaboratoireAdresseRue1 = $dto->laboratoireAdresseRue1;
        $this->daplosLaboratoireAdresseRue2 = $dto->laboratoireAdresseRue2;
        $this->daplosLaboratoireVille = $dto->laboratoireVille;
        $this->daplosLaboratoireCodePostal = $dto->laboratoireCodePostal;
        $this->daplosLaboratoirePays = $dto->laboratoirePays;

        return $this;
    }
}
