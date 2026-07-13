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

    /** @deprecated champ hors guide v0.95, plus jamais rempli — voir $daplosCleParcellePrecedent */
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnneePrecedent = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeEspeceBotanique = null;

    /** @deprecated champ hors guide v0.95, plus jamais rempli — voir $daplosCodeGestionResidus */
    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeTraitementResidus = null;

    /** @deprecated champ hors guide v0.95, plus jamais rempli */
    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeModeProduction = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCleParcellePrecedent = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosVarieteSemee1 = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosVarieteSemee2 = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosVarieteSemee3 = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosVarieteSemee4 = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosVarieteSemee5 = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeQualifiantEspece = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodePeriodeSemis = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeDestination = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeGestionResidus = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosQuantiteEpandue = null;

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

    public function getDaplosCleParcellePrecedent(): ?string
    {
        return $this->daplosCleParcellePrecedent;
    }

    public function setDaplosCleParcellePrecedent(?string $daplosCleParcellePrecedent): static
    {
        $this->daplosCleParcellePrecedent = $daplosCleParcellePrecedent;

        return $this;
    }

    public function getDaplosVarieteSemee1(): ?string
    {
        return $this->daplosVarieteSemee1;
    }

    public function setDaplosVarieteSemee1(?string $daplosVarieteSemee1): static
    {
        $this->daplosVarieteSemee1 = $daplosVarieteSemee1;

        return $this;
    }

    public function getDaplosVarieteSemee2(): ?string
    {
        return $this->daplosVarieteSemee2;
    }

    public function setDaplosVarieteSemee2(?string $daplosVarieteSemee2): static
    {
        $this->daplosVarieteSemee2 = $daplosVarieteSemee2;

        return $this;
    }

    public function getDaplosVarieteSemee3(): ?string
    {
        return $this->daplosVarieteSemee3;
    }

    public function setDaplosVarieteSemee3(?string $daplosVarieteSemee3): static
    {
        $this->daplosVarieteSemee3 = $daplosVarieteSemee3;

        return $this;
    }

    public function getDaplosVarieteSemee4(): ?string
    {
        return $this->daplosVarieteSemee4;
    }

    public function setDaplosVarieteSemee4(?string $daplosVarieteSemee4): static
    {
        $this->daplosVarieteSemee4 = $daplosVarieteSemee4;

        return $this;
    }

    public function getDaplosVarieteSemee5(): ?string
    {
        return $this->daplosVarieteSemee5;
    }

    public function setDaplosVarieteSemee5(?string $daplosVarieteSemee5): static
    {
        $this->daplosVarieteSemee5 = $daplosVarieteSemee5;

        return $this;
    }

    public function getDaplosCodeQualifiantEspece(): ?string
    {
        return $this->daplosCodeQualifiantEspece;
    }

    public function setDaplosCodeQualifiantEspece(?string $daplosCodeQualifiantEspece): static
    {
        $this->daplosCodeQualifiantEspece = $daplosCodeQualifiantEspece;

        return $this;
    }

    public function getDaplosCodePeriodeSemis(): ?string
    {
        return $this->daplosCodePeriodeSemis;
    }

    public function setDaplosCodePeriodeSemis(?string $daplosCodePeriodeSemis): static
    {
        $this->daplosCodePeriodeSemis = $daplosCodePeriodeSemis;

        return $this;
    }

    public function getDaplosCodeDestination(): ?string
    {
        return $this->daplosCodeDestination;
    }

    public function setDaplosCodeDestination(?string $daplosCodeDestination): static
    {
        $this->daplosCodeDestination = $daplosCodeDestination;

        return $this;
    }

    public function getDaplosCodeGestionResidus(): ?string
    {
        return $this->daplosCodeGestionResidus;
    }

    public function setDaplosCodeGestionResidus(?string $daplosCodeGestionResidus): static
    {
        $this->daplosCodeGestionResidus = $daplosCodeGestionResidus;

        return $this;
    }

    public function getDaplosQuantiteEpandue(): ?string
    {
        return $this->daplosQuantiteEpandue;
    }

    public function setDaplosQuantiteEpandue(float|string|null $daplosQuantiteEpandue): static
    {
        $this->daplosQuantiteEpandue = null !== $daplosQuantiteEpandue ? (string) $daplosQuantiteEpandue : null;

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
        $this->daplosCleParcellePrecedent = $dto->cleParcellePrecedent;
        $this->daplosVarieteSemee1 = $dto->varieteSemee1;
        $this->daplosVarieteSemee2 = $dto->varieteSemee2;
        $this->daplosVarieteSemee3 = $dto->varieteSemee3;
        $this->daplosVarieteSemee4 = $dto->varieteSemee4;
        $this->daplosVarieteSemee5 = $dto->varieteSemee5;
        $this->daplosCodeQualifiantEspece = $dto->codeQualifiantEspece;
        $this->daplosCodePeriodeSemis = $dto->codePeriodeSemis;
        $this->daplosCodeDestination = $dto->codeDestination;
        $this->daplosCodeGestionResidus = $dto->codeGestionResidus;
        $this->daplosQuantiteEpandue = null !== $dto->quantiteEpandue ? (string) $dto->quantiteEpandue : null;

        return $this;
    }
}
