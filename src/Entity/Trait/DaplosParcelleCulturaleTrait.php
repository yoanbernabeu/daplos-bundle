<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;

/**
 * Trait pour les entités représentant une parcelle culturale DAPLOS.
 *
 * Usage:
 *   use DaplosParcelleCulturaleTrait;
 *
 * L'entité aura alors les propriétés standard d'une parcelle DAPLOS :
 *   - daplosIdentifiant : Identifiant unique de la parcelle
 *   - daplosAnnee : Année de campagne
 *   - daplosNom : Nom de la parcelle
 *   - Codes référentiels (espèce, variété, sol, etc.)
 *
 * @author Yoan Bernabeu
 */
trait DaplosParcelleCulturaleTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiant = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosNom = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateCreation = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateDebutCampagne = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateFinCampagne = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeEspeceBotanique = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $daplosCodeVariete = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeQualifiantCulture = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeDestinationCulture = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodePeriodeSemis = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeTypeSol = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeTypeSousSol = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4, nullable: true)]
    private ?string $daplosSurface = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeUniteSurface = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosNumeroIlot = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeCommune = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeModeProduction = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosNumeroRPG = null;

    public function getDaplosIdentifiant(): ?string
    {
        return $this->daplosIdentifiant;
    }

    public function setDaplosIdentifiant(?string $daplosIdentifiant): static
    {
        $this->daplosIdentifiant = $daplosIdentifiant;

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

    public function getDaplosNom(): ?string
    {
        return $this->daplosNom;
    }

    public function setDaplosNom(?string $daplosNom): static
    {
        $this->daplosNom = $daplosNom;

        return $this;
    }

    public function getDaplosDateCreation(): ?\DateTimeImmutable
    {
        return $this->daplosDateCreation;
    }

    public function setDaplosDateCreation(?\DateTimeImmutable $daplosDateCreation): static
    {
        $this->daplosDateCreation = $daplosDateCreation;

        return $this;
    }

    public function getDaplosDateDebutCampagne(): ?\DateTimeImmutable
    {
        return $this->daplosDateDebutCampagne;
    }

    public function setDaplosDateDebutCampagne(?\DateTimeImmutable $daplosDateDebutCampagne): static
    {
        $this->daplosDateDebutCampagne = $daplosDateDebutCampagne;

        return $this;
    }

    public function getDaplosDateFinCampagne(): ?\DateTimeImmutable
    {
        return $this->daplosDateFinCampagne;
    }

    public function setDaplosDateFinCampagne(?\DateTimeImmutable $daplosDateFinCampagne): static
    {
        $this->daplosDateFinCampagne = $daplosDateFinCampagne;

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

    public function getDaplosCodeVariete(): ?string
    {
        return $this->daplosCodeVariete;
    }

    public function setDaplosCodeVariete(?string $daplosCodeVariete): static
    {
        $this->daplosCodeVariete = $daplosCodeVariete;

        return $this;
    }

    public function getDaplosCodeQualifiantCulture(): ?string
    {
        return $this->daplosCodeQualifiantCulture;
    }

    public function setDaplosCodeQualifiantCulture(?string $daplosCodeQualifiantCulture): static
    {
        $this->daplosCodeQualifiantCulture = $daplosCodeQualifiantCulture;

        return $this;
    }

    public function getDaplosCodeDestinationCulture(): ?string
    {
        return $this->daplosCodeDestinationCulture;
    }

    public function setDaplosCodeDestinationCulture(?string $daplosCodeDestinationCulture): static
    {
        $this->daplosCodeDestinationCulture = $daplosCodeDestinationCulture;

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

    public function getDaplosCodeTypeSol(): ?string
    {
        return $this->daplosCodeTypeSol;
    }

    public function setDaplosCodeTypeSol(?string $daplosCodeTypeSol): static
    {
        $this->daplosCodeTypeSol = $daplosCodeTypeSol;

        return $this;
    }

    public function getDaplosCodeTypeSousSol(): ?string
    {
        return $this->daplosCodeTypeSousSol;
    }

    public function setDaplosCodeTypeSousSol(?string $daplosCodeTypeSousSol): static
    {
        $this->daplosCodeTypeSousSol = $daplosCodeTypeSousSol;

        return $this;
    }

    public function getDaplosSurface(): ?string
    {
        return $this->daplosSurface;
    }

    public function setDaplosSurface(float|string|null $daplosSurface): static
    {
        $this->daplosSurface = null !== $daplosSurface ? (string) $daplosSurface : null;

        return $this;
    }

    public function getDaplosCodeUniteSurface(): ?string
    {
        return $this->daplosCodeUniteSurface;
    }

    public function setDaplosCodeUniteSurface(?string $daplosCodeUniteSurface): static
    {
        $this->daplosCodeUniteSurface = $daplosCodeUniteSurface;

        return $this;
    }

    public function getDaplosNumeroIlot(): ?int
    {
        return $this->daplosNumeroIlot;
    }

    public function setDaplosNumeroIlot(?int $daplosNumeroIlot): static
    {
        $this->daplosNumeroIlot = $daplosNumeroIlot;

        return $this;
    }

    public function getDaplosCodeCommune(): ?string
    {
        return $this->daplosCodeCommune;
    }

    public function setDaplosCodeCommune(?string $daplosCodeCommune): static
    {
        $this->daplosCodeCommune = $daplosCodeCommune;

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

    public function getDaplosNumeroRPG(): ?string
    {
        return $this->daplosNumeroRPG;
    }

    public function setDaplosNumeroRPG(?string $daplosNumeroRPG): static
    {
        $this->daplosNumeroRPG = $daplosNumeroRPG;

        return $this;
    }

    /**
     * Hydrate l'entité depuis un DTO ParcelleCulturale.
     */
    public function hydrateFromDaplosParcelle(ParcelleCulturale $dto): static
    {
        $this->daplosIdentifiant = $dto->identifiant;
        $this->daplosAnnee = $dto->annee;
        $this->daplosNom = $dto->nom;
        $this->daplosDateCreation = $dto->dateCreation;
        $this->daplosDateDebutCampagne = $dto->dateDebutCampagne;
        $this->daplosDateFinCampagne = $dto->dateFinCampagne;
        $this->daplosCodeEspeceBotanique = $dto->codeEspeceBotanique;
        $this->daplosCodeVariete = $dto->codeVariete;
        $this->daplosCodeQualifiantCulture = $dto->codeQualifiantCulture;
        $this->daplosCodeDestinationCulture = $dto->codeDestinationCulture;
        $this->daplosCodePeriodeSemis = $dto->codePeriodeSemis;
        $this->daplosCodeTypeSol = $dto->codeTypeSol;
        $this->daplosCodeTypeSousSol = $dto->codeTypeSousSol;
        $this->daplosSurface = null !== $dto->surface ? (string) $dto->surface : null;
        $this->daplosCodeUniteSurface = $dto->codeUniteSurface;
        $this->daplosNumeroIlot = $dto->numeroIlot;
        $this->daplosCodeCommune = $dto->codeCommune;
        $this->daplosCodeModeProduction = $dto->codeModeProduction;
        $this->daplosNumeroRPG = $dto->numeroRPG;

        return $this;
    }
}
