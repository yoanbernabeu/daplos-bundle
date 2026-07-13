<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Intrant;

/**
 * DTO pour le FLAG VI (Intrant).
 */
final class Intrant
{
    // Codes types d'intrant (famille)
    public const TYPE_ZIU = 'ZIU'; // Herbicide
    public const TYPE_ZIV = 'ZIV'; // Fongicide
    public const TYPE_ZIW = 'ZIW'; // Insecticide
    public const TYPE_ZIX = 'ZIX'; // Molluscicide
    public const TYPE_ZIY = 'ZIY'; // Nematicide
    public const TYPE_ZIZ = 'ZIZ'; // Regulateur
    public const TYPE_ZJA = 'ZJA'; // Divers (huiles)
    public const TYPE_ZJB = 'ZJB'; // Effluents elevage
    public const TYPE_ZJC = 'ZJC'; // Fertilisation minerale
    public const TYPE_ZJD = 'ZJD'; // Fertirrigation
    public const TYPE_ZJE = 'ZJE'; // Irrigation
    public const TYPE_ZJF = 'ZJF'; // Semence
    public const TYPE_ZJG = 'ZJG'; // Traitement semence
    public const TYPE_ZJT = 'ZJT'; // Plants
    public const TYPE_ZQG = 'ZQG'; // Adjuvants

    /** @var array<CompositionFertilisation> */
    private array $compositions = [];

    /** @var array<LotFabricant> */
    private array $lots = [];

    /** @var array<AnalyseEffluent> */
    private array $analysesEffluent = [];

    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $refIntervention = null,
        public readonly ?string $codeTypeIntrant = null,
        public readonly ?string $designation = null,
        public readonly ?float $quantite = null,
        public readonly ?string $codeUnite = null,
        public readonly ?string $codeAMM = null,
        public readonly ?string $codeGNIS = null,
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser */
        public readonly ?string $codeVariete = null,
        public readonly ?string $codeApportOrganique = null,
        public readonly ?string $codeEAU = null,
        public readonly ?string $codeAdjuvant = null,
        public readonly ?string $codeCalcoMagnesien = null,
        /** Qualifiant (1) de l'effluent (positions 187-189 du guide v0.95) */
        public readonly ?string $codeQualifiantIntrant = null,
        public readonly ?string $codeEAN = null,
        public readonly ?string $codeQualifiantEffluent2 = null,
        public readonly ?string $codeQualifiantEffluent3 = null,
        public readonly ?string $codeQualifiantEffluent4 = null,
        public readonly ?string $codeQualifiantEffluent5 = null,
        public readonly ?string $codeQualifiantSemence1 = null,
        public readonly ?string $codeQualifiantSemence2 = null,
        public readonly ?string $codeQualifiantSemence3 = null,
        public readonly ?float $quantiteEffectiveHa = null,
        public readonly ?string $codeUniteQuantiteEffectiveHa = null,
        public readonly ?float $doseHaVisee = null,
        public readonly ?string $codeUniteDoseHaVisee = null,
        public readonly ?float $nombrePassagesPreconises = null,
        public readonly ?string $origineEffluentRaisonSociale1 = null,
        public readonly ?string $origineEffluentRaisonSociale2 = null,
        public readonly ?string $origineEffluentAdresse1 = null,
        public readonly ?string $origineEffluentAdresse2 = null,
        public readonly ?string $origineEffluentVille = null,
        public readonly ?string $origineEffluentCodePostal = null,
        public readonly ?string $origineEffluentPays = null,
        public readonly ?float $densiteVolumique = null,
    ) {
    }

    public function addComposition(CompositionFertilisation $composition): void
    {
        $this->compositions[] = $composition;
    }

    /**
     * @return array<CompositionFertilisation>
     */
    public function getCompositions(): array
    {
        return $this->compositions;
    }

    public function addLot(LotFabricant $lot): void
    {
        $this->lots[] = $lot;
    }

    /**
     * @return array<LotFabricant>
     */
    public function getLots(): array
    {
        return $this->lots;
    }

    public function addAnalyseEffluent(AnalyseEffluent $analyse): void
    {
        $this->analysesEffluent[] = $analyse;
    }

    /**
     * @return array<AnalyseEffluent>
     */
    public function getAnalysesEffluent(): array
    {
        return $this->analysesEffluent;
    }

    public function isPhytosanitaire(): bool
    {
        return in_array($this->codeTypeIntrant, [
            self::TYPE_ZIU,
            self::TYPE_ZIV,
            self::TYPE_ZIW,
            self::TYPE_ZIX,
            self::TYPE_ZIY,
            self::TYPE_ZIZ,
            self::TYPE_ZJG,
            self::TYPE_ZQG,
        ], true);
    }

    public function isSemence(): bool
    {
        return in_array($this->codeTypeIntrant, [self::TYPE_ZJF, self::TYPE_ZJT], true);
    }

    public function isEngrais(): bool
    {
        return self::TYPE_ZJC === $this->codeTypeIntrant;
    }

    public function isIrrigation(): bool
    {
        return self::TYPE_ZJE === $this->codeTypeIntrant;
    }
}
