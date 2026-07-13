<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;

/**
 * Trait pour les entités représentant un événement/intervention DAPLOS.
 *
 * Usage:
 *   use DaplosEvenementTrait;
 *
 * L'entité aura alors les propriétés standard d'un événement DAPLOS :
 *   - daplosRefIntervention : Référence unique de l'intervention
 *   - daplosCodeIntervention : Code du type d'intervention
 *   - daplosDateDebutIntervention : Date de début
 *   - etc.
 *
 * @author Yoan Bernabeu
 */
trait DaplosEvenementTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $daplosRefIntervention = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeIntervention = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeCategorieIntervention = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosLibelleIntervention = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateDebutIntervention = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDateFinIntervention = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeStatutIntervention = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeJustificationIntervention = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeStadeVegetatif = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $daplosLibelleStadeVegetatif = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeConditionsMeteo = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $daplosCommentaire = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4, nullable: true)]
    private ?string $daplosSurfaceTraitee = null;

    #[ORM\Column(type: 'string', length: 3, nullable: true)]
    private ?string $daplosCodeAction = null;

    #[ORM\Column(type: 'string', length: 6, nullable: true)]
    private ?string $daplosDureeTraitement = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $daplosDatePreconisation = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeTypeTravail = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosComplementTypeTravail = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosComplementMotivation = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeTypeOperateur = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $daplosNumeroLicenceOperateur = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $daplosNomOperateur = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeTraitementsSpeciaux = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosTemperatureExterieure = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosPourcentageHygrometrie = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosQuantiteBouillieViseeHa = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosUniteBouillieViseeHa = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 4, nullable: true)]
    private ?string $daplosQuantiteBouillieEffectiveHa = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosUniteBouillieEffectiveHa = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosCodeStadeCultureBBCH = null;

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

    public function getDaplosCodeIntervention(): ?string
    {
        return $this->daplosCodeIntervention;
    }

    public function setDaplosCodeIntervention(?string $daplosCodeIntervention): static
    {
        $this->daplosCodeIntervention = $daplosCodeIntervention;

        return $this;
    }

    public function getDaplosCodeCategorieIntervention(): ?string
    {
        return $this->daplosCodeCategorieIntervention;
    }

    public function setDaplosCodeCategorieIntervention(?string $daplosCodeCategorieIntervention): static
    {
        $this->daplosCodeCategorieIntervention = $daplosCodeCategorieIntervention;

        return $this;
    }

    public function getDaplosLibelleIntervention(): ?string
    {
        return $this->daplosLibelleIntervention;
    }

    public function setDaplosLibelleIntervention(?string $daplosLibelleIntervention): static
    {
        $this->daplosLibelleIntervention = $daplosLibelleIntervention;

        return $this;
    }

    public function getDaplosDateDebutIntervention(): ?\DateTimeImmutable
    {
        return $this->daplosDateDebutIntervention;
    }

    public function setDaplosDateDebutIntervention(?\DateTimeImmutable $daplosDateDebutIntervention): static
    {
        $this->daplosDateDebutIntervention = $daplosDateDebutIntervention;

        return $this;
    }

    public function getDaplosDateFinIntervention(): ?\DateTimeImmutable
    {
        return $this->daplosDateFinIntervention;
    }

    public function setDaplosDateFinIntervention(?\DateTimeImmutable $daplosDateFinIntervention): static
    {
        $this->daplosDateFinIntervention = $daplosDateFinIntervention;

        return $this;
    }

    public function getDaplosCodeStatutIntervention(): ?string
    {
        return $this->daplosCodeStatutIntervention;
    }

    public function setDaplosCodeStatutIntervention(?string $daplosCodeStatutIntervention): static
    {
        $this->daplosCodeStatutIntervention = $daplosCodeStatutIntervention;

        return $this;
    }

    public function getDaplosCodeJustificationIntervention(): ?string
    {
        return $this->daplosCodeJustificationIntervention;
    }

    public function setDaplosCodeJustificationIntervention(?string $daplosCodeJustificationIntervention): static
    {
        $this->daplosCodeJustificationIntervention = $daplosCodeJustificationIntervention;

        return $this;
    }

    public function getDaplosCodeStadeVegetatif(): ?string
    {
        return $this->daplosCodeStadeVegetatif;
    }

    public function setDaplosCodeStadeVegetatif(?string $daplosCodeStadeVegetatif): static
    {
        $this->daplosCodeStadeVegetatif = $daplosCodeStadeVegetatif;

        return $this;
    }

    public function getDaplosLibelleStadeVegetatif(): ?string
    {
        return $this->daplosLibelleStadeVegetatif;
    }

    public function setDaplosLibelleStadeVegetatif(?string $daplosLibelleStadeVegetatif): static
    {
        $this->daplosLibelleStadeVegetatif = $daplosLibelleStadeVegetatif;

        return $this;
    }

    public function getDaplosCodeConditionsMeteo(): ?string
    {
        return $this->daplosCodeConditionsMeteo;
    }

    public function setDaplosCodeConditionsMeteo(?string $daplosCodeConditionsMeteo): static
    {
        $this->daplosCodeConditionsMeteo = $daplosCodeConditionsMeteo;

        return $this;
    }

    public function getDaplosCommentaire(): ?string
    {
        return $this->daplosCommentaire;
    }

    public function setDaplosCommentaire(?string $daplosCommentaire): static
    {
        $this->daplosCommentaire = $daplosCommentaire;

        return $this;
    }

    public function getDaplosSurfaceTraitee(): ?string
    {
        return $this->daplosSurfaceTraitee;
    }

    public function setDaplosSurfaceTraitee(float|string|null $daplosSurfaceTraitee): static
    {
        $this->daplosSurfaceTraitee = null !== $daplosSurfaceTraitee ? (string) $daplosSurfaceTraitee : null;

        return $this;
    }

    public function getDaplosCodeAction(): ?string
    {
        return $this->daplosCodeAction;
    }

    public function setDaplosCodeAction(?string $daplosCodeAction): static
    {
        $this->daplosCodeAction = $daplosCodeAction;

        return $this;
    }

    public function getDaplosDureeTraitement(): ?string
    {
        return $this->daplosDureeTraitement;
    }

    public function setDaplosDureeTraitement(?string $daplosDureeTraitement): static
    {
        $this->daplosDureeTraitement = $daplosDureeTraitement;

        return $this;
    }

    /**
     * Convertit la durée du traitement (format guide JJHHMM) en minutes.
     */
    public function getDaplosDureeTraitementEnMinutes(): ?int
    {
        if (null === $this->daplosDureeTraitement || 6 !== strlen($this->daplosDureeTraitement) || !ctype_digit($this->daplosDureeTraitement)) {
            return null;
        }

        $jours = (int) substr($this->daplosDureeTraitement, 0, 2);
        $heures = (int) substr($this->daplosDureeTraitement, 2, 2);
        $minutes = (int) substr($this->daplosDureeTraitement, 4, 2);

        return $jours * 1440 + $heures * 60 + $minutes;
    }

    public function getDaplosDatePreconisation(): ?\DateTimeImmutable
    {
        return $this->daplosDatePreconisation;
    }

    public function setDaplosDatePreconisation(?\DateTimeImmutable $daplosDatePreconisation): static
    {
        $this->daplosDatePreconisation = $daplosDatePreconisation;

        return $this;
    }

    public function getDaplosCodeTypeTravail(): ?string
    {
        return $this->daplosCodeTypeTravail;
    }

    public function setDaplosCodeTypeTravail(?string $daplosCodeTypeTravail): static
    {
        $this->daplosCodeTypeTravail = $daplosCodeTypeTravail;

        return $this;
    }

    public function getDaplosComplementTypeTravail(): ?string
    {
        return $this->daplosComplementTypeTravail;
    }

    public function setDaplosComplementTypeTravail(?string $daplosComplementTypeTravail): static
    {
        $this->daplosComplementTypeTravail = $daplosComplementTypeTravail;

        return $this;
    }

    public function getDaplosComplementMotivation(): ?string
    {
        return $this->daplosComplementMotivation;
    }

    public function setDaplosComplementMotivation(?string $daplosComplementMotivation): static
    {
        $this->daplosComplementMotivation = $daplosComplementMotivation;

        return $this;
    }

    public function getDaplosCodeTypeOperateur(): ?string
    {
        return $this->daplosCodeTypeOperateur;
    }

    public function setDaplosCodeTypeOperateur(?string $daplosCodeTypeOperateur): static
    {
        $this->daplosCodeTypeOperateur = $daplosCodeTypeOperateur;

        return $this;
    }

    public function getDaplosNumeroLicenceOperateur(): ?string
    {
        return $this->daplosNumeroLicenceOperateur;
    }

    public function setDaplosNumeroLicenceOperateur(?string $daplosNumeroLicenceOperateur): static
    {
        $this->daplosNumeroLicenceOperateur = $daplosNumeroLicenceOperateur;

        return $this;
    }

    public function getDaplosNomOperateur(): ?string
    {
        return $this->daplosNomOperateur;
    }

    public function setDaplosNomOperateur(?string $daplosNomOperateur): static
    {
        $this->daplosNomOperateur = $daplosNomOperateur;

        return $this;
    }

    public function getDaplosCodeTraitementsSpeciaux(): ?string
    {
        return $this->daplosCodeTraitementsSpeciaux;
    }

    public function setDaplosCodeTraitementsSpeciaux(?string $daplosCodeTraitementsSpeciaux): static
    {
        $this->daplosCodeTraitementsSpeciaux = $daplosCodeTraitementsSpeciaux;

        return $this;
    }

    public function getDaplosTemperatureExterieure(): ?int
    {
        return $this->daplosTemperatureExterieure;
    }

    public function setDaplosTemperatureExterieure(?int $daplosTemperatureExterieure): static
    {
        $this->daplosTemperatureExterieure = $daplosTemperatureExterieure;

        return $this;
    }

    public function getDaplosPourcentageHygrometrie(): ?int
    {
        return $this->daplosPourcentageHygrometrie;
    }

    public function setDaplosPourcentageHygrometrie(?int $daplosPourcentageHygrometrie): static
    {
        $this->daplosPourcentageHygrometrie = $daplosPourcentageHygrometrie;

        return $this;
    }

    public function getDaplosQuantiteBouillieViseeHa(): ?string
    {
        return $this->daplosQuantiteBouillieViseeHa;
    }

    public function setDaplosQuantiteBouillieViseeHa(float|string|null $daplosQuantiteBouillieViseeHa): static
    {
        $this->daplosQuantiteBouillieViseeHa = null !== $daplosQuantiteBouillieViseeHa ? (string) $daplosQuantiteBouillieViseeHa : null;

        return $this;
    }

    public function getDaplosUniteBouillieViseeHa(): ?string
    {
        return $this->daplosUniteBouillieViseeHa;
    }

    public function setDaplosUniteBouillieViseeHa(?string $daplosUniteBouillieViseeHa): static
    {
        $this->daplosUniteBouillieViseeHa = $daplosUniteBouillieViseeHa;

        return $this;
    }

    public function getDaplosQuantiteBouillieEffectiveHa(): ?string
    {
        return $this->daplosQuantiteBouillieEffectiveHa;
    }

    public function setDaplosQuantiteBouillieEffectiveHa(float|string|null $daplosQuantiteBouillieEffectiveHa): static
    {
        $this->daplosQuantiteBouillieEffectiveHa = null !== $daplosQuantiteBouillieEffectiveHa ? (string) $daplosQuantiteBouillieEffectiveHa : null;

        return $this;
    }

    public function getDaplosUniteBouillieEffectiveHa(): ?string
    {
        return $this->daplosUniteBouillieEffectiveHa;
    }

    public function setDaplosUniteBouillieEffectiveHa(?string $daplosUniteBouillieEffectiveHa): static
    {
        $this->daplosUniteBouillieEffectiveHa = $daplosUniteBouillieEffectiveHa;

        return $this;
    }

    public function getDaplosCodeStadeCultureBBCH(): ?string
    {
        return $this->daplosCodeStadeCultureBBCH;
    }

    public function setDaplosCodeStadeCultureBBCH(?string $daplosCodeStadeCultureBBCH): static
    {
        $this->daplosCodeStadeCultureBBCH = $daplosCodeStadeCultureBBCH;

        return $this;
    }

    /**
     * Hydrate l'entité depuis un DTO Evenement.
     */
    public function hydrateFromDaplosEvenement(Evenement $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosRefIntervention = $dto->refIntervention;
        $this->daplosCodeIntervention = $dto->codeIntervention;
        $this->daplosCodeCategorieIntervention = $dto->codeCategorieIntervention;
        $this->daplosLibelleIntervention = $dto->libelleIntervention;
        $this->daplosDateDebutIntervention = $dto->dateDebutIntervention;
        $this->daplosDateFinIntervention = $dto->dateFinIntervention;
        $this->daplosCodeStatutIntervention = $dto->codeStatutIntervention;
        $this->daplosCodeJustificationIntervention = $dto->codeJustificationIntervention;
        $this->daplosCodeStadeVegetatif = $dto->codeStadeVegetatif;
        $this->daplosLibelleStadeVegetatif = $dto->libelleStadeVegetatif;
        $this->daplosCodeConditionsMeteo = $dto->codeConditionsMeteo;
        $this->daplosCommentaire = $dto->commentaire;
        $this->daplosSurfaceTraitee = null !== $dto->surfaceTraitee ? (string) $dto->surfaceTraitee : null;
        $this->daplosCodeAction = $dto->codeAction;
        $this->daplosDureeTraitement = $dto->dureeTraitement;
        $this->daplosDatePreconisation = $dto->datePreconisation;
        $this->daplosCodeTypeTravail = $dto->codeTypeTravail;
        $this->daplosComplementTypeTravail = $dto->complementTypeTravail;
        $this->daplosComplementMotivation = $dto->complementMotivation;
        $this->daplosCodeTypeOperateur = $dto->codeTypeOperateur;
        $this->daplosNumeroLicenceOperateur = $dto->numeroLicenceOperateur;
        $this->daplosNomOperateur = $dto->nomOperateur;
        $this->daplosCodeTraitementsSpeciaux = $dto->codeTraitementsSpeciaux;
        $this->daplosTemperatureExterieure = $dto->temperatureExterieure;
        $this->daplosPourcentageHygrometrie = $dto->pourcentageHygrometrie;
        $this->daplosQuantiteBouillieViseeHa = null !== $dto->quantiteBouillieViseeHa ? (string) $dto->quantiteBouillieViseeHa : null;
        $this->daplosUniteBouillieViseeHa = $dto->uniteBouillieViseeHa;
        $this->daplosQuantiteBouillieEffectiveHa = null !== $dto->quantiteBouillieEffectiveHa ? (string) $dto->quantiteBouillieEffectiveHa : null;
        $this->daplosUniteBouillieEffectiveHa = $dto->uniteBouillieEffectiveHa;
        $this->daplosCodeStadeCultureBBCH = $dto->codeStadeCultureBBCH;

        return $this;
    }
}
