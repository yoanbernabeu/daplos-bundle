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
        public readonly ?\DateTimeImmutable $dateCreation = null,
        public readonly ?\DateTimeImmutable $dateDebutCampagne = null,
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
        public readonly ?int $numeroIlot = null,
        public readonly ?string $codeCommune = null,
        public readonly ?string $codeModeProduction = null,
        public readonly ?string $numeroRPG = null,
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
