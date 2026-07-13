<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Intervention\HistoriqueDecision;

/**
 * Trait pour les entités représentant un historique de décision DAPLOS.
 *
 * Usage:
 *   use DaplosHistoriqueDecisionTrait;
 *
 * @author Yoan Bernabeu
 */
trait DaplosHistoriqueDecisionTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $daplosRefIntervention = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosDecision = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateDecision = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeTypeLien = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $daplosRefEvenementConsidere = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosNumeroParcelleAnterieur = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnneeRecolte = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosIdentificationExploitation = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeTypeIdentification = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosExploitationRaisonSociale1 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosExploitationRaisonSociale2 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosExploitationAdresse1 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosExploitationAdresse2 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosExploitationVille = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosExploitationCodePostal = null;

    #[ORM\Column(type: 'string', length: 2, nullable: true)]
    private ?string $daplosExploitationPays = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosInfoParcelleNonEdi1 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosInfoParcelleNonEdi2 = null;

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

    public function getDaplosDecision(): ?string
    {
        return $this->daplosDecision;
    }

    public function setDaplosDecision(?string $daplosDecision): static
    {
        $this->daplosDecision = $daplosDecision;

        return $this;
    }

    public function getDaplosDateDecision(): ?\DateTimeImmutable
    {
        return $this->daplosDateDecision;
    }

    public function setDaplosDateDecision(?\DateTimeImmutable $daplosDateDecision): static
    {
        $this->daplosDateDecision = $daplosDateDecision;

        return $this;
    }

    public function getDaplosCodeTypeLien(): ?string
    {
        return $this->daplosCodeTypeLien;
    }

    public function setDaplosCodeTypeLien(?string $daplosCodeTypeLien): static
    {
        $this->daplosCodeTypeLien = $daplosCodeTypeLien;

        return $this;
    }

    public function getDaplosRefEvenementConsidere(): ?string
    {
        return $this->daplosRefEvenementConsidere;
    }

    public function setDaplosRefEvenementConsidere(?string $daplosRefEvenementConsidere): static
    {
        $this->daplosRefEvenementConsidere = $daplosRefEvenementConsidere;

        return $this;
    }

    public function getDaplosNumeroParcelleAnterieur(): ?string
    {
        return $this->daplosNumeroParcelleAnterieur;
    }

    public function setDaplosNumeroParcelleAnterieur(?string $daplosNumeroParcelleAnterieur): static
    {
        $this->daplosNumeroParcelleAnterieur = $daplosNumeroParcelleAnterieur;

        return $this;
    }

    public function getDaplosAnneeRecolte(): ?int
    {
        return $this->daplosAnneeRecolte;
    }

    public function setDaplosAnneeRecolte(?int $daplosAnneeRecolte): static
    {
        $this->daplosAnneeRecolte = $daplosAnneeRecolte;

        return $this;
    }

    public function getDaplosIdentificationExploitation(): ?string
    {
        return $this->daplosIdentificationExploitation;
    }

    public function setDaplosIdentificationExploitation(?string $daplosIdentificationExploitation): static
    {
        $this->daplosIdentificationExploitation = $daplosIdentificationExploitation;

        return $this;
    }

    public function getDaplosCodeTypeIdentification(): ?string
    {
        return $this->daplosCodeTypeIdentification;
    }

    public function setDaplosCodeTypeIdentification(?string $daplosCodeTypeIdentification): static
    {
        $this->daplosCodeTypeIdentification = $daplosCodeTypeIdentification;

        return $this;
    }

    public function getDaplosExploitationRaisonSociale1(): ?string
    {
        return $this->daplosExploitationRaisonSociale1;
    }

    public function setDaplosExploitationRaisonSociale1(?string $daplosExploitationRaisonSociale1): static
    {
        $this->daplosExploitationRaisonSociale1 = $daplosExploitationRaisonSociale1;

        return $this;
    }

    public function getDaplosExploitationRaisonSociale2(): ?string
    {
        return $this->daplosExploitationRaisonSociale2;
    }

    public function setDaplosExploitationRaisonSociale2(?string $daplosExploitationRaisonSociale2): static
    {
        $this->daplosExploitationRaisonSociale2 = $daplosExploitationRaisonSociale2;

        return $this;
    }

    public function getDaplosExploitationAdresse1(): ?string
    {
        return $this->daplosExploitationAdresse1;
    }

    public function setDaplosExploitationAdresse1(?string $daplosExploitationAdresse1): static
    {
        $this->daplosExploitationAdresse1 = $daplosExploitationAdresse1;

        return $this;
    }

    public function getDaplosExploitationAdresse2(): ?string
    {
        return $this->daplosExploitationAdresse2;
    }

    public function setDaplosExploitationAdresse2(?string $daplosExploitationAdresse2): static
    {
        $this->daplosExploitationAdresse2 = $daplosExploitationAdresse2;

        return $this;
    }

    public function getDaplosExploitationVille(): ?string
    {
        return $this->daplosExploitationVille;
    }

    public function setDaplosExploitationVille(?string $daplosExploitationVille): static
    {
        $this->daplosExploitationVille = $daplosExploitationVille;

        return $this;
    }

    public function getDaplosExploitationCodePostal(): ?string
    {
        return $this->daplosExploitationCodePostal;
    }

    public function setDaplosExploitationCodePostal(?string $daplosExploitationCodePostal): static
    {
        $this->daplosExploitationCodePostal = $daplosExploitationCodePostal;

        return $this;
    }

    public function getDaplosExploitationPays(): ?string
    {
        return $this->daplosExploitationPays;
    }

    public function setDaplosExploitationPays(?string $daplosExploitationPays): static
    {
        $this->daplosExploitationPays = $daplosExploitationPays;

        return $this;
    }

    public function getDaplosInfoParcelleNonEdi1(): ?string
    {
        return $this->daplosInfoParcelleNonEdi1;
    }

    public function setDaplosInfoParcelleNonEdi1(?string $daplosInfoParcelleNonEdi1): static
    {
        $this->daplosInfoParcelleNonEdi1 = $daplosInfoParcelleNonEdi1;

        return $this;
    }

    public function getDaplosInfoParcelleNonEdi2(): ?string
    {
        return $this->daplosInfoParcelleNonEdi2;
    }

    public function setDaplosInfoParcelleNonEdi2(?string $daplosInfoParcelleNonEdi2): static
    {
        $this->daplosInfoParcelleNonEdi2 = $daplosInfoParcelleNonEdi2;

        return $this;
    }

    /**
     * Hydrate l'entité depuis un DTO HistoriqueDecision.
     */
    public function hydrateFromDaplosHistoriqueDecision(HistoriqueDecision $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosRefIntervention = $dto->refIntervention;
        $this->daplosDecision = $dto->decision;
        $this->daplosDateDecision = $dto->dateDecision;
        $this->daplosCodeTypeLien = $dto->codeTypeLien;
        $this->daplosRefEvenementConsidere = $dto->refEvenementConsidere;
        $this->daplosNumeroParcelleAnterieur = $dto->numeroParcelleAnterieur;
        $this->daplosAnneeRecolte = $dto->anneeRecolte;
        $this->daplosIdentificationExploitation = $dto->identificationExploitation;
        $this->daplosCodeTypeIdentification = $dto->codeTypeIdentification;
        $this->daplosExploitationRaisonSociale1 = $dto->exploitationRaisonSociale1;
        $this->daplosExploitationRaisonSociale2 = $dto->exploitationRaisonSociale2;
        $this->daplosExploitationAdresse1 = $dto->exploitationAdresse1;
        $this->daplosExploitationAdresse2 = $dto->exploitationAdresse2;
        $this->daplosExploitationVille = $dto->exploitationVille;
        $this->daplosExploitationCodePostal = $dto->exploitationCodePostal;
        $this->daplosExploitationPays = $dto->exploitationPays;
        $this->daplosInfoParcelleNonEdi1 = $dto->infoParcelleNonEdi1;
        $this->daplosInfoParcelleNonEdi2 = $dto->infoParcelleNonEdi2;

        return $this;
    }
}
