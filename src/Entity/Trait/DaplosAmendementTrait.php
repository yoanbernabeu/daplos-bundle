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

    public function getDaplosCodeAmendement(): ?string
    {
        return $this->daplosCodeAmendement;
    }

    public function setDaplosCodeAmendement(?string $daplosCodeAmendement): static
    {
        $this->daplosCodeAmendement = $daplosCodeAmendement;

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
     * Hydrate l'entité depuis un DTO Amendement.
     */
    public function hydrateFromDaplosAmendement(Amendement $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosCodeAmendement = $dto->codeAmendement;
        $this->daplosQuantite = $dto->quantite;
        $this->daplosCodeUnite = $dto->codeUnite;

        return $this;
    }
}
