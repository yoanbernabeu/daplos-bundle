<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Intrant\CompositionFertilisation;

/**
 * Parser pour le FLAG IC (Composition du produit en cas de fertilisation minérale).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), pages 41-42 :
 *
 * Position 3-6   : N° d'ordre de la parcelle (4 n)
 * Position 7-10  : Référence parcelle culturale (4 an)
 * Position 11-14 : Année prévue de récolte (4 n)
 * Position 15-46 : Référence de l'événement, GUID (32 an)
 * Position 47-49 : Code du composant (3 an) — nomenclature Teneur en composé chimique
 * Position 50-58 : Teneur (9 n) — en unités d'éléments fertilisants par unité de
 *                  fertilisant, rapportée à l'unité de mesure de la quantité totale
 *                  effective d'intrant du FLAG VI (positions 220-222) ; la valeur est
 *                  lue telle quelle (ex. solution azotée 39 → 39)
 */
final class ICLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'IC';
    }

    protected function doParse(string $line, int $lineNumber): CompositionFertilisation
    {
        return new CompositionFertilisation(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            refIntervention: $this->extractField($line, 15, 32),
            codeElement: $this->extractField($line, 47, 3),
            teneur: $this->extractFloat($line, 50, 9),
        );
    }
}
