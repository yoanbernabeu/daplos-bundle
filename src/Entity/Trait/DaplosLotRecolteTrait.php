<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Recolte\LotRecolte;

/**
 * Trait pour les entités représentant un lot de récolte DAPLOS.
 *
 * Usage:
 *   use DaplosLotRecolteTrait;
 *
 * @author Yoan Bernabeu
 */
trait DaplosLotRecolteTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $daplosRefIntervention = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $daplosNumeroLot = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?float $daplosQuantite = null;

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

    public function getDaplosNumeroLot(): ?string
    {
        return $this->daplosNumeroLot;
    }

    public function setDaplosNumeroLot(?string $daplosNumeroLot): static
    {
        $this->daplosNumeroLot = $daplosNumeroLot;

        return $this;
    }

    public function getDaplosQuantite(): ?float
    {
        return $this->daplosQuantite;
    }

    public function setDaplosQuantite(?float $daplosQuantite): static
    {
        $this->daplosQuantite = $daplosQuantite;

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
     * Hydrate l'entité depuis un DTO LotRecolte.
     */
    public function hydrateFromDaplosLotRecolte(LotRecolte $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosRefIntervention = $dto->refIntervention;
        $this->daplosNumeroLot = $dto->numeroLot;
        $this->daplosQuantite = $dto->quantite;
        $this->daplosCodeUnite = $dto->codeUnite;

        return $this;
    }
}
