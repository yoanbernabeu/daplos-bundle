<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Document\TypeAgriculture;

/**
 * Parser pour le FLAG DT (Type d'agriculture pratiquée).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), page 12 :
 *
 * Position 3-5  : Type d'agriculture pratiquée en code (3 an) — nomenclature Valeur de la caractéristique technique
 * Position 6-25 : N° de certificat (20 an)
 * Position 26-45: Autre type d'agriculture (20 an) — certains émetteurs dépassent
 *                 la position 45, lecture jusqu'à la fin de ligne ; rempli dans `libelle`
 *                 (nom historique conservé pour compatibilité)
 */
final class DTLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'DT';
    }

    protected function doParse(string $line, int $lineNumber): TypeAgriculture
    {
        return new TypeAgriculture(
            codeTypeAgriculture: $this->extractField($line, 3, 3),
            libelle: $this->extractFieldToEnd($line, 26),
            numeroCertificat: $this->extractField($line, 6, 20),
        );
    }
}
