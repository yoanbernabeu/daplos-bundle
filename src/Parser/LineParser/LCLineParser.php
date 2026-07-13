<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Recolte\CaracterisationProduit;

/**
 * Parser pour le FLAG LC (Caractérisation du produit récolté pour le lot).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), page 48 :
 *
 * Position 3-6   : N° d'ordre de la parcelle (4 n)
 * Position 7-10  : Référence parcelle culturale (4 an)
 * Position 11-14 : Année prévue de récolte (4 n)
 * Position 15-46 : Référence de l'événement, GUID (32 an)
 * Position 47-49 : Type Caractéristique en code (3 an) — nomenclature Caractéristique technique
 * Position 50-58 : Valeur de la caractéristique (9 n)
 * Position 59-61 : Unité de mesure (3 an)
 *
 * La valeur (9 n) est conservée en chaîne dans `valeur` (type historique) ;
 * un accès numérique est disponible via CaracterisationProduit::getValeurNumerique().
 */
final class LCLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'LC';
    }

    protected function doParse(string $line, int $lineNumber): CaracterisationProduit
    {
        return new CaracterisationProduit(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            refIntervention: $this->extractField($line, 15, 32),
            codeCaracteristique: $this->extractField($line, 47, 3),
            valeur: $this->extractField($line, 50, 9),
            codeUnite: $this->extractField($line, 59, 3),
        );
    }
}
