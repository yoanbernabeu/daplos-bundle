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

        return $this;
    }
}
