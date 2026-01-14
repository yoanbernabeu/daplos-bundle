<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\Context;

use YoanBernabeu\DaplosBundle\DTO\Document\DocumentHeader;
use YoanBernabeu\DaplosBundle\DTO\Document\Intervenant;
use YoanBernabeu\DaplosBundle\DTO\Document\TypeAgriculture;
use YoanBernabeu\DaplosBundle\DTO\Interchange\InterchangeHeader;
use YoanBernabeu\DaplosBundle\DTO\Intervention\CibleEvenement;
use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;
use YoanBernabeu\DaplosBundle\DTO\Intervention\HistoriqueDecision;
use YoanBernabeu\DaplosBundle\DTO\Intrant\AnalyseEffluent;
use YoanBernabeu\DaplosBundle\DTO\Intrant\CompositionFertilisation;
use YoanBernabeu\DaplosBundle\DTO\Intrant\Intrant;
use YoanBernabeu\DaplosBundle\DTO\Intrant\LotFabricant;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Amendement;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Analyse;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Coordonnee;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Engagement;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Historique;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCadastrale;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\SurfaceParcelle;
use YoanBernabeu\DaplosBundle\DTO\Recolte\CaracterisationProduit;
use YoanBernabeu\DaplosBundle\DTO\Recolte\LotRecolte;
use YoanBernabeu\DaplosBundle\DTO\Recolte\Recolte;

/**
 * Contexte de parsing pour gerer l'etat hierarchique pendant le parsing.
 *
 * Responsabilite unique : gerer l'etat et les relations parent-enfant.
 */
final class ParserContext
{
    private ?InterchangeHeader $interchange = null;
    private ?DocumentHeader $document = null;

    /** @var array<Intervenant> */
    private array $intervenants = [];

    /** @var array<TypeAgriculture> */
    private array $typesAgriculture = [];

    /** @var array<ParcelleCulturale> */
    private array $parcelles = [];

    // Contexte courant pour les relations hierarchiques
    private ?ParcelleCulturale $currentParcelle = null;
    private ?Evenement $currentEvenement = null;
    private ?Intrant $currentIntrant = null;
    private ?Recolte $currentRecolte = null;
    private ?Historique $currentHistorique = null;
    private ?SurfaceParcelle $currentSurface = null;
    private ?ParcelleCadastrale $currentParcelleCadastrale = null;

    public function setInterchange(InterchangeHeader $header): void
    {
        $this->interchange = $header;
    }

    public function getInterchange(): ?InterchangeHeader
    {
        return $this->interchange;
    }

    public function setDocument(DocumentHeader $header): void
    {
        $this->document = $header;
    }

    public function getDocument(): ?DocumentHeader
    {
        return $this->document;
    }

    public function addIntervenant(Intervenant $intervenant): void
    {
        $this->intervenants[] = $intervenant;
    }

    /**
     * @return array<Intervenant>
     */
    public function getIntervenants(): array
    {
        return $this->intervenants;
    }

    public function addTypeAgriculture(TypeAgriculture $type): void
    {
        $this->typesAgriculture[] = $type;
    }

    /**
     * @return array<TypeAgriculture>
     */
    public function getTypesAgriculture(): array
    {
        return $this->typesAgriculture;
    }

    public function addParcelle(ParcelleCulturale $parcelle): void
    {
        $this->parcelles[] = $parcelle;
        $this->currentParcelle = $parcelle;
        // Reset du contexte enfant
        $this->currentEvenement = null;
        $this->currentIntrant = null;
        $this->currentRecolte = null;
        $this->currentHistorique = null;
        $this->currentSurface = null;
        $this->currentParcelleCadastrale = null;
    }

    public function getCurrentParcelle(): ?ParcelleCulturale
    {
        return $this->currentParcelle;
    }

    /**
     * @return array<ParcelleCulturale>
     */
    public function getParcelles(): array
    {
        return $this->parcelles;
    }

    public function addSurface(SurfaceParcelle $surface): void
    {
        if (null !== $this->currentParcelle) {
            $this->currentParcelle->addSurface($surface);
            $this->currentSurface = $surface;
        }
    }

    public function getCurrentSurface(): ?SurfaceParcelle
    {
        return $this->currentSurface;
    }

