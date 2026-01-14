<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Parcelle;

/**
 * DTO pour le FLAG PC (Parcelle Cadastrale).
 */
final class ParcelleCadastrale
{
    /** @var array<Coordonnee> */
    private array $coordonnees = [];

    public function __construct(
        public readonly ?string $identifiantParcelle = null,
        public readonly ?int $annee = null,
        public readonly ?string $codeCommune = null,
        public readonly ?string $prefixe = null,
        public readonly ?string $section = null,
        public readonly ?string $numero = null,
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
