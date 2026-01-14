<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO;

use YoanBernabeu\DaplosBundle\DTO\Document\DocumentHeader;
use YoanBernabeu\DaplosBundle\DTO\Document\Intervenant;
use YoanBernabeu\DaplosBundle\DTO\Document\TypeAgriculture;
use YoanBernabeu\DaplosBundle\DTO\Interchange\InterchangeHeader;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;

/**
 * DTO representant un document DAPLOS complet.
 */
final class DaplosDocument
{
    /**
     * @param array<Intervenant>       $intervenants
     * @param array<TypeAgriculture>   $typesAgriculture
     * @param array<ParcelleCulturale> $parcelles
     */
    public function __construct(
        public readonly ?InterchangeHeader $interchange = null,
        public readonly ?DocumentHeader $header = null,
        public readonly array $intervenants = [],
        public readonly array $typesAgriculture = [],
        public readonly array $parcelles = [],
        public readonly ?string $sourceFile = null,
    ) {
    }

    /**
     * Retourne l'exploitant (intervenant de type TF).
     */
    public function getExploitant(): ?Intervenant
    {
        foreach ($this->intervenants as $intervenant) {
            if ($intervenant->isExploitant()) {
                return $intervenant;
            }
        }

        return null;
    }

    /**
     * Retourne le fournisseur (intervenant de type FR ou SU).
     */
    public function getFournisseur(): ?Intervenant
    {
        foreach ($this->intervenants as $intervenant) {
            if ($intervenant->isFournisseur()) {
                return $intervenant;
            }
        }

        return null;
    }

    /**
     * Retourne le mandataire (intervenant de type MR).
     */
    public function getMandataire(): ?Intervenant
    {
        foreach ($this->intervenants as $intervenant) {
            if ($intervenant->isMandataire()) {
                return $intervenant;
            }
        }

        return null;
    }

    /**
     * Compte le nombre total de parcelles.
     */
    public function countParcelles(): int
    {
        return count($this->parcelles);
    }

    /**
     * Compte le nombre total d'interventions.
     */
    public function countInterventions(): int
    {
        $count = 0;
        foreach ($this->parcelles as $parcelle) {
            $count += count($parcelle->getEvenements());
        }

        return $count;
    }

    /**
     * Retourne la version du format DAPLOS.
     */
    public function getVersion(): ?string
    {
        return $this->header?->versionFormat;
    }
}
