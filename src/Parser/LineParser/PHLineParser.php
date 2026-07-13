<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Historique;

/**
 * Parser pour le FLAG PH (Historique/Precedent cultural).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), pages 26-27 :
 *
 * Position 3-6   : N° d'ordre de la parcelle (4 n)
 * Position 7-10  : Référence parcelle culturale (4 an)
 * Position 11-14 : Année prévue de récolte (4 n)
 * Position 15-16 : N° d'ordre du précédent (2 an) — chiffre négatif de -1 à -9
 * Position 17-20 : Clé de la parcelle du précédent (4 an)
 * Position 21-23 : Espèce botanique (3 an) — nomenclature Espèce botanique d'une culture
 * Position 24-30 : Variété semée 1 (7 an) — code GNIS par défaut
 * Position 31-37 : Variété semée 2 (7 an)
 * Position 38-44 : Variété semée 3 (7 an)
 * Position 45-51 : Variété semée 4 (7 an)
 * Position 52-58 : Variété semée 5 (7 an)
 * Position 59-61 : Qualifiant d'espèce (3 an) — nomenclature Qualifiant d'une culture
 * Position 62-64 : Période de semis (3 an) — nomenclature Période de semis d'une culture
 * Position 65-67 : Destination (3 an) — nomenclature Destination d'une culture
 * Position 68-70 : Gestion des résidus (3 an) — nomenclature Traitement des résidus de culture
 * Position 71-79 : Quantité épandue (9 n) en tonne/ha — résidus de culture laissés dans la parcelle
 */
final class PHLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'PH';
    }

    protected function doParse(string $line, int $lineNumber): Historique
    {
        // Extraction du n° d'ordre du précédent (peut etre -1, -2, etc.)
        $indexStr = $this->extractField($line, 15, 2);
        $index = null;
        if (null !== $indexStr) {
            $index = (int) str_replace('-', '', $indexStr);
            if (str_contains($indexStr, '-')) {
                $index = -$index;
            }
        }

        return new Historique(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            indexPrecedent: $index,
            codeEspeceBotanique: $this->extractField($line, 21, 3),
            cleParcellePrecedent: $this->extractField($line, 17, 4),
            varieteSemee1: $this->extractField($line, 24, 7),
            varieteSemee2: $this->extractField($line, 31, 7),
            varieteSemee3: $this->extractField($line, 38, 7),
            varieteSemee4: $this->extractField($line, 45, 7),
            varieteSemee5: $this->extractField($line, 52, 7),
            codeQualifiantEspece: $this->extractField($line, 59, 3),
            codePeriodeSemis: $this->extractField($line, 62, 3),
            codeDestination: $this->extractField($line, 65, 3),
            codeGestionResidus: $this->extractField($line, 68, 3),
            quantiteEpandue: $this->extractFloat($line, 71, 9),
        );
    }
}
