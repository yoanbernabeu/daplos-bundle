<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Historique;

/**
 * Trait pour les entités représentant un historique/précédent cultural DAPLOS.
 *
 * Usage:
 *   use DaplosHistoriqueTrait;
 *
 * @author Yoan Bernabeu
 */
trait DaplosHistoriqueTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosIndexPrecedent = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnneePrecedent = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeEspeceBotanique = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeTraitementResidus = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeModeProduction = null;

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

    public function getDaplosIndexPrecedent(): ?int
    {
        return $this->daplosIndexPrecedent;
    }

    public function setDaplosIndexPrecedent(?int $daplosIndexPrecedent): static
    {
        $this->daplosIndexPrecedent = $daplosIndexPrecedent;

        return $this;
    }

    public function getDaplosAnneePrecedent(): ?int
    {
        return $this->daplosAnneePrecedent;
    }

    public function setDaplosAnneePrecedent(?int $daplosAnneePrecedent): static
    {
        $this->daplosAnneePrecedent = $daplosAnneePrecedent;

        return $this;
    }

    public function getDaplosCodeEspeceBotanique(): ?string
    {
        return $this->daplosCodeEspeceBotanique;
    }

    public function setDaplosCodeEspeceBotanique(?string $daplosCodeEspeceBotanique): static
    {
        $this->daplosCodeEspeceBotanique = $daplosCodeEspeceBotanique;

        return $this;
    }

    public function getDaplosCodeTraitementResidus(): ?string
    {
        return $this->daplosCodeTraitementResidus;
    }

    public function setDaplosCodeTraitementResidus(?string $daplosCodeTraitementResidus): static
    {
        $this->daplosCodeTraitementResidus = $daplosCodeTraitementResidus;

        return $this;
    }

    public function getDaplosCodeModeProduction(): ?string
    {
        return $this->daplosCodeModeProduction;
    }

    public function setDaplosCodeModeProduction(?string $daplosCodeModeProduction): static
    {
        $this->daplosCodeModeProduction = $daplosCodeModeProduction;

        return $this;
    }

    /**
     * Hydrate l'entité depuis un DTO Historique.
     */
    public function hydrateFromDaplosHistorique(Historique $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosIndexPrecedent = $dto->indexPrecedent;
        $this->daplosAnneePrecedent = $dto->anneePrecedent;
        $this->daplosCodeEspeceBotanique = $dto->codeEspeceBotanique;
        $this->daplosCodeTraitementResidus = $dto->codeTraitementResidus;
        $this->daplosCodeModeProduction = $dto->codeModeProduction;

        return $this;
    }
}
