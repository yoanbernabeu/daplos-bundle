<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Recolte\LotRecolte;

/**
 * Parser pour le FLAG RL (Lot Récolte).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), page 47 :
 *
 * Position 3-6     : N° d'ordre de la parcelle (4 n)
 * Position 7-10    : Référence parcelle culturale (4 an)
 * Position 11-14   : Année prévue de récolte (4 n)
 * Position 15-46   : Référence de l'événement, GUID (32 an)
 * Position 47-81   : N° de lot OS, Organisme Stockeur (35 an)
 * Position 82-116  : N° de lot Agriculteur (35 an) — si stockage en ferme
 * Position 117-125 : Quantité du lot (9 n) — en tonnes
 *
 * L'ancien champ codeUnite (91-93) ne correspondait à aucun champ du guide
 * (pas d'unité dans le FLAG RL, la quantité est exprimée en tonnes) : il est
 * déprécié et n'est plus rempli.
 */
final class RLLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'RL';
    }

    protected function doParse(string $line, int $lineNumber): LotRecolte
    {
        return new LotRecolte(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            refIntervention: $this->extractField($line, 15, 32),
            numeroLot: $this->extractField($line, 47, 35),
            quantite: $this->extractFloat($line, 117, 9),
            numeroLotAgriculteur: $this->extractField($line, 82, 35),
        );
    }
}
