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
        public readonly ?int $anneePrecedent = null,
        public readonly ?string $codeEspeceBotanique = null,
        public readonly ?string $codeTraitementResidus = null,
        public readonly ?string $codeModeProduction = null,
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
