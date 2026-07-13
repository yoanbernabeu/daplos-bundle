<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Recolte\Recolte;

/**
 * Parser pour le FLAG VR (Récolte).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), pages 45-46 :
 *
 * Position 3-6     : N° d'ordre de la parcelle (4 n)
 * Position 7-10    : Référence parcelle culturale (4 an)
 * Position 11-14   : Année prévue de récolte (4 n)
 * Position 15-46   : Référence de l'événement, GUID (32 an)
 * Position 47-49   : Produit principal ou co-produit (3 an) — nomenclature Type de produit récolté
 * Position 50-52   : Code produit récolté (3 an) — nomenclature Espèce botanique d'une culture
 * Position 53-87   : Libellé du produit (35 an)
 * Position 88-90   : Destination produit ou co-produit (3 an) — nomenclature Destination d'une culture
 * Position 91-99   : Quantité récoltée (9 n)
 * Position 100-102 : Unité de mesure (3 an) — obligatoire si quantité renseignée
 * Position 103-111 : Rendement calculé (9 n)
 * Position 112-114 : Unité de mesure du rendement calculé (3 an)
 * Position 115-123 : Rendement estimé (9 n)
 * Position 124-126 : Unité de mesure du rendement estimé (3 an)
 *
 * Note : `codeTypeProduitRecolte` (47-49) porte la nomenclature « Type de
 * produit récolté » (produit principal ou co-produit) et
 * `codeEspeceBotanique` (50-52) le « Code produit récolté » (nomenclature
 * Espèce botanique d'une culture) — noms historiques conservés, positions
 * conformes au guide.
 */
final class VRLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'VR';
    }

    protected function doParse(string $line, int $lineNumber): Recolte
    {
        return new Recolte(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            refIntervention: $this->extractField($line, 15, 32),
            codeTypeProduitRecolte: $this->extractField($line, 47, 3),
            codeEspeceBotanique: $this->extractField($line, 50, 3),
            libelleProduit: $this->extractField($line, 53, 35),
            quantite: $this->extractFloat($line, 91, 9),
            codeUnite: $this->extractField($line, 100, 3),
            destinationProduit: $this->extractField($line, 88, 3),
            rendementCalcule: $this->extractFloat($line, 103, 9),
            codeUniteRendementCalcule: $this->extractField($line, 112, 3),
            rendementEstime: $this->extractFloat($line, 115, 9),
            codeUniteRendementEstime: $this->extractField($line, 124, 3),
        );
    }
}
