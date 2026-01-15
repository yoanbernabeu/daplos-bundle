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

        return $this;
    }
}
