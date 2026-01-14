<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Document\DocumentHeader;

/**
 * Parser pour le FLAG DE (Entete Document).
 *
 * Format de la ligne :
 * Position 1-2   : FLAG "DE"
 * Position 3-16  : Reference document (14 an)
 * Position 17-30 : Date/heure document (14 n)
 * Position 31-33 : Code type de message (3 an)
 * Position 34-36 : Code statut message (3 an)
 * Position 37-42 : Version format (6 an)
 * Position 43-56 : Date debut periode (14 n)
 * Position 57-70 : Date fin periode (14 n)
 */
final class DELineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'DE';
    }

    protected function doParse(string $line, int $lineNumber): DocumentHeader
    {
        // Detection du format selon la longueur de la ligne
        // Certains fichiers ont un format simplifie
        $lineLength = strlen($line);

        if ($lineLength >= 70) {
            // Format complet
            return new DocumentHeader(
                referenceDocument: $this->extractField($line, 3, 14),
                dateHeureDocument: $this->extractDateTime($line, 17, 14),
                codeTypeMessage: $this->extractField($line, 31, 3),
                codeStatutMessage: $this->extractField($line, 34, 3),
                versionFormat: $this->extractField($line, 37, 6),
                dateDebutPeriode: $this->extractDateTime($line, 43, 14),
                dateFinPeriode: $this->extractDateTime($line, 57, 14),
            );
        }

        // Format simplifie observe dans les fichiers reels
        // Exemple: "DE                                    2024092500930.94"
        // La version est souvent a la fin
        $version = $this->extractVersionFromEnd($line);

        return new DocumentHeader(
            referenceDocument: $this->extractField($line, 3, 14),
            dateHeureDocument: $this->extractDateTime($line, 37, 12),
            versionFormat: $version,
        );
    }

    /**
     * Extrait la version depuis la fin de la ligne.
     */
    private function extractVersionFromEnd(string $line): ?string
    {
        // Recherche d'un pattern de version comme "0.94" ou "0.95"
        if (preg_match('/(\d\.\d{2})$/', trim($line), $matches)) {
            return $matches[1];
        }

        return null;
    }
}
