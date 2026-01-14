<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Intervention;

use YoanBernabeu\DaplosBundle\DTO\Intrant\Intrant;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Coordonnee;
use YoanBernabeu\DaplosBundle\DTO\Recolte\Recolte;

/**
 * DTO pour le FLAG PV (Evenement/Intervention).
 */
final class Evenement
{
    /** @var array<Intrant> */
    private array $intrants = [];

    /** @var array<Recolte> */
    private array $recoltes = [];

    /** @var array<CibleEvenement> */
    private array $cibles = [];

    /** @var array<Coordonnee> */
    private array $coordonnees = [];

    private ?HistoriqueDecision $historiqueDecision = null;

    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $refIntervention = null,
        public readonly ?string $codeIntervention = null,
        public readonly ?string $codeCategorieIntervention = null,
        public readonly ?string $libelleIntervention = null,
        public readonly ?\DateTimeImmutable $dateDebutIntervention = null,
        public readonly ?\DateTimeImmutable $dateFinIntervention = null,
        public readonly ?string $codeStatutIntervention = null,
        public readonly ?string $codeJustificationIntervention = null,
        public readonly ?string $codeStadeVegetatif = null,
        public readonly ?string $libelleStadeVegetatif = null,
        public readonly ?string $codeConditionsMeteo = null,
        public readonly ?string $commentaire = null,
        public readonly ?float $surfaceTraitee = null,
        public readonly ?string $codeJustificationCible = null,
    ) {
    }

    public function addIntrant(Intrant $intrant): void
    {
        $this->intrants[] = $intrant;
    }

    /**
     * @return array<Intrant>
     */
    public function getIntrants(): array
    {
        return $this->intrants;
    }

    public function addRecolte(Recolte $recolte): void
    {
        $this->recoltes[] = $recolte;
    }

    /**
     * @return array<Recolte>
     */
    public function getRecoltes(): array
    {
        return $this->recoltes;
    }

    public function addCible(CibleEvenement $cible): void
    {
        $this->cibles[] = $cible;
    }

    /**
     * @return array<CibleEvenement>
     */
    public function getCibles(): array
    {
        return $this->cibles;
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

    public function setHistoriqueDecision(HistoriqueDecision $historique): void
    {
        $this->historiqueDecision = $historique;
    }

    public function getHistoriqueDecision(): ?HistoriqueDecision
    {
        return $this->historiqueDecision;
    }
}
