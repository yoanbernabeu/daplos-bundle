<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Document\DocumentHeader;

/**
 * Parser pour le FLAG DE (Entête du document).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), page 9 :
 *
 * Position 3-37  : Référence du document (35 an)
 * Position 38    : Fonction en code (1 an) — 7 duplicata / 9 original (nomenclature Statut du message)
 * Position 39-46 : Date du document (8 n) SSAAMMJJ
 * Position 47-50 : Nombre de fiches parcellaires (4 n)
 * Position 51-54 : N° de version du message (4 an) — ex. 0.95
 */
final class DELineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'DE';
    }

    protected function doParse(string $line, int $lineNumber): DocumentHeader
    {
        return new DocumentHeader(
            referenceDocument: $this->extractField($line, 3, 35),
            dateHeureDocument: $this->extractDateTime($line, 39, 8),
            versionFormat: $this->extractField($line, 51, 4),
            codeFonction: $this->extractField($line, 38, 1),
            nombreFichesParcellaires: $this->extractInt($line, 47, 4),
        );
    }
}
