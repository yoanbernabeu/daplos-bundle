<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCadastrale;

/**
 * Trait pour les entités représentant une parcelle cadastrale DAPLOS.
 *
 * Usage:
 *   use DaplosParcelleCadastraleTrait;
 *
 * @author Yoan Bernabeu
 */
trait DaplosParcelleCadastraleTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosCodeCommune = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosPrefixe = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosSection = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $daplosNumero = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4, nullable: true)]
    private ?string $daplosSurface = null;

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

    public function getDaplosCodeCommune(): ?string
    {
        return $this->daplosCodeCommune;
    }

    public function setDaplosCodeCommune(?string $daplosCodeCommune): static
    {
        $this->daplosCodeCommune = $daplosCodeCommune;

        return $this;
    }

    public function getDaplosPrefixe(): ?string
    {
        return $this->daplosPrefixe;
    }

    public function setDaplosPrefixe(?string $daplosPrefixe): static
    {
        $this->daplosPrefixe = $daplosPrefixe;

        return $this;
    }

    public function getDaplosSection(): ?string
    {
        return $this->daplosSection;
    }

    public function setDaplosSection(?string $daplosSection): static
    {
        $this->daplosSection = $daplosSection;

        return $this;
    }

    public function getDaplosNumero(): ?string
    {
        return $this->daplosNumero;
    }

    public function setDaplosNumero(?string $daplosNumero): static
    {
        $this->daplosNumero = $daplosNumero;

        return $this;
    }

    public function getDaplosSurface(): ?string
    {
        return $this->daplosSurface;
    }

    public function setDaplosSurface(float|string|null $daplosSurface): static
    {
        $this->daplosSurface = null !== $daplosSurface ? (string) $daplosSurface : null;

        return $this;
    }

    /**
     * Hydrate l'entité depuis un DTO ParcelleCadastrale.
     */
    public function hydrateFromDaplosParcelleCadastrale(ParcelleCadastrale $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosCodeCommune = $dto->codeCommune;
        $this->daplosPrefixe = $dto->prefixe;
        $this->daplosSection = $dto->section;
        $this->daplosNumero = $dto->numero;
        $this->daplosSurface = null !== $dto->surface ? (string) $dto->surface : null;

        return $this;
    }
}
