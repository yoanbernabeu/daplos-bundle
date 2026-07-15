<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter;

use YoanBernabeu\DaplosBundle\Exporter\Exception\DaplosExportException;

/**
 * Tampon de construction d'une ligne DAPLOS a positions fixes.
 *
 * Les positions du guide DAPLOS sont exprimees en octets : le tampon
 * travaille donc en ISO-8859-1 (1 caractere = 1 octet) et convertit les
 * valeurs UTF-8 a l'ecriture. L'operation inverse est realisee champ par
 * champ par AbstractLineParser::extractField().
 */
final class LineBuffer
{
    private string $line;

    public function __construct(string $flag)
    {
        $this->line = $flag;
    }

    /**
     * Place un champ texte a une position donnee.
     *
     * La valeur est convertie en ISO-8859-1, tronquee a la longueur du champ
     * et completee a droite par des espaces.
     *
     * @param int $start  Position de debut (1-based comme dans la spec DAPLOS)
     * @param int $length Longueur du champ en octets
     */
    public function setField(int $start, int $length, ?string $value): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        $encoded = $this->toSingleByte($value);
        $encoded = substr($encoded, 0, $length);

        $this->place($start, str_pad($encoded, $length));
    }

    /**
     * Place un champ entier, cadre a droite.
     *
     * @throws DaplosExportException Si la valeur depasse la longueur du champ
     */
    public function setInt(int $start, int $length, ?int $value): void
    {
        if (null === $value) {
            return;
        }

        $formatted = (string) $value;
        if (strlen($formatted) > $length) {
            throw new DaplosExportException(sprintf('La valeur "%s" depasse la longueur du champ (%d) a la position %d', $formatted, $length, $start));
        }

        $this->place($start, str_pad($formatted, $length, ' ', STR_PAD_LEFT));
    }

    /**
     * Place un champ decimal, cadre a droite (3 decimales maximum, sans zeros inutiles).
     *
     * @throws DaplosExportException Si la valeur depasse la longueur du champ
     */
    public function setDecimal(int $start, int $length, ?float $value): void
    {
        if (null === $value) {
            return;
        }

        $formatted = rtrim(rtrim(number_format($value, 3, '.', ''), '0'), '.');
        if ('' === $formatted || '-' === $formatted) {
            $formatted = '0';
        }

        if (strlen($formatted) > $length) {
            throw new DaplosExportException(sprintf('La valeur "%s" depasse la longueur du champ (%d) a la position %d', $formatted, $length, $start));
        }

        $this->place($start, str_pad($formatted, $length, ' ', STR_PAD_LEFT));
    }

    /**
     * Place une date au format DAPLOS : SSAAMMJJ (8) ou SSAAMMJJHHmm (12).
     */
    public function setDate(int $start, int $length, ?\DateTimeImmutable $value): void
    {
        if (null === $value) {
            return;
        }

        $format = 12 === $length ? 'YmdHi' : 'Ymd';

        $this->place($start, $value->format($format));
    }

    /**
     * Place un champ booleen : O (Oui) ou N (Non).
     */
    public function setBool(int $start, ?bool $value): void
    {
        if (null === $value) {
            return;
        }

        $this->place($start, $value ? 'O' : 'N');
    }

    /**
     * Retourne la ligne construite (ISO-8859-1), sans espaces de fin.
     */
    public function toString(): string
    {
        return rtrim($this->line, ' ');
    }

    /**
     * Place une valeur brute a la position donnee (1-based), en etendant
     * la ligne avec des espaces si necessaire.
     */
    private function place(int $start, string $value): void
    {
        $offset = $start - 1;

        if (strlen($this->line) < $offset) {
            $this->line = str_pad($this->line, $offset);
        }

        $this->line = substr_replace($this->line, $value, $offset, strlen($value));
    }

    /**
     * Convertit une valeur UTF-8 en ISO-8859-1 (les positions DAPLOS sont en octets).
     */
    private function toSingleByte(string $value): string
    {
        if (!mb_check_encoding($value, 'UTF-8')) {
            return $value;
        }

        return mb_convert_encoding($value, 'ISO-8859-1', 'UTF-8');
    }
}
