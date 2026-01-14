<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;

/**
 * Parser pour le FLAG DP (Parcelle Culturale).
 *
 * Format observe dans les fichiers reels (v0.94/v0.95) :
 * Position 1-2    : FLAG "DP"
 * Position 3-10   : Identifiant parcelle (8 an)
 * Position 11-14  : Annee campagne (4 n)
 * Position 15-22  : Date creation (8 n) YYYYMMDD
 * Position 23-30  : Date debut campagne (8 n) YYYYMMDD
 * Position 31-38  : Date fin campagne (8 n) YYYYMMDD
 * Position 39-46  : Espaces ou données complémentaires
 * Position 47-49  : Code espece botanique (3 an)
 * Position 50-58  : Code variete (9 an)
 * Position 59-88  : Codes qualifiants et surfaces
 * Position 89-105 : Code qualifiant culture et données
 * Position 106-140: Nom parcelle (35 an)
 * Position 141-143: Numero ilot (3 n)
 * Position 161-165: Code commune (5 n)
 * Position 200+   : Numero RPG et autres
 */
final class DPLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'DP';
    }

    protected function doParse(string $line, int $lineNumber): ParcelleCulturale
    {
        // Positions de base (fixes)
        $identifiant = $this->extractField($line, 3, 8);
        $annee = $this->extractInt($line, 11, 4);

        // Dates (peuvent être absentes)
        $dateCreation = $this->extractDateTime($line, 15, 8);
        $dateDebut = $this->extractDateTime($line, 23, 8);
        $dateFin = $this->extractDateTime($line, 31, 8);

        // Code espèce botanique à la position 47 (confirmé par analyse)
        $codeEspece = $this->extractField($line, 47, 3);

        // Code variété (après le code espèce)
        $codeVariete = $this->extractField($line, 50, 9);

        // Codes qualifiants (positions variables selon les exports)
        $codeQualifiant = $this->extractField($line, 89, 3);

        // Nom de la parcelle (position ~106)
        $nom = $this->extractField($line, 106, 35);

        // Numéro d'îlot
        $numeroIlot = $this->extractInt($line, 141, 3);

        // Code commune (position ~161)
        $codeCommune = $this->extractField($line, 161, 5);

        // Numéro RPG (vers la fin de la ligne)
        $numeroRPG = $this->extractField($line, 237, 10);

        return new ParcelleCulturale(
            identifiant: $identifiant,
            annee: $annee,
            dateCreation: $dateCreation,
            dateDebutCampagne: $dateDebut,
            dateFinCampagne: $dateFin,
            codeEspeceBotanique: $codeEspece,
            codeVariete: $codeVariete,
            codeQualifiantCulture: $codeQualifiant,
            nom: $nom,
            numeroIlot: $numeroIlot,
            codeCommune: $codeCommune,
            numeroRPG: $numeroRPG,
        );
    }
}
