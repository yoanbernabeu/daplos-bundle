<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Intrant\LotFabricant;

/**
 * Parser pour le FLAG IL (Lot fabricant).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), page 43 :
 *
 * Position 3-6     : N° d'ordre de la parcelle (4 n)
 * Position 7-10    : Référence parcelle culturale (4 an)
 * Position 11-14   : Année prévue de récolte (4 n)
 * Position 15-46   : Référence de l'événement, GUID (32 an)
 * Position 47-81   : Code produit (35 an) — idem enregistrement VI
 * Position 82-116  : N° de lot du fabricant de l'intrant (35 an)
 * Position 117-125 : Quantité par lot (9 n)
 * Position 126-128 : Unité de mesure (3 an) — obligatoire si quantité renseignée
 * Position 129-137 : PMG, Poids de Mille Grains (9 n) — pour les semences
 * Position 138-140 : Unité de mesure du PMG (3 an) — obligatoire si PMG renseigné
 */
final class ILLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'IL';
    }

    protected function doParse(string $line, int $lineNumber): LotFabricant
    {
        return new LotFabricant(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            refIntervention: $this->extractField($line, 15, 32),
            numeroLot: $this->extractField($line, 82, 35),
            quantite: $this->extractFloat($line, 117, 9),
            codeUnite: $this->extractField($line, 126, 3),
            codeProduit: $this->extractField($line, 47, 35),
            pmg: $this->extractFloat($line, 129, 9),
            codeUnitePmg: $this->extractField($line, 138, 3),
        );
    }
}
