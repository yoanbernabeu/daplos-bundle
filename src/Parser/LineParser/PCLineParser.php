<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCadastrale;

/**
 * Parser pour le FLAG PC (Parcelle Cadastrale).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), pages 19-20 :
 *
 * Position 3-6   : N° d'ordre de la parcelle (4 n)
 * Position 7-10  : Référence parcelle culturale (4 an)
 * Position 11-14 : Année prévue de récolte (4 n)
 * Position 15-30 : N° parcelle cadastrale (16 an), structure officielle :
 *                  - 15-17 : département (format 999, ex. 077)
 *                  - 18-20 : commune (format 999)
 *                  - 21-22 : section (alpha 2)
 *                  - 23-28 : n° de la parcelle dans la section (numérique 6)
 *                  - 29-30 : subdivision fiscale (alpha 2)
 * Position 31-39 : Surface de la parcelle cadastrale (9 n) en hectares
 *
 * Le bloc complet 15-30 est restitué dans numeroParcelleCadastrale ;
 * le couple département + commune (15-20) forme le code INSEE (codeCommune).
 */
final class PCLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'PC';
    }

    protected function doParse(string $line, int $lineNumber): ParcelleCadastrale
    {
        return new ParcelleCadastrale(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            codeCommune: $this->extractField($line, 15, 6),
            section: $this->extractField($line, 21, 2),
            numero: $this->extractField($line, 23, 6),
            surface: $this->extractFloat($line, 31, 9),
            numeroParcelleCadastrale: $this->extractField($line, 15, 16),
            subdivisionFiscale: $this->extractField($line, 29, 2),
        );
    }
}
