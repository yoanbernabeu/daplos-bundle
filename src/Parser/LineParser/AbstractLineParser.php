<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\Parser\Contract\LineParserInterface;
use YoanBernabeu\DaplosBundle\Parser\Exception\InvalidFlagException;

/**
 * Classe abstraite pour les parsers de ligne DAPLOS.
 *
 * Fournit des methodes utilitaires pour l'extraction de champs a positions fixes.
 * Utilise le pattern Template Method.
 */
abstract class AbstractLineParser implements LineParserInterface
{
    /**
     * Template Method : squelette de l'algorithme de parsing.
     */
    final public function parse(string $line, int $lineNumber = 0): object
    {
        $this->validateLine($line, $lineNumber);

        return $this->doParse($line, $lineNumber);
    }

    /**
     * Hook method : implementation specifique du parsing.
     */
    abstract protected function doParse(string $line, int $lineNumber): object;

    public function supports(string $line): bool
    {
        return str_starts_with($line, $this->getFlag());
    }

    /**
     * Valide que la ligne commence par le FLAG attendu.
     */
    protected function validateLine(string $line, int $lineNumber): void
    {
        $flag = substr($line, 0, 2);
        if ($flag !== $this->getFlag()) {
            throw new InvalidFlagException($flag, $lineNumber, $line);
        }
    }

    /**
     * Extrait un champ texte a une position donnee.
     *
     * Les positions sont en octets (pas en caractères) car les fichiers DAPLOS
     * utilisent des positions fixes. La valeur extraite est convertie en UTF-8
     * si nécessaire.
     *
     * @param string $line   La ligne source (brute, non convertie)
     * @param int    $start  Position de debut (1-based comme dans la spec DAPLOS)
     * @param int    $length Longueur du champ en octets
     *
     * @return string|null La valeur trimee en UTF-8 ou null si vide
     */
    protected function extractField(string $line, int $start, int $length): ?string
    {
        $value = substr($line, $start - 1, $length);
        $trimmed = trim($value);

        if ('' === $trimmed) {
            return null;
        }

        // Conversion en UTF-8 si nécessaire (pour les caractères accentués)
        return $this->toUtf8($trimmed);
    }

    /**
     * Convertit une chaîne en UTF-8 si elle ne l'est pas déjà.
     */
    private function toUtf8(string $value): string
    {
        // Vérifier si déjà UTF-8 valide
        if (mb_check_encoding($value, 'UTF-8')) {
            return $value;
        }

        // Détecter l'encodage source et convertir
        $detected = mb_detect_encoding($value, ['ISO-8859-1', 'ISO-8859-15', 'Windows-1252'], true);
        if (false !== $detected) {
            return mb_convert_encoding($value, 'UTF-8', $detected);
        }

        // Fallback: forcer la conversion depuis ISO-8859-1 (le plus courant pour DAPLOS)
        return mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
    }

    /**
     * Extrait un champ entier.
     */
    protected function extractInt(string $line, int $start, int $length): ?int
    {
        $value = $this->extractField($line, $start, $length);

        return null !== $value ? (int) $value : null;
    }

    /**
     * Extrait un champ decimal.
     */
    protected function extractFloat(string $line, int $start, int $length): ?float
    {
        $value = $this->extractField($line, $start, $length);
        if (null === $value) {
            return null;
        }

        // Gere les formats avec virgule ou point
        $normalized = str_replace(',', '.', $value);

        return (float) $normalized;
    }

    /**
     * Extrait une date/heure au format DAPLOS (YYYYMMDDHHMM ou YYYYMMDD).
     */
    protected function extractDateTime(string $line, int $start, int $length): ?\DateTimeImmutable
    {
        $value = $this->extractField($line, $start, $length);
        if (null === $value) {
            return null;
        }

        // Supprime les espaces et zeros de padding
        $cleaned = ltrim($value, '0 ');
        if ('' === $cleaned) {
            return null;
        }

        // Restaure le format complet
        $value = str_pad($cleaned, $length, '0', STR_PAD_LEFT);

        // Format YYYYMMDDHHMM (14 chars) ou YYYYMMDD (8 chars)
        $format = match (strlen($value)) {
            14 => 'YmdHi',
            12 => 'YmdHi',
            8 => 'Ymd',
            default => null,
        };

        if (null === $format) {
            return null;
        }

        $date = \DateTimeImmutable::createFromFormat($format, $value);

        return false !== $date ? $date : null;
    }

    /**
     * Extrait un champ booleen (O/N ou 1/0).
     */
    protected function extractBool(string $line, int $start, int $length = 1): ?bool
    {
        $value = $this->extractField($line, $start, $length);
        if (null === $value) {
            return null;
        }

        return match (strtoupper($value)) {
            'O', '1', 'OUI', 'TRUE', 'Y', 'YES' => true,
            'N', '0', 'NON', 'FALSE' => false,
            default => null,
        };
    }

    /**
     * Extrait un identifiant composite (idParcelle + annee + refIntervention).
     *
     * @return array{idParcelle: string|null, annee: int|null, refIntervention: string|null}
     */
    protected function extractCompositeId(string $line, int $start, int $idLength, int $anneeLength = 4, int $refLength = 32): array
    {
        $currentPos = $start;

        $idParcelle = $this->extractField($line, $currentPos, $idLength);
        $currentPos += $idLength;

        $annee = $this->extractInt($line, $currentPos, $anneeLength);
        $currentPos += $anneeLength;

        $refIntervention = $this->extractField($line, $currentPos, $refLength);

        return [
            'idParcelle' => $idParcelle,
            'annee' => $annee,
            'refIntervention' => $refIntervention,
        ];
    }
}
