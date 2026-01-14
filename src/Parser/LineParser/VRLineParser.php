<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Recolte\Recolte;

/**
 * Parser pour le FLAG VR (Recolte).
 *
 * Format observe :
 * Position 1-2   : FLAG "VR"
 * Position 3-10  : Identifiant parcelle (8 an)
 * Position 11-14 : Annee (4 n)
 * Position 15-46 : Reference intervention UUID (32 an)
 * Position 47-49 : Code type produit recolte (3 an) - ZJH
 * Position 50-52 : Code espece botanique (3 an) - ZAR
 * Position 53-87 : Libelle produit (35 an)
 * Position 88-96 : Quantite (9 n avec decimales)
 * Position 97-99 : Code unite (3 an) - TNE, KGM, etc.
 */
final class VRLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'VR';
    }

    protected function doParse(string $line, int $lineNumber): Recolte
    {
        $idParcelle = $this->extractField($line, 3, 8);
        $annee = $this->extractInt($line, 11, 4);
        $refIntervention = $this->extractField($line, 15, 32);

        // Codes produit
        $codeTypeProduit = $this->extractField($line, 47, 3);
        $codeEspece = $this->extractField($line, 50, 3);

        // Libelle produit
        $libelleProduit = $this->extractField($line, 53, 35);

        // Quantite et unite - recherche flexible
        $quantiteInfo = $this->extractQuantiteEtUnite($line);

        return new Recolte(
            identifiantParcelle: $idParcelle,
            annee: $annee,
            refIntervention: $refIntervention,
            codeTypeProduitRecolte: $codeTypeProduit,
            codeEspeceBotanique: $codeEspece,
            libelleProduit: $libelleProduit,
            quantite: $quantiteInfo['quantite'],
            codeUnite: $quantiteInfo['unite'],
        );
    }

    /**
     * Extrait la quantite et l'unite de mesure.
     *
     * @return array{quantite: float|null, unite: string|null}
     */
    private function extractQuantiteEtUnite(string $line): array
    {
        // Recherche d'un pattern quantite + unite
        if (preg_match('/(\d+\.?\d*)\s*(TNE|KGM|LTR|QTL|HAR)/', $line, $matches)) {
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
