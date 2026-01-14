<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Parcelle;

/**
 * DTO pour le FLAG PS (Surface Parcelle).
 */
final class SurfaceParcelle
{
    // Types de surface
    public const TYPE_A17 = 'A17'; // Surface graphique
    public const TYPE_A28 = 'A28'; // Surface decl
    public const TYPE_A40 = 'A40'; // Surface RPG

    /** @var array<Coordonnee> */
    private array $coordonnees = [];

    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $typeSurface = null,
        public readonly ?float $surface = null,
    ) {
    }

    public function addCoordonnee(Coordonnee $coordonnee): void
    {
        $this->coordonnees[] = $coordonnee;
    }

    /**
     * @return array<Coordonnee>
     */
    public function getCoordonnees(): array
    {
        return $this->coordonnees;
    }
}
