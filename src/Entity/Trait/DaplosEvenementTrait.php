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
    private ?float $daplosSurfaceTraitee = null;

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

    public function getDaplosSurfaceTraitee(): ?float
    {
        return $this->daplosSurfaceTraitee;
    }

    public function setDaplosSurfaceTraitee(?float $daplosSurfaceTraitee): static
    {
        $this->daplosSurfaceTraitee = $daplosSurfaceTraitee;

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
        $this->daplosSurfaceTraitee = $dto->surfaceTraitee;

        return $this;
    }
}
