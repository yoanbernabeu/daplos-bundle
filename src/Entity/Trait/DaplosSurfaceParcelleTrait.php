<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\SurfaceParcelle;

/**
 * Trait pour les entités représentant une surface de parcelle DAPLOS.
 *
 * Usage:
 *   use DaplosSurfaceParcelleTrait;
 *
 * @author Yoan Bernabeu
 */
trait DaplosSurfaceParcelleTrait
{
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $daplosIdentifiantParcelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $daplosAnnee = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $daplosTypeSurface = null;

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

    public function getDaplosTypeSurface(): ?string
    {
        return $this->daplosTypeSurface;
    }

    public function setDaplosTypeSurface(?string $daplosTypeSurface): static
    {
        $this->daplosTypeSurface = $daplosTypeSurface;

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
     * Hydrate l'entité depuis un DTO SurfaceParcelle.
     */
    public function hydrateFromDaplosSurfaceParcelle(SurfaceParcelle $dto): static
    {
        $this->daplosIdentifiantParcelle = $dto->identifiantParcelle;
        $this->daplosAnnee = $dto->annee;
        $this->daplosTypeSurface = $dto->typeSurface;
        $this->daplosSurface = null !== $dto->surface ? (string) $dto->surface : null;

        return $this;
    }
}
