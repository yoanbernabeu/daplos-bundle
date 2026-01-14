<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Intrant\Intrant;

/**
 * Parser pour le FLAG VI (Intrant).
 *
 * Format observe :
 * Position 1-2   : FLAG "VI"
 * Position 3-10  : Identifiant parcelle (8 an)
 * Position 11-14 : Annee (4 n)
 * Position 15-46 : Reference intervention UUID (32 an)
 * Position 47-49 : Code type intrant (3 an) - ZIU, ZIV, ZJC, ZJF, etc.
 * Position 50-84 : Designation produit (35 an)
 * Position 85-93 : Quantite (9 n avec decimales)
 * Position 94-96 : Code unite (3 an) - LTR, KGM, TNE, etc.
 * Position 97-131: Code AMM (35 an) - pour phyto
 * Position 132-138: Code GNIS (7 an) - pour semences
 * Position 139-147: Code variete (9 an)
 * Position 148-150: Code qualifiant intrant (3 an)
 */
final class VILineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'VI';
    }

    protected function doParse(string $line, int $lineNumber): Intrant
    {
        $idParcelle = $this->extractField($line, 3, 8);
        $annee = $this->extractInt($line, 11, 4);
        $refIntervention = $this->extractField($line, 15, 32);

        // Type intrant
        $codeTypeIntrant = $this->extractField($line, 47, 3);

        // Designation
        $designation = $this->extractField($line, 50, 35);

        // Quantite et unite - recherche dans la partie variable
        $quantiteInfo = $this->extractQuantiteEtUnite($line);

        // Code AMM (pour les phytos)
        $codeAMM = $this->extractField($line, 97, 35);

        // Code GNIS (pour semences)
        $codeGNIS = $this->extractField($line, 132, 7);

        // Code variete
        $codeVariete = $this->extractField($line, 139, 9);

        // Code qualifiant
        $codeQualifiant = $this->extractField($line, 148, 3);

        return new Intrant(
            identifiantParcelle: $idParcelle,
            annee: $annee,
            refIntervention: $refIntervention,
            codeTypeIntrant: $codeTypeIntrant,
            designation: $designation,
            quantite: $quantiteInfo['quantite'],
            codeUnite: $quantiteInfo['unite'],
            codeAMM: '' !== $codeAMM ? $codeAMM : null,
            codeGNIS: '' !== $codeGNIS ? $codeGNIS : null,
            codeVariete: '' !== $codeVariete ? $codeVariete : null,
            codeQualifiantIntrant: '' !== $codeQualifiant ? $codeQualifiant : null,
        );
    }

    /**
     * Extrait la quantite et l'unite de mesure.
     *
     * @return array{quantite: float|null, unite: string|null}
     */
    private function extractQuantiteEtUnite(string $line): array
    {
        // Recherche d'un pattern quantite + unite (ex: "000055   LTR", "2844.8718LTR")
        if (preg_match('/(\d+\.?\d*)\s*(LTR|KGM|TNE|MTQ|HAR|MTR|NMB|KLT|GRM|MGM|MLT|QTL)/', $line, $matches)) {
            return [
                'quantite' => (float) $matches[1],
                'unite' => $matches[2],
            ];
        }

        return [
            'quantite' => null,
            'unite' => null,
        ];
    }
}
