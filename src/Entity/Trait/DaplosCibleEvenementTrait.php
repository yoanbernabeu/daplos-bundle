<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Intervention\CibleEvenement;

/**
 * Trait pour les entités représentant une cible d'événement DAPLOS.
 *
 * Usage:
 *   use DaplosCibleEvenementTrait;
 *
 * L'entité aura alors les propriétés standard d'une cible DAPLOS :
 *   - daplosIdentifiantParcelle : Identifiant de la parcelle
 *   - daplosAnnee : Année de campagne
 *   - daplosRefIntervention : Référence de l'intervention
 *   - daplosCodeOrganismeCible : Code de l'organisme ciblé
 *   - daplosCodeSousTypeOrganisme : Sous-type de l'organisme
 *
 * @author Yoan Bernabeu
 */
trait DaplosCibleEvenementTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $daplosRefIntervention = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosCodeOrganismeCible = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosCodeSousTypeOrganisme = null;

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

    public function getDaplosCodeOrganismeCible(): ?string
    {
        return $this->daplosCodeOrganismeCible;
    }

    public function setDaplosCodeOrganismeCible(?string $daplosCodeOrganismeCible): static
    {
        $this->daplosCodeOrganismeCible = $daplosCodeOrganismeCible;

        return $this;
    }

    public function getDaplosCodeSousTypeOrganisme(): ?string
    {
        return $this->daplosCodeSousTypeOrganisme;
    }

    public function setDaplosCodeSousTypeOrganisme(?string $daplosCodeSousTypeOrganisme): static
    {
        $this->daplosCodeSousTypeOrganisme = $daplosCodeSousTypeOrganisme;

        return $this;
    }

    /**
     * Hydrate l'entité depuis un DTO CibleEvenement.
     */
    public function hydrateFromDaplosCibleEvenement(CibleEvenement $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosRefIntervention = $dto->refIntervention;
        $this->daplosCodeOrganismeCible = $dto->codeOrganismeCible;
        $this->daplosCodeSousTypeOrganisme = $dto->codeSousTypeOrganisme;

        return $this;
    }
}
