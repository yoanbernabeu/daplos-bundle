<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Intrant\CompositionFertilisation;

/**
 * Trait pour les entités représentant une composition de fertilisation DAPLOS.
 *
 * Usage:
 *   use DaplosCompositionFertilisationTrait;
 *
 * @author Yoan Bernabeu
 */
trait DaplosCompositionFertilisationTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $daplosRefIntervention = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeElement = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosIndexElement = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosTeneur = null;

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

    public function getDaplosCodeElement(): ?string
    {
        return $this->daplosCodeElement;
    }

    public function setDaplosCodeElement(?string $daplosCodeElement): static
    {
        $this->daplosCodeElement = $daplosCodeElement;

        return $this;
    }

    public function getDaplosIndexElement(): ?int
    {
        return $this->daplosIndexElement;
    }

    public function setDaplosIndexElement(?int $daplosIndexElement): static
    {
        $this->daplosIndexElement = $daplosIndexElement;

        return $this;
    }

    public function getDaplosTeneur(): ?string
    {
        return $this->daplosTeneur;
    }

    public function setDaplosTeneur(float|string|null $daplosTeneur): static
    {
        $this->daplosTeneur = null !== $daplosTeneur ? (string) $daplosTeneur : null;

        return $this;
    }

    /**
     * Hydrate l'entité depuis un DTO CompositionFertilisation.
     */
    public function hydrateFromDaplosCompositionFertilisation(CompositionFertilisation $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosRefIntervention = $dto->refIntervention;
        $this->daplosCodeElement = $dto->codeElement;
        $this->daplosIndexElement = $dto->indexElement;
        $this->daplosTeneur = null !== $dto->teneur ? (string) $dto->teneur : null;

        return $this;
    }
}
