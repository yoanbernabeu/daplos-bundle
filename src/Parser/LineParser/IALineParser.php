<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Intrant\AnalyseEffluent;

/**
 * Parser pour le FLAG IA (Analyse d'effluent).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), page 44 :
 *
 * Position 3-6     : N° d'ordre de la parcelle (4 n)
 * Position 7-10    : Référence parcelle culturale (4 an)
 * Position 11-14   : Année prévue de récolte (4 n)
 * Position 15-46   : Référence de l'événement, GUID (32 an)
 * Position 47-81   : N° de bordereau d'analyse (35 an)
 * Position 82-90   : Identification du laboratoire d'analyse (9 an) — code SIREN
 * Position 91-125  : Raison sociale (1) du laboratoire (35 an)
 * Position 126-160 : Raison sociale (2) du laboratoire (35 an)
 * Position 161-195 : Adresse Rue (1) du laboratoire (35 an)
 * Position 196-230 : Adresse Rue (2) du laboratoire (35 an)
 * Position 231-265 : Ville du laboratoire (35 an)
 * Position 266-274 : Code postal du laboratoire (9 an)
 * Position 275-276 : Pays du laboratoire (2 an) — code ISO
 * Position 277-284 : Date d'analyse (8 n) SSAAMMJJ
 * Position 285-292 : Date de prélèvement (8 n) SSAAMMJJ
 *
 * Les anciens champs typeAnalyse (47-49), codeElement (50-52), valeur (53-62)
 * et codeUnite (63-65) ne correspondaient à aucun champ du guide : ils sont
 * dépréciés et ne sont plus remplis.
 */
final class IALineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'IA';
    }

    protected function doParse(string $line, int $lineNumber): AnalyseEffluent
    {
        return new AnalyseEffluent(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            refIntervention: $this->extractField($line, 15, 32),
            numeroBordereau: $this->extractField($line, 47, 35),
            identificationLaboratoire: $this->extractField($line, 82, 9),
            laboratoireRaisonSociale1: $this->extractField($line, 91, 35),
            laboratoireRaisonSociale2: $this->extractField($line, 126, 35),
            laboratoireAdresse1: $this->extractField($line, 161, 35),
            laboratoireAdresse2: $this->extractField($line, 196, 35),
            laboratoireVille: $this->extractField($line, 231, 35),
            laboratoireCodePostal: $this->extractField($line, 266, 9),
            laboratoirePays: $this->extractField($line, 275, 2),
            dateAnalyse: $this->extractDateTime($line, 277, 8),
            datePrelevement: $this->extractDateTime($line, 285, 8),
        );
    }
}
