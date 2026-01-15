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

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosTypeAnalyse = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosLaboratoire = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDatePrelevement = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateAnalyse = null;

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

        return $this;
    }
}
