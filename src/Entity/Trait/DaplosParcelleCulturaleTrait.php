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

    /** @deprecated sémantique erronée dans le guide v0.95, plus jamais rempli par le parser ; utiliser daplosDateCreationFiche */
    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateCreation = null;

    /** @deprecated sémantique erronée dans le guide v0.95, plus jamais rempli par le parser ; utiliser daplosDateDebutParcelle */
    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateDebutCampagne = null;

    /** @deprecated sémantique erronée dans le guide v0.95, plus jamais rempli par le parser ; utiliser daplosDateFinParcelle */
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

    /** @deprecated le n° îlot PAC est un an 10, plus jamais rempli par le parser ; utiliser daplosNumeroIlotPac */
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosNumeroIlot = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeCommune = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeModeProduction = null;

    /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser */
    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosNumeroRPG = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateDebutParcelle = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateCreationFiche = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateDerniereSaisie = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateFinParcelle = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $daplosCodeVariete2 = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $daplosCodeVariete3 = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $daplosCodeVariete4 = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $daplosCodeVariete5 = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosRendementObjectif = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeUniteRendement = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosNumeroIlotPac = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosNumeroParcellePerenne = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosProfondeurSol = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosPierrosite = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosAutreTypeSol = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeAcidite = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeProfondeurSousSol = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeCultureIntermediaire = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $daplosSolHydromorphe = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $daplosParcelleDrainee = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $daplosParcelleRedecoupee = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCleParcelleInitiale = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeGestionResidus = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosQuantiteEpandue = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeTypeSolV095 = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosDoseAzote = null;

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

    public function getDaplosDateDebutParcelle(): ?\DateTimeImmutable
    {
        return $this->daplosDateDebutParcelle;
    }

    public function setDaplosDateDebutParcelle(?\DateTimeImmutable $daplosDateDebutParcelle): static
    {
        $this->daplosDateDebutParcelle = $daplosDateDebutParcelle;

        return $this;
    }

    public function getDaplosDateCreationFiche(): ?\DateTimeImmutable
    {
        return $this->daplosDateCreationFiche;
    }

    public function setDaplosDateCreationFiche(?\DateTimeImmutable $daplosDateCreationFiche): static
    {
        $this->daplosDateCreationFiche = $daplosDateCreationFiche;

        return $this;
    }

    public function getDaplosDateDerniereSaisie(): ?\DateTimeImmutable
    {
        return $this->daplosDateDerniereSaisie;
    }

    public function setDaplosDateDerniereSaisie(?\DateTimeImmutable $daplosDateDerniereSaisie): static
    {
        $this->daplosDateDerniereSaisie = $daplosDateDerniereSaisie;

        return $this;
    }

    public function getDaplosDateFinParcelle(): ?\DateTimeImmutable
    {
        return $this->daplosDateFinParcelle;
    }

    public function setDaplosDateFinParcelle(?\DateTimeImmutable $daplosDateFinParcelle): static
    {
        $this->daplosDateFinParcelle = $daplosDateFinParcelle;

        return $this;
    }

    public function getDaplosCodeVariete2(): ?string
    {
        return $this->daplosCodeVariete2;
    }

    public function setDaplosCodeVariete2(?string $daplosCodeVariete2): static
    {
        $this->daplosCodeVariete2 = $daplosCodeVariete2;

        return $this;
    }

    public function getDaplosCodeVariete3(): ?string
    {
        return $this->daplosCodeVariete3;
    }

    public function setDaplosCodeVariete3(?string $daplosCodeVariete3): static
    {
        $this->daplosCodeVariete3 = $daplosCodeVariete3;

        return $this;
    }

    public function getDaplosCodeVariete4(): ?string
    {
        return $this->daplosCodeVariete4;
    }

    public function setDaplosCodeVariete4(?string $daplosCodeVariete4): static
    {
        $this->daplosCodeVariete4 = $daplosCodeVariete4;

        return $this;
    }

    public function getDaplosCodeVariete5(): ?string
    {
        return $this->daplosCodeVariete5;
    }

    public function setDaplosCodeVariete5(?string $daplosCodeVariete5): static
    {
        $this->daplosCodeVariete5 = $daplosCodeVariete5;

        return $this;
    }

    public function getDaplosRendementObjectif(): ?string
    {
        return $this->daplosRendementObjectif;
    }

    public function setDaplosRendementObjectif(float|string|null $daplosRendementObjectif): static
    {
        $this->daplosRendementObjectif = null !== $daplosRendementObjectif ? (string) $daplosRendementObjectif : null;

        return $this;
    }

    public function getDaplosCodeUniteRendement(): ?string
    {
        return $this->daplosCodeUniteRendement;
    }

    public function setDaplosCodeUniteRendement(?string $daplosCodeUniteRendement): static
    {
        $this->daplosCodeUniteRendement = $daplosCodeUniteRendement;

        return $this;
    }

    public function getDaplosNumeroIlotPac(): ?string
    {
        return $this->daplosNumeroIlotPac;
    }

    public function setDaplosNumeroIlotPac(?string $daplosNumeroIlotPac): static
    {
        $this->daplosNumeroIlotPac = $daplosNumeroIlotPac;

        return $this;
    }

    public function getDaplosNumeroParcellePerenne(): ?string
    {
        return $this->daplosNumeroParcellePerenne;
    }

    public function setDaplosNumeroParcellePerenne(?string $daplosNumeroParcellePerenne): static
    {
        $this->daplosNumeroParcellePerenne = $daplosNumeroParcellePerenne;

        return $this;
    }

    public function getDaplosProfondeurSol(): ?int
    {
        return $this->daplosProfondeurSol;
    }

    public function setDaplosProfondeurSol(?int $daplosProfondeurSol): static
    {
        $this->daplosProfondeurSol = $daplosProfondeurSol;

        return $this;
    }

    public function getDaplosPierrosite(): ?int
    {
        return $this->daplosPierrosite;
    }

    public function setDaplosPierrosite(?int $daplosPierrosite): static
    {
        $this->daplosPierrosite = $daplosPierrosite;

        return $this;
    }

    public function getDaplosAutreTypeSol(): ?string
    {
        return $this->daplosAutreTypeSol;
    }

    public function setDaplosAutreTypeSol(?string $daplosAutreTypeSol): static
    {
        $this->daplosAutreTypeSol = $daplosAutreTypeSol;

        return $this;
    }

    public function getDaplosCodeAcidite(): ?string
    {
        return $this->daplosCodeAcidite;
    }

    public function setDaplosCodeAcidite(?string $daplosCodeAcidite): static
    {
        $this->daplosCodeAcidite = $daplosCodeAcidite;

        return $this;
    }

    public function getDaplosCodeProfondeurSousSol(): ?string
    {
        return $this->daplosCodeProfondeurSousSol;
    }

    public function setDaplosCodeProfondeurSousSol(?string $daplosCodeProfondeurSousSol): static
    {
        $this->daplosCodeProfondeurSousSol = $daplosCodeProfondeurSousSol;

        return $this;
    }

    public function getDaplosCodeCultureIntermediaire(): ?string
    {
        return $this->daplosCodeCultureIntermediaire;
    }

    public function setDaplosCodeCultureIntermediaire(?string $daplosCodeCultureIntermediaire): static
    {
        $this->daplosCodeCultureIntermediaire = $daplosCodeCultureIntermediaire;

        return $this;
    }

    public function getDaplosSolHydromorphe(): ?bool
    {
        return $this->daplosSolHydromorphe;
    }

    public function setDaplosSolHydromorphe(?bool $daplosSolHydromorphe): static
    {
        $this->daplosSolHydromorphe = $daplosSolHydromorphe;

        return $this;
    }

    public function getDaplosParcelleDrainee(): ?bool
    {
        return $this->daplosParcelleDrainee;
    }

    public function setDaplosParcelleDrainee(?bool $daplosParcelleDrainee): static
    {
        $this->daplosParcelleDrainee = $daplosParcelleDrainee;

        return $this;
    }

    public function getDaplosParcelleRedecoupee(): ?bool
    {
        return $this->daplosParcelleRedecoupee;
    }

    public function setDaplosParcelleRedecoupee(?bool $daplosParcelleRedecoupee): static
    {
        $this->daplosParcelleRedecoupee = $daplosParcelleRedecoupee;

        return $this;
    }

    public function getDaplosCleParcelleInitiale(): ?string
    {
        return $this->daplosCleParcelleInitiale;
    }

    public function setDaplosCleParcelleInitiale(?string $daplosCleParcelleInitiale): static
    {
        $this->daplosCleParcelleInitiale = $daplosCleParcelleInitiale;

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

    public function getDaplosCodeTypeSolV095(): ?string
    {
        return $this->daplosCodeTypeSolV095;
    }

    public function setDaplosCodeTypeSolV095(?string $daplosCodeTypeSolV095): static
    {
        $this->daplosCodeTypeSolV095 = $daplosCodeTypeSolV095;

        return $this;
    }

    public function getDaplosDoseAzote(): ?string
    {
        return $this->daplosDoseAzote;
    }

    public function setDaplosDoseAzote(float|string|null $daplosDoseAzote): static
    {
        $this->daplosDoseAzote = null !== $daplosDoseAzote ? (string) $daplosDoseAzote : null;

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
        $this->daplosDateDebutParcelle = $dto->dateDebutParcelle;
        $this->daplosDateCreationFiche = $dto->dateCreationFiche;
        $this->daplosDateDerniereSaisie = $dto->dateDerniereSaisie;
        $this->daplosDateFinParcelle = $dto->dateFinParcelle;
        $this->daplosCodeVariete2 = $dto->codeVariete2;
        $this->daplosCodeVariete3 = $dto->codeVariete3;
        $this->daplosCodeVariete4 = $dto->codeVariete4;
        $this->daplosCodeVariete5 = $dto->codeVariete5;
        $this->daplosRendementObjectif = null !== $dto->rendementObjectif ? (string) $dto->rendementObjectif : null;
        $this->daplosCodeUniteRendement = $dto->codeUniteRendement;
        $this->daplosNumeroIlotPac = $dto->numeroIlotPac;
        $this->daplosNumeroParcellePerenne = $dto->numeroParcellePerenne;
        $this->daplosProfondeurSol = $dto->profondeurSol;
        $this->daplosPierrosite = $dto->pierrosite;
        $this->daplosAutreTypeSol = $dto->autreTypeSol;
        $this->daplosCodeAcidite = $dto->codeAcidite;
        $this->daplosCodeProfondeurSousSol = $dto->codeProfondeurSousSol;
        $this->daplosCodeCultureIntermediaire = $dto->codeCultureIntermediaire;
        $this->daplosSolHydromorphe = $dto->solHydromorphe;
        $this->daplosParcelleDrainee = $dto->parcelleDrainee;
        $this->daplosParcelleRedecoupee = $dto->parcelleRedecoupee;
        $this->daplosCleParcelleInitiale = $dto->cleParcelleInitiale;
        $this->daplosCodeGestionResidus = $dto->codeGestionResidus;
        $this->daplosQuantiteEpandue = null !== $dto->quantiteEpandue ? (string) $dto->quantiteEpandue : null;
        $this->daplosCodeTypeSolV095 = $dto->codeTypeSolV095;
        $this->daplosDoseAzote = null !== $dto->doseAzote ? (string) $dto->doseAzote : null;

        return $this;
    }
}
