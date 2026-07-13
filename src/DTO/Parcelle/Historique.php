<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Parcelle;

/**
 * DTO pour le FLAG PH (Historique/Precedent cultural).
 */
final class Historique
{
    /** @var array<Amendement> */
    private array $amendements = [];

    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?int $indexPrecedent = null,
        /** @deprecated champ hors guide v0.95 (les positions 17-20 portent la clé de la parcelle du précédent), plus jamais rempli par le parser — voir $cleParcellePrecedent */
        public readonly ?int $anneePrecedent = null,
        public readonly ?string $codeEspeceBotanique = null,
        /** @deprecated champ hors guide v0.95 (les positions 24-26 portent la variété semée 1), plus jamais rempli par le parser — voir $codeGestionResidus */
        public readonly ?string $codeTraitementResidus = null,
        /** @deprecated champ hors guide v0.95 (les positions 27-29 portent la variété semée 1), plus jamais rempli par le parser */
        public readonly ?string $codeModeProduction = null,
        public readonly ?string $cleParcellePrecedent = null,
        public readonly ?string $varieteSemee1 = null,
        public readonly ?string $varieteSemee2 = null,
        public readonly ?string $varieteSemee3 = null,
        public readonly ?string $varieteSemee4 = null,
        public readonly ?string $varieteSemee5 = null,
        public readonly ?string $codeQualifiantEspece = null,
        public readonly ?string $codePeriodeSemis = null,
        public readonly ?string $codeDestination = null,
        public readonly ?string $codeGestionResidus = null,
        public readonly ?float $quantiteEpandue = null,
    ) {
    }

    public function addAmendement(Amendement $amendement): void
    {
        $this->amendements[] = $amendement;
    }

    /**
     * @return array<Amendement>
     */
    public function getAmendements(): array
    {
        return $this->amendements;
    }
}
