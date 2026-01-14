<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\Reader;

use YoanBernabeu\DaplosBundle\Parser\Exception\DaplosParseException;

/**
 * Lecteur de fichiers DAPLOS avec gestion de l'encodage.
 *
 * IMPORTANT: Les fichiers DAPLOS utilisent des positions fixes en octets.
 * La conversion d'encodage vers UTF-8 n'est PAS faite ici car elle
 * modifierait la longueur des lignes (caractères accentués ISO-8859-1
 * passent de 1 à 2 octets en UTF-8), ce qui décalerait les positions.
 *
 * La conversion UTF-8 est faite dans AbstractLineParser::extractField()
 * uniquement sur les valeurs extraites.
 */
final class FileReader implements ReaderInterface
{
    private const DEFAULT_ENCODING = 'auto';

    private ?string $detectedEncoding = null;

    public function __construct(
        private readonly string $filePath,
        private readonly string $encoding = self::DEFAULT_ENCODING,
    ) {
    }

    public function readLines(): iterable
    {
        if (!file_exists($this->filePath)) {
            throw new DaplosParseException(sprintf('Fichier introuvable : %s', $this->filePath));
        }

        $handle = fopen($this->filePath, 'r');
        if (false === $handle) {
            throw new DaplosParseException(sprintf('Impossible d\'ouvrir le fichier : %s', $this->filePath));
        }

        // Détection de l'encodage sur la première ligne non vide
        $this->detectedEncoding = $this->detectFileEncoding($handle);
        rewind($handle);

        try {
            $lineNumber = 1;
            while (($line = fgets($handle)) !== false) {
                // On retourne la ligne brute (sans conversion) pour préserver les positions fixes
                yield $lineNumber++ => rtrim($line, "\r\n");
            }
        } finally {
            fclose($handle);
        }
    }

    /**
     * Retourne l'encodage détecté du fichier.
     */
    public function getDetectedEncoding(): ?string
    {
        return $this->detectedEncoding;
    }

    /**
     * Détecte l'encodage du fichier en analysant les premières lignes.
     *
     * @param resource $handle
     */
    private function detectFileEncoding($handle): string
    {
        if (self::DEFAULT_ENCODING !== $this->encoding) {
            return $this->encoding;
        }

        // Lire les premières lignes pour détecter l'encodage
        $sample = '';
        $count = 0;
        while (($line = fgets($handle)) !== false && $count < 10) {
            $sample .= $line;
            ++$count;
        }

        $detected = mb_detect_encoding($sample, ['UTF-8', 'ISO-8859-1', 'ISO-8859-15', 'Windows-1252'], true);

        return false !== $detected ? $detected : 'UTF-8';
    }
}
