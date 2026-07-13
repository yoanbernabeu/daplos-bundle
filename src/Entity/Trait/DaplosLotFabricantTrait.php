<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Intrant\LotFabricant;

/**
 * Trait pour les entités représentant un lot fabricant DAPLOS.
 *
 * Usage:
 *   use DaplosLotFabricantTrait;
 *
 * L'entité aura alors les propriétés standard d'un lot fabricant DAPLOS :
 *   - daplosIdentifiantParcelle : Identifiant de la parcelle
 *   - daplosAnnee : Année de campagne
 *   - daplosRefIntervention : Référence de l'intervention
 *   - daplosNumeroLot : Numéro de lot fabricant
 *   - etc.
 *
 * @author Yoan Bernabeu
 */
trait DaplosLotFabricantTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $daplosRefIntervention = null;

    /**
     * @deprecated champ hors guide v0.95, plus jamais rempli par le parser (voir $daplosCodeProduit)
     */
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosIndexLot = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $daplosNumeroLot = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosQuantite = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeUnite = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosCodeProduit = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosPmg = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeUnitePmg = null;

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

    public function getDaplosIndexLot(): ?int
    {
        return $this->daplosIndexLot;
    }

    public function setDaplosIndexLot(?int $daplosIndexLot): static
    {
        $this->daplosIndexLot = $daplosIndexLot;

        return $this;
    }

    public function getDaplosNumeroLot(): ?string
    {
        return $this->daplosNumeroLot;
    }

    public function setDaplosNumeroLot(?string $daplosNumeroLot): static
    {
        $this->daplosNumeroLot = $daplosNumeroLot;

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

    public function getDaplosCodeProduit(): ?string
    {
        return $this->daplosCodeProduit;
    }

    public function setDaplosCodeProduit(?string $daplosCodeProduit): static
    {
        $this->daplosCodeProduit = $daplosCodeProduit;

        return $this;
    }

    public function getDaplosPmg(): ?string
    {
        return $this->daplosPmg;
    }

    public function setDaplosPmg(float|string|null $daplosPmg): static
    {
        $this->daplosPmg = null !== $daplosPmg ? (string) $daplosPmg : null;

        return $this;
    }

    public function getDaplosCodeUnitePmg(): ?string
    {
        return $this->daplosCodeUnitePmg;
    }

    public function setDaplosCodeUnitePmg(?string $daplosCodeUnitePmg): static
    {
        $this->daplosCodeUnitePmg = $daplosCodeUnitePmg;

        return $this;
    }

    /**
     * Hydrate l'entité depuis un DTO LotFabricant.
     */
    public function hydrateFromDaplosLotFabricant(LotFabricant $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosRefIntervention = $dto->refIntervention;
        $this->daplosIndexLot = $dto->indexLot;
        $this->daplosNumeroLot = $dto->numeroLot;
        $this->daplosQuantite = null !== $dto->quantite ? (string) $dto->quantite : null;
        $this->daplosCodeUnite = $dto->codeUnite;
        $this->daplosCodeProduit = $dto->codeProduit;
        $this->daplosPmg = null !== $dto->pmg ? (string) $dto->pmg : null;
        $this->daplosCodeUnitePmg = $dto->codeUnitePmg;

        return $this;
    }
}
