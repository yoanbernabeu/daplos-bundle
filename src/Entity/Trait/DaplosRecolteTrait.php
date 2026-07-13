<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Recolte\Recolte;

/**
 * Trait pour les entités représentant une récolte DAPLOS.
 *
 * Usage:
 *   use DaplosRecolteTrait;
 *
 * L'entité aura alors les propriétés standard d'une récolte DAPLOS :
 *   - daplosIdentifiantParcelle : Identifiant de la parcelle
 *   - daplosAnnee : Année de campagne
 *   - daplosRefIntervention : Référence de l'intervention
 *   - daplosCodeTypeProduitRecolte : Code type de produit récolté
 *   - etc.
 *
 * @author Yoan Bernabeu
 */
trait DaplosRecolteTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $daplosRefIntervention = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeTypeProduitRecolte = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeEspeceBotanique = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosLibelleProduit = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosQuantite = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeUnite = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $daplosDestinationProduit = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosRendementCalcule = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeUniteRendementCalcule = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosRendementEstime = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeUniteRendementEstime = null;

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

    public function getDaplosCodeTypeProduitRecolte(): ?string
    {
        return $this->daplosCodeTypeProduitRecolte;
    }

    public function setDaplosCodeTypeProduitRecolte(?string $daplosCodeTypeProduitRecolte): static
    {
        $this->daplosCodeTypeProduitRecolte = $daplosCodeTypeProduitRecolte;

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

    public function getDaplosLibelleProduit(): ?string
    {
        return $this->daplosLibelleProduit;
    }

    public function setDaplosLibelleProduit(?string $daplosLibelleProduit): static
    {
        $this->daplosLibelleProduit = $daplosLibelleProduit;

        return $this;
    }

    public function getDaplosQuantite(): ?string
    {
        return $this->daplosQuantite;
    }

    public function setDaplosQuantite(float|string|null $daplosQuantite): static
    {
        $this->daplosQuantite = null !== $daplosQuantite ? (string) $daplosQuantite : null;

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

    public function getDaplosDestinationProduit(): ?string
    {
        return $this->daplosDestinationProduit;
    }

    public function setDaplosDestinationProduit(?string $daplosDestinationProduit): static
    {
        $this->daplosDestinationProduit = $daplosDestinationProduit;

        return $this;
    }

    public function getDaplosRendementCalcule(): ?string
    {
        return $this->daplosRendementCalcule;
    }

    public function setDaplosRendementCalcule(float|string|null $daplosRendementCalcule): static
    {
        $this->daplosRendementCalcule = null !== $daplosRendementCalcule ? (string) $daplosRendementCalcule : null;

        return $this;
    }

    public function getDaplosCodeUniteRendementCalcule(): ?string
    {
        return $this->daplosCodeUniteRendementCalcule;
    }

    public function setDaplosCodeUniteRendementCalcule(?string $daplosCodeUniteRendementCalcule): static
    {
        $this->daplosCodeUniteRendementCalcule = $daplosCodeUniteRendementCalcule;

        return $this;
    }

    public function getDaplosRendementEstime(): ?string
    {
        return $this->daplosRendementEstime;
    }

    public function setDaplosRendementEstime(float|string|null $daplosRendementEstime): static
    {
        $this->daplosRendementEstime = null !== $daplosRendementEstime ? (string) $daplosRendementEstime : null;

        return $this;
    }

    public function getDaplosCodeUniteRendementEstime(): ?string
    {
        return $this->daplosCodeUniteRendementEstime;
    }

    public function setDaplosCodeUniteRendementEstime(?string $daplosCodeUniteRendementEstime): static
    {
        $this->daplosCodeUniteRendementEstime = $daplosCodeUniteRendementEstime;

        return $this;
    }

    /**
     * Hydrate l'entité depuis un DTO Recolte.
     */
    public function hydrateFromDaplosRecolte(Recolte $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosRefIntervention = $dto->refIntervention;
        $this->daplosCodeTypeProduitRecolte = $dto->codeTypeProduitRecolte;
        $this->daplosCodeEspeceBotanique = $dto->codeEspeceBotanique;
        $this->daplosLibelleProduit = $dto->libelleProduit;
        $this->daplosQuantite = null !== $dto->quantite ? (string) $dto->quantite : null;
        $this->daplosCodeUnite = $dto->codeUnite;
        $this->daplosDestinationProduit = $dto->destinationProduit;
        $this->daplosRendementCalcule = null !== $dto->rendementCalcule ? (string) $dto->rendementCalcule : null;
        $this->daplosCodeUniteRendementCalcule = $dto->codeUniteRendementCalcule;
        $this->daplosRendementEstime = null !== $dto->rendementEstime ? (string) $dto->rendementEstime : null;
        $this->daplosCodeUniteRendementEstime = $dto->codeUniteRendementEstime;

        return $this;
    }
}