    public function addCoordonnee(Coordonnee $coordonnee): void
    {
        // Les coordonnees peuvent etre liees a une surface (SC) ou une parcelle cadastrale (CC)
        if (null !== $this->currentSurface) {
            $this->currentSurface->addCoordonnee($coordonnee);
        } elseif (null !== $this->currentParcelleCadastrale) {
            $this->currentParcelleCadastrale->addCoordonnee($coordonnee);
        }
    }

    public function addParcelleCadastrale(ParcelleCadastrale $parcelleCadastrale): void
    {
        if (null !== $this->currentParcelle) {
            $this->currentParcelle->addParcelleCadastrale($parcelleCadastrale);
            $this->currentParcelleCadastrale = $parcelleCadastrale;
        }
    }

    public function addEngagement(Engagement $engagement): void
    {
        if (null !== $this->currentParcelle) {
            $this->currentParcelle->addEngagement($engagement);
        }
    }

    public function addHistorique(Historique $historique): void
    {
        if (null !== $this->currentParcelle) {
            $this->currentParcelle->addHistorique($historique);
            $this->currentHistorique = $historique;
        }
    }

    public function getCurrentHistorique(): ?Historique
    {
        return $this->currentHistorique;
    }

    public function addAmendement(Amendement $amendement): void
    {
        if (null !== $this->currentHistorique) {
            $this->currentHistorique->addAmendement($amendement);
        }
    }

    public function addAnalyse(Analyse $analyse): void
    {
        if (null !== $this->currentParcelle) {
            $this->currentParcelle->addAnalyse($analyse);
        }
    }

    public function addEvenement(Evenement $evenement): void
    {
        if (null !== $this->currentParcelle) {
            $this->currentParcelle->addEvenement($evenement);
            $this->currentEvenement = $evenement;
            // Reset du contexte enfant
            $this->currentIntrant = null;
            $this->currentRecolte = null;
        }
    }

    public function getCurrentEvenement(): ?Evenement
    {
        return $this->currentEvenement;
    }

    public function addCibleEvenement(CibleEvenement $cible): void
    {
        if (null !== $this->currentEvenement) {
            $this->currentEvenement->addCible($cible);
        }
    }

    public function addHistoriqueDecision(HistoriqueDecision $historique): void
    {
        if (null !== $this->currentEvenement) {
            $this->currentEvenement->setHistoriqueDecision($historique);
        }
    }

    public function addCoordonneeIntervention(Coordonnee $coordonnee): void
    {
        if (null !== $this->currentEvenement) {
            $this->currentEvenement->addCoordonnee($coordonnee);
        }
    }

    public function addIntrant(Intrant $intrant): void
    {
        if (null !== $this->currentEvenement) {
            $this->currentEvenement->addIntrant($intrant);
            $this->currentIntrant = $intrant;
        }
    }

    public function getCurrentIntrant(): ?Intrant
    {
        return $this->currentIntrant;
    }

    public function addCompositionFertilisation(CompositionFertilisation $composition): void
    {
        if (null !== $this->currentIntrant) {
            $this->currentIntrant->addComposition($composition);
        }
    }

    public function addLotFabricant(LotFabricant $lot): void
    {
        if (null !== $this->currentIntrant) {
            $this->currentIntrant->addLot($lot);
        }
    }

    public function addAnalyseEffluent(AnalyseEffluent $analyse): void
    {
        if (null !== $this->currentIntrant) {
            $this->currentIntrant->addAnalyseEffluent($analyse);
        }
    }

    public function addRecolte(Recolte $recolte): void
    {
        if (null !== $this->currentEvenement) {
            $this->currentEvenement->addRecolte($recolte);
            $this->currentRecolte = $recolte;
        }
    }

    public function getCurrentRecolte(): ?Recolte
    {
        return $this->currentRecolte;
    }

    public function addLotRecolte(LotRecolte $lot): void
    {
        if (null !== $this->currentRecolte) {
            $this->currentRecolte->addLot($lot);
        }
    }

    public function addCaracterisationProduit(CaracterisationProduit $caracterisation): void
    {
        if (null !== $this->currentRecolte) {
            $this->currentRecolte->addCaracterisation($caracterisation);
        }
    }
}
