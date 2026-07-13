<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Parcelle;

use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;

/**
 * DTO pour le FLAG DP (Parcelle Culturale).
 */
final class ParcelleCulturale
{
    /** @var array<SurfaceParcelle> */
    private array $surfaces = [];

    /** @var array<Coordonnee> */
    private array $coordonnees = [];

    /** @var array<ParcelleCadastrale> */
    private array $parcellesCadastrales = [];

    /** @var array<Engagement> */
    private array $engagements = [];

    /** @var array<Historique> */
    private array $historiques = [];

    /** @var array<Analyse> */
    private array $analyses = [];

    /** @var array<Evenement> */
    private array $evenements = [];

    public function __construct(
        public readonly ?string $identifiant = null,
        public readonly ?int $annee = null,
        /** @deprecated sémantique erronée (lisait les positions 15-22 = date de début de la parcelle), plus jamais rempli par le parser ; utiliser dateCreationFiche */
        public readonly ?\DateTimeImmutable $dateCreation = null,
        /** @deprecated sémantique erronée (lisait les positions 23-30 = date de création de la fiche), plus jamais rempli par le parser ; utiliser dateDebutParcelle */
        public readonly ?\DateTimeImmutable $dateDebutCampagne = null,
        /** @deprecated sémantique erronée (lisait les positions 31-38 = date de dernière saisie), plus jamais rempli par le parser ; utiliser dateFinParcelle */
        public readonly ?\DateTimeImmutable $dateFinCampagne = null,
        public readonly ?string $codeEspeceBotanique = null,
        public readonly ?string $codeVariete = null,
        public readonly ?string $codeQualifiantCulture = null,
        public readonly ?string $codeDestinationCulture = null,
        public readonly ?string $codePeriodeSemis = null,
        public readonly ?string $codeJustificationCulture = null,
        public readonly ?string $codeTypeSol = null,
        public readonly ?string $codeTypeSousSol = null,
        public readonly ?float $surface = null,
        public readonly ?string $codeUniteSurface = null,
        public readonly ?string $nom = null,
        /** @deprecated le n° îlot PAC est un an 10 (positions 141-150), plus jamais rempli par le parser ; utiliser numeroIlotPac */
        public readonly ?int $numeroIlot = null,
        public readonly ?string $codeCommune = null,
        public readonly ?string $codeModeProduction = null,
        /** @deprecated champ hors guide v0.95 (lisait les positions 237-246, à cheval sur le type de sol v0.95), plus jamais rempli par le parser */
        public readonly ?string $numeroRPG = null,
        public readonly ?\DateTimeImmutable $dateDebutParcelle = null,
        public readonly ?\DateTimeImmutable $dateCreationFiche = null,
        public readonly ?\DateTimeImmutable $dateDerniereSaisie = null,
        public readonly ?\DateTimeImmutable $dateFinParcelle = null,
        public readonly ?string $codeVariete2 = null,
        public readonly ?string $codeVariete3 = null,
        public readonly ?string $codeVariete4 = null,
        public readonly ?string $codeVariete5 = null,
        public readonly ?float $rendementObjectif = null,
        public readonly ?string $codeUniteRendement = null,
        public readonly ?string $numeroIlotPac = null,
        public readonly ?string $numeroParcellePerenne = null,
        public readonly ?int $profondeurSol = null,
        public readonly ?int $pierrosite = null,
        public readonly ?string $autreTypeSol = null,
        public readonly ?string $codeAcidite = null,
        public readonly ?string $codeProfondeurSousSol = null,
        public readonly ?string $codeCultureIntermediaire = null,
        public readonly ?bool $solHydromorphe = null,
        public readonly ?bool $parcelleDrainee = null,
        public readonly ?bool $parcelleRedecoupee = null,
        public readonly ?string $cleParcelleInitiale = null,
        public readonly ?string $codeGestionResidus = null,
        public readonly ?float $quantiteEpandue = null,
        public readonly ?string $codeTypeSolV095 = null,
        public readonly ?float $doseAzote = null,
    ) {
    }

    public function addSurface(SurfaceParcelle $surface): void
    {
        $this->surfaces[] = $surface;
    }

    /**
     * @return array<SurfaceParcelle>
     */
    public function getSurfaces(): array
    {
        return $this->surfaces;
    }

    public function addCoordonnee(Coordonnee $coordonnee): void
    {
        $this->coordonnees[] = $coordonnee;
    }

    /**
     * @return array<Coordonnee>
     */
    public function getCoordonnees(): array
    {
        return $this->coordonnees;
    }

    public function addParcelleCadastrale(ParcelleCadastrale $parcelle): void
    {
        $this->parcellesCadastrales[] = $parcelle;
    }

    /**
     * @return array<ParcelleCadastrale>
     */
    public function getParcellesCadastrales(): array
    {
        return $this->parcellesCadastrales;
    }

    public function addEngagement(Engagement $engagement): void
    {
        $this->engagements[] = $engagement;
    }

    /**
     * @return array<Engagement>
     */
    public function getEngagements(): array
    {
        return $this->engagements;
    }

    public function addHistorique(Historique $historique): void
    {
        $this->historiques[] = $historique;
    }

    /**
     * @return array<Historique>
     */
    public function getHistoriques(): array
    {
        return $this->historiques;
    }

    public function addAnalyse(Analyse $analyse): void
    {
        $this->analyses[] = $analyse;
    }

    /**
     * @return array<Analyse>
     */
    public function getAnalyses(): array
    {
        return $this->analyses;
    }

    public function addEvenement(Evenement $evenement): void
    {
        $this->evenements[] = $evenement;
    }

    /**
     * @return array<Evenement>
     */
    public function getEvenements(): array
    {
        return $this->evenements;
    }
}
