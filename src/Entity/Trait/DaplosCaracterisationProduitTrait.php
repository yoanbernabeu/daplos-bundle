<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Recolte\CaracterisationProduit;

/**
 * Trait pour les entités représentant une caractérisation de produit DAPLOS.
 *
 * Usage:
 *   use DaplosCaracterisationProduitTrait;
 *
 * L'entité aura alors les propriétés standard d'une caractérisation DAPLOS :
 *   - daplosIdentifiantParcelle : Identifiant de la parcelle
 *   - daplosAnnee : Année de campagne
 *   - daplosRefIntervention : Référence de l'intervention
 *   - daplosCodeCaracteristique : Code de la caractéristique
 *   - daplosValeur : Valeur de la caractéristique
 *   - etc.
 *
 * @author Yoan Bernabeu
 */
trait DaplosCaracterisationProduitTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $daplosRefIntervention = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosCodeCaracteristique = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosValeur = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeUnite = null;

    public function getDaplosIdentifiantParcelle(): ?string
    {
        return $this->daplosIdentifiantParcelle;
    }

    public function setDaplosIdentifiantParcelle(?string $daplosIdentifiantParcelle): static
    {
        $this->daplosIdentifiantParcelle = $daplosIdentifiantParcelle;

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

    public function getDaplosRefIntervention(): ?string
    {
        return $this->daplosRefIntervention;
    }

    public function setDaplosRefIntervention(?string $daplosRefIntervention): static
    {
        $this->daplosRefIntervention = $daplosRefIntervention;

        return $this;
    }

    public function getDaplosCodeCaracteristique(): ?string
    {
        return $this->daplosCodeCaracteristique;
    }

    public function setDaplosCodeCaracteristique(?string $daplosCodeCaracteristique): static
    {
        $this->daplosCodeCaracteristique = $daplosCodeCaracteristique;

        return $this;
    }

    public function getDaplosValeur(): ?string
    {
        return $this->daplosValeur;
    }

    public function setDaplosValeur(?string $daplosValeur): static
    {
        $this->daplosValeur = $daplosValeur;

        return $this;
    }

    public function getDaplosCodeUnite(): ?string
    {
        return $this->daplosCodeUnite;
    }

    public function setDaplosCodeUnite(?string $daplosCodeUnite): static
    {
        $this->daplosCodeUnite = $daplosCodeUnite;

        return $this;
    }

    /**
     * Hydrate l'entité depuis un DTO CaracterisationProduit.
     */
    public function hydrateFromDaplosCaracterisationProduit(CaracterisationProduit $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosRefIntervention = $dto->refIntervention;
        $this->daplosCodeCaracteristique = $dto->codeCaracteristique;
        $this->daplosValeur = $dto->valeur;
        $this->daplosCodeUnite = $dto->codeUnite;

        return $this;
    }
}
