<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Intrant\Intrant;

/**
 * Trait pour les entités représentant un intrant DAPLOS.
 *
 * Usage:
 *   use DaplosIntrantTrait;
 *
 * L'entité aura alors les propriétés standard d'un intrant DAPLOS :
 *   - daplosCodeTypeIntrant : Code de la famille d'intrant
 *   - daplosDesignation : Nom commercial
 *   - daplosQuantite : Quantité appliquée
 *   - etc.
 *
 * @author Yoan Bernabeu
 */
trait DaplosIntrantTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $daplosRefIntervention = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeTypeIntrant = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosDesignation = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?float $daplosQuantite = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeUnite = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosCodeAMM = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $daplosCodeGNIS = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $daplosCodeVariete = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosCodeApportOrganique = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosCodeEAU = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosCodeAdjuvant = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeQualifiantIntrant = null;

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

    public function getDaplosCodeTypeIntrant(): ?string
    {
        return $this->daplosCodeTypeIntrant;
    }

    public function setDaplosCodeTypeIntrant(?string $daplosCodeTypeIntrant): static
    {
        $this->daplosCodeTypeIntrant = $daplosCodeTypeIntrant;

        return $this;
    }

    public function getDaplosDesignation(): ?string
    {
        return $this->daplosDesignation;
    }

    public function setDaplosDesignation(?string $daplosDesignation): static
    {
        $this->daplosDesignation = $daplosDesignation;

        return $this;
    }

    public function getDaplosQuantite(): ?float
    {
        return $this->daplosQuantite;
    }

    public function setDaplosQuantite(?float $daplosQuantite): static
    {
        $this->daplosQuantite = $daplosQuantite;

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

    public function getDaplosCodeAMM(): ?string
    {
        return $this->daplosCodeAMM;
    }

    public function setDaplosCodeAMM(?string $daplosCodeAMM): static
    {
        $this->daplosCodeAMM = $daplosCodeAMM;

        return $this;
    }

    public function getDaplosCodeGNIS(): ?string
    {
        return $this->daplosCodeGNIS;
    }

    public function setDaplosCodeGNIS(?string $daplosCodeGNIS): static
    {
        $this->daplosCodeGNIS = $daplosCodeGNIS;

        return $this;
    }

    public function getDaplosCodeVariete(): ?string
    {
        return $this->daplosCodeVariete;
    }

    public function setDaplosCodeVariete(?string $daplosCodeVariete): static
    {
        $this->daplosCodeVariete = $daplosCodeVariete;

        return $this;
    }

    public function getDaplosCodeApportOrganique(): ?string
    {
        return $this->daplosCodeApportOrganique;
    }

    public function setDaplosCodeApportOrganique(?string $daplosCodeApportOrganique): static
    {
        $this->daplosCodeApportOrganique = $daplosCodeApportOrganique;

        return $this;
    }

    public function getDaplosCodeEAU(): ?string
    {
        return $this->daplosCodeEAU;
    }

    public function setDaplosCodeEAU(?string $daplosCodeEAU): static
    {
        $this->daplosCodeEAU = $daplosCodeEAU;

        return $this;
    }

    public function getDaplosCodeAdjuvant(): ?string
    {
        return $this->daplosCodeAdjuvant;
    }

    public function setDaplosCodeAdjuvant(?string $daplosCodeAdjuvant): static
    {
        $this->daplosCodeAdjuvant = $daplosCodeAdjuvant;

        return $this;
    }

    public function getDaplosCodeQualifiantIntrant(): ?string
    {
        return $this->daplosCodeQualifiantIntrant;
    }

    public function setDaplosCodeQualifiantIntrant(?string $daplosCodeQualifiantIntrant): static
    {
        $this->daplosCodeQualifiantIntrant = $daplosCodeQualifiantIntrant;

        return $this;
    }

    /**
     * Vérifie si l'intrant est un produit phytosanitaire.
     */
    public function isDaplosPhytosanitaire(): bool
    {
        return in_array($this->daplosCodeTypeIntrant, [
            Intrant::TYPE_ZIU,
            Intrant::TYPE_ZIV,
            Intrant::TYPE_ZIW,
            Intrant::TYPE_ZIX,
            Intrant::TYPE_ZIY,
            Intrant::TYPE_ZIZ,
            Intrant::TYPE_ZJG,
            Intrant::TYPE_ZQG,
        ], true);
    }

    /**
     * Vérifie si l'intrant est une semence ou un plant.
     */
    public function isDaplosSemence(): bool
    {
        return in_array($this->daplosCodeTypeIntrant, [
            Intrant::TYPE_ZJF,
            Intrant::TYPE_ZJT,
        ], true);
    }

    /**
     * Vérifie si l'intrant est un engrais minéral.
     */
    public function isDaplosEngrais(): bool
    {
        return Intrant::TYPE_ZJC === $this->daplosCodeTypeIntrant;
    }

    /**
     * Vérifie si l'intrant est de l'irrigation.
     */
    public function isDaplosIrrigation(): bool
    {
        return Intrant::TYPE_ZJE === $this->daplosCodeTypeIntrant;
    }

    /**
     * Hydrate l'entité depuis un DTO Intrant.
     */
    public function hydrateFromDaplosIntrant(Intrant $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosRefIntervention = $dto->refIntervention;
        $this->daplosCodeTypeIntrant = $dto->codeTypeIntrant;
        $this->daplosDesignation = $dto->designation;
        $this->daplosQuantite = $dto->quantite;
        $this->daplosCodeUnite = $dto->codeUnite;
        $this->daplosCodeAMM = $dto->codeAMM;
        $this->daplosCodeGNIS = $dto->codeGNIS;
        $this->daplosCodeVariete = $dto->codeVariete;
        $this->daplosCodeApportOrganique = $dto->codeApportOrganique;
        $this->daplosCodeEAU = $dto->codeEAU;
        $this->daplosCodeAdjuvant = $dto->codeAdjuvant;
        $this->daplosCodeQualifiantIntrant = $dto->codeQualifiantIntrant;

        return $this;
    }
}
