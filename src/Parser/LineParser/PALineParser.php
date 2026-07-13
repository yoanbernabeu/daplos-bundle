<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Analyse;

/**
 * Parser pour le FLAG PA (Analyse de sol).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), page 29 :
 *
 * Position 3-6     : N° d'ordre de la parcelle (4 n)
 * Position 7-10    : Référence parcelle culturale (4 an)
 * Position 11-14   : Année prévue de récolte (4 n)
 * Position 15-49   : N° de bordereau d'analyse de sol (35 an)
 * Position 50-58   : Identification du laboratoire d'analyse (9 an) — code SIREN
 * Position 59-93   : Raison sociale 1 du laboratoire (35 an)
 * Position 94-128  : Raison sociale 2 du laboratoire (35 an)
 * Position 129-163 : Adresse rue 1 du laboratoire (35 an)
 * Position 164-198 : Adresse rue 2 du laboratoire (35 an)
 * Position 199-233 : Ville du laboratoire (35 an)
 * Position 234-242 : Code postal du laboratoire (9 an)
 * Position 243-244 : Pays du laboratoire, code ISO (2 an)
 * Position 245-252 : Date d'analyse (8 n) SSAAMMJJ
 * Position 253-260 : Date de prélèvement (8 n) SSAAMMJJ
 */
final class PALineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'PA';
    }

    protected function doParse(string $line, int $lineNumber): Analyse
    {
        return new Analyse(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            datePrelevement: $this->extractDateTime($line, 253, 8),
            dateAnalyse: $this->extractDateTime($line, 245, 8),
            numeroBordereau: $this->extractField($line, 15, 35),
            identificationLaboratoire: $this->extractField($line, 50, 9),
            laboratoireRaisonSociale1: $this->extractField($line, 59, 35),
            laboratoireRaisonSociale2: $this->extractField($line, 94, 35),
            laboratoireAdresseRue1: $this->extractField($line, 129, 35),
            laboratoireAdresseRue2: $this->extractField($line, 164, 35),
            laboratoireVille: $this->extractField($line, 199, 35),
            laboratoireCodePostal: $this->extractField($line, 234, 9),
            laboratoirePays: $this->extractField($line, 243, 2),
        );
    }
}
