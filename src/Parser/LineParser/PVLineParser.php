<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;

/**
 * Parser pour le FLAG PV (Evenement/Intervention).
 *
 * Format observe dans les fichiers reels :
 * Position 1-2   : FLAG "PV"
 * Position 3-10  : Identifiant parcelle (8 an)
 * Position 11-14 : Annee (4 n)
 * Position 15-46 : Reference intervention UUID (32 an)
 * Position 47    : Espace
 * Position 48-50 : Code intervention (3 an)
 * Position 51-53 : Code categorie intervention (3 an)
 * Position 54-88 : Libelle intervention (35 an)
 * Position 89-100: Date debut (12 n) YYYYMMDDHHMM
 * Position 101-112: Date fin (12 n) YYYYMMDDHHMM
 * Position 113-150: Commentaire stade vegetatif
 * Position 151-153: Code statut
 * Position 154-156: Code justification
 * Position 157-159: Code stade vegetatif
 * Position 160+   : Surface traitee et autres
 */
final class PVLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'PV';
    }

    protected function doParse(string $line, int $lineNumber): Evenement
    {
        // Extraction de l'identifiant composite
        $idParcelle = $this->extractField($line, 3, 8);
        $annee = $this->extractInt($line, 11, 4);
        $refIntervention = $this->extractField($line, 15, 32);

        // Codes d'intervention (apres l'espace)
        $codeIntervention = $this->extractField($line, 48, 3);
        $codeCategorieIntervention = $this->extractField($line, 51, 3);

        // Libelle intervention
        $libelleIntervention = $this->extractField($line, 54, 35);

        // Dates
        $dateDebut = $this->extractDateTime($line, 89, 12);
        $dateFin = $this->extractDateTime($line, 101, 12);

        // Commentaire/stade vegetatif
        $commentaire = $this->extractField($line, 113, 38);

        // Codes supplementaires
        $codeStatut = $this->extractField($line, 151, 3);
        $libelleStatut = $this->extractField($line, 154, 35);

        // Code justification cible
        $codeJustificationCible = $this->extractField($line, 189, 3);

        // Surface traitee (recherche dans la partie variable)
        $surfaceTraitee = $this->extractSurfaceFromEnd($line);

        return new Evenement(
            identifiantParcelle: $idParcelle,
            annee: $annee,
            refIntervention: $refIntervention,
            codeIntervention: $codeIntervention,
            codeCategorieIntervention: $codeCategorieIntervention,
            libelleIntervention: $libelleIntervention,
            dateDebutIntervention: $dateDebut,
            dateFinIntervention: $dateFin,
            codeStatutIntervention: $codeStatut,
            commentaire: $commentaire,
            surfaceTraitee: $surfaceTraitee,
            codeJustificationCible: $codeJustificationCible,
        );
    }

    /**
     * Extrait la surface depuis la fin de la ligne.
     */
    private function extractSurfaceFromEnd(string $line): ?float
    {
        // La surface est souvent a la fin sous forme de nombre decimal
        if (preg_match('/(\d+\.?\d*)\s*$/', trim($line), $matches)) {
            return (float) $matches[1];
        }

        return null;
    }
}
