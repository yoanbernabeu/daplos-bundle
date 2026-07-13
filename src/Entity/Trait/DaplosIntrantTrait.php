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
    private ?string $daplosQuantite = null;

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

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeCalcoMagnesien = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosCodeEAN = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeQualifiantEffluent2 = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeQualifiantEffluent3 = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeQualifiantEffluent4 = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeQualifiantEffluent5 = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeQualifiantSemence1 = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeQualifiantSemence2 = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeQualifiantSemence3 = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosQuantiteEffectiveHa = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeUniteQuantiteEffectiveHa = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosDoseHaVisee = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeUniteDoseHaVisee = null;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2, nullable: true)]
    private ?string $daplosNombrePassagesPreconises = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosOrigineEffluentRaisonSociale1 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosOrigineEffluentRaisonSociale2 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosOrigineEffluentAdresse1 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosOrigineEffluentAdresse2 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosOrigineEffluentVille = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosOrigineEffluentCodePostal = null;

    #[ORM\Column(type: 'string', length: 2, nullable: true)]
    private ?string $daplosOrigineEffluentPays = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosDensiteVolumique = null;

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

    public function getDaplosCodeCalcoMagnesien(): ?string
    {
        return $this->daplosCodeCalcoMagnesien;
    }

    public function setDaplosCodeCalcoMagnesien(?string $daplosCodeCalcoMagnesien): static
    {
        $this->daplosCodeCalcoMagnesien = $daplosCodeCalcoMagnesien;

        return $this;
    }

    public function getDaplosCodeEAN(): ?string
    {
        return $this->daplosCodeEAN;
    }

    public function setDaplosCodeEAN(?string $daplosCodeEAN): static
    {
        $this->daplosCodeEAN = $daplosCodeEAN;

        return $this;
    }

    public function getDaplosCodeQualifiantEffluent2(): ?string
    {
        return $this->daplosCodeQualifiantEffluent2;
    }

    public function setDaplosCodeQualifiantEffluent2(?string $daplosCodeQualifiantEffluent2): static
    {
        $this->daplosCodeQualifiantEffluent2 = $daplosCodeQualifiantEffluent2;

        return $this;
    }

    public function getDaplosCodeQualifiantEffluent3(): ?string
    {
        return $this->daplosCodeQualifiantEffluent3;
    }

    public function setDaplosCodeQualifiantEffluent3(?string $daplosCodeQualifiantEffluent3): static
    {
        $this->daplosCodeQualifiantEffluent3 = $daplosCodeQualifiantEffluent3;

        return $this;
    }

    public function getDaplosCodeQualifiantEffluent4(): ?string
    {
        return $this->daplosCodeQualifiantEffluent4;
    }

    public function setDaplosCodeQualifiantEffluent4(?string $daplosCodeQualifiantEffluent4): static
    {
        $this->daplosCodeQualifiantEffluent4 = $daplosCodeQualifiantEffluent4;

        return $this;
    }

    public function getDaplosCodeQualifiantEffluent5(): ?string
    {
        return $this->daplosCodeQualifiantEffluent5;
    }

    public function setDaplosCodeQualifiantEffluent5(?string $daplosCodeQualifiantEffluent5): static
    {
        $this->daplosCodeQualifiantEffluent5 = $daplosCodeQualifiantEffluent5;

        return $this;
    }

    public function getDaplosCodeQualifiantSemence1(): ?string
    {
        return $this->daplosCodeQualifiantSemence1;
    }

    public function setDaplosCodeQualifiantSemence1(?string $daplosCodeQualifiantSemence1): static
    {
        $this->daplosCodeQualifiantSemence1 = $daplosCodeQualifiantSemence1;

        return $this;
    }

    public function getDaplosCodeQualifiantSemence2(): ?string
    {
        return $this->daplosCodeQualifiantSemence2;
    }

    public function setDaplosCodeQualifiantSemence2(?string $daplosCodeQualifiantSemence2): static
    {
        $this->daplosCodeQualifiantSemence2 = $daplosCodeQualifiantSemence2;

        return $this;
    }

    public function getDaplosCodeQualifiantSemence3(): ?string
    {
        return $this->daplosCodeQualifiantSemence3;
    }

    public function setDaplosCodeQualifiantSemence3(?string $daplosCodeQualifiantSemence3): static
    {
        $this->daplosCodeQualifiantSemence3 = $daplosCodeQualifiantSemence3;

        return $this;
    }

    public function getDaplosQuantiteEffectiveHa(): ?string
    {
        return $this->daplosQuantiteEffectiveHa;
    }

    public function setDaplosQuantiteEffectiveHa(float|string|null $daplosQuantiteEffectiveHa): static
    {
        $this->daplosQuantiteEffectiveHa = null !== $daplosQuantiteEffectiveHa ? (string) $daplosQuantiteEffectiveHa : null;

        return $this;
    }

    public function getDaplosCodeUniteQuantiteEffectiveHa(): ?string
    {
        return $this->daplosCodeUniteQuantiteEffectiveHa;
    }

    public function setDaplosCodeUniteQuantiteEffectiveHa(?string $daplosCodeUniteQuantiteEffectiveHa): static
    {
        $this->daplosCodeUniteQuantiteEffectiveHa = $daplosCodeUniteQuantiteEffectiveHa;

        return $this;
    }

    public function getDaplosDoseHaVisee(): ?string
    {
        return $this->daplosDoseHaVisee;
    }

    public function setDaplosDoseHaVisee(float|string|null $daplosDoseHaVisee): static
    {
        $this->daplosDoseHaVisee = null !== $daplosDoseHaVisee ? (string) $daplosDoseHaVisee : null;

        return $this;
    }

    public function getDaplosCodeUniteDoseHaVisee(): ?string
    {
        return $this->daplosCodeUniteDoseHaVisee;
    }

    public function setDaplosCodeUniteDoseHaVisee(?string $daplosCodeUniteDoseHaVisee): static
    {
        $this->daplosCodeUniteDoseHaVisee = $daplosCodeUniteDoseHaVisee;

        return $this;
    }

    public function getDaplosNombrePassagesPreconises(): ?string
    {
        return $this->daplosNombrePassagesPreconises;
    }

    public function setDaplosNombrePassagesPreconises(float|string|null $daplosNombrePassagesPreconises): static
    {
        $this->daplosNombrePassagesPreconises = null !== $daplosNombrePassagesPreconises ? (string) $daplosNombrePassagesPreconises : null;

        return $this;
    }

    public function getDaplosOrigineEffluentRaisonSociale1(): ?string
    {
        return $this->daplosOrigineEffluentRaisonSociale1;
    }

    public function setDaplosOrigineEffluentRaisonSociale1(?string $daplosOrigineEffluentRaisonSociale1): static
    {
        $this->daplosOrigineEffluentRaisonSociale1 = $daplosOrigineEffluentRaisonSociale1;

        return $this;
    }

    public function getDaplosOrigineEffluentRaisonSociale2(): ?string
    {
        return $this->daplosOrigineEffluentRaisonSociale2;
    }

    public function setDaplosOrigineEffluentRaisonSociale2(?string $daplosOrigineEffluentRaisonSociale2): static
    {
        $this->daplosOrigineEffluentRaisonSociale2 = $daplosOrigineEffluentRaisonSociale2;

        return $this;
    }

    public function getDaplosOrigineEffluentAdresse1(): ?string
    {
        return $this->daplosOrigineEffluentAdresse1;
    }

    public function setDaplosOrigineEffluentAdresse1(?string $daplosOrigineEffluentAdresse1): static
    {
        $this->daplosOrigineEffluentAdresse1 = $daplosOrigineEffluentAdresse1;

        return $this;
    }

    public function getDaplosOrigineEffluentAdresse2(): ?string
    {
        return $this->daplosOrigineEffluentAdresse2;
    }

    public function setDaplosOrigineEffluentAdresse2(?string $daplosOrigineEffluentAdresse2): static
    {
        $this->daplosOrigineEffluentAdresse2 = $daplosOrigineEffluentAdresse2;

        return $this;
    }

    public function getDaplosOrigineEffluentVille(): ?string
    {
        return $this->daplosOrigineEffluentVille;
    }

    public function setDaplosOrigineEffluentVille(?string $daplosOrigineEffluentVille): static
    {
        $this->daplosOrigineEffluentVille = $daplosOrigineEffluentVille;

        return $this;
    }

    public function getDaplosOrigineEffluentCodePostal(): ?string
    {
        return $this->daplosOrigineEffluentCodePostal;
    }

    public function setDaplosOrigineEffluentCodePostal(?string $daplosOrigineEffluentCodePostal): static
    {
        $this->daplosOrigineEffluentCodePostal = $daplosOrigineEffluentCodePostal;

        return $this;
    }

    public function getDaplosOrigineEffluentPays(): ?string
    {
        return $this->daplosOrigineEffluentPays;
    }

    public function setDaplosOrigineEffluentPays(?string $daplosOrigineEffluentPays): static
    {
        $this->daplosOrigineEffluentPays = $daplosOrigineEffluentPays;

        return $this;
    }

    public function getDaplosDensiteVolumique(): ?string
    {
        return $this->daplosDensiteVolumique;
    }

    public function setDaplosDensiteVolumique(float|string|null $daplosDensiteVolumique): static
    {
        $this->daplosDensiteVolumique = null !== $daplosDensiteVolumique ? (string) $daplosDensiteVolumique : null;

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
        $this->daplosQuantite = null !== $dto->quantite ? (string) $dto->quantite : null;
        $this->daplosCodeUnite = $dto->codeUnite;
        $this->daplosCodeAMM = $dto->codeAMM;
        $this->daplosCodeGNIS = $dto->codeGNIS;
        $this->daplosCodeVariete = $dto->codeVariete;
        $this->daplosCodeApportOrganique = $dto->codeApportOrganique;
        $this->daplosCodeEAU = $dto->codeEAU;
        $this->daplosCodeAdjuvant = $dto->codeAdjuvant;
        $this->daplosCodeQualifiantIntrant = $dto->codeQualifiantIntrant;
        $this->daplosCodeCalcoMagnesien = $dto->codeCalcoMagnesien;
        $this->daplosCodeEAN = $dto->codeEAN;
        $this->daplosCodeQualifiantEffluent2 = $dto->codeQualifiantEffluent2;
        $this->daplosCodeQualifiantEffluent3 = $dto->codeQualifiantEffluent3;
        $this->daplosCodeQualifiantEffluent4 = $dto->codeQualifiantEffluent4;
        $this->daplosCodeQualifiantEffluent5 = $dto->codeQualifiantEffluent5;
        $this->daplosCodeQualifiantSemence1 = $dto->codeQualifiantSemence1;
        $this->daplosCodeQualifiantSemence2 = $dto->codeQualifiantSemence2;
        $this->daplosCodeQualifiantSemence3 = $dto->codeQualifiantSemence3;
        $this->daplosQuantiteEffectiveHa = null !== $dto->quantiteEffectiveHa ? (string) $dto->quantiteEffectiveHa : null;
        $this->daplosCodeUniteQuantiteEffectiveHa = $dto->codeUniteQuantiteEffectiveHa;
        $this->daplosDoseHaVisee = null !== $dto->doseHaVisee ? (string) $dto->doseHaVisee : null;
        $this->daplosCodeUniteDoseHaVisee = $dto->codeUniteDoseHaVisee;
        $this->daplosNombrePassagesPreconises = null !== $dto->nombrePassagesPreconises ? (string) $dto->nombrePassagesPreconises : null;
        $this->daplosOrigineEffluentRaisonSociale1 = $dto->origineEffluentRaisonSociale1;
        $this->daplosOrigineEffluentRaisonSociale2 = $dto->origineEffluentRaisonSociale2;
        $this->daplosOrigineEffluentAdresse1 = $dto->origineEffluentAdresse1;
        $this->daplosOrigineEffluentAdresse2 = $dto->origineEffluentAdresse2;
        $this->daplosOrigineEffluentVille = $dto->origineEffluentVille;
        $this->daplosOrigineEffluentCodePostal = $dto->origineEffluentCodePostal;
        $this->daplosOrigineEffluentPays = $dto->origineEffluentPays;
        $this->daplosDensiteVolumique = null !== $dto->densiteVolumique ? (string) $dto->densiteVolumique : null;

        return $this;
    }
}
