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

    /** @var list<ExportTruncation> */
    private array $truncations = [];

    public function __construct(private readonly string $flag)
    {
        $this->line = $flag;
    }

    /**
     * Place un champ texte a une position donnee.
     *
     * La valeur est convertie en ISO-8859-1, tronquee a la longueur du champ
     * et completee a droite par des espaces. Toute troncature est signalee
     * (voir getTruncations()).
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
        if (strlen($encoded) > $length) {
            $encoded = substr($encoded, 0, $length);
            $this->truncations[] = new ExportTruncation(
                $this->flag,
                $start,
                $length,
                $value,
                mb_check_encoding($value, 'UTF-8') ? mb_convert_encoding($encoded, 'UTF-8', 'ISO-8859-1') : $encoded,
            );
        }

        $this->place($start, str_pad($encoded, $length));
    }

    /**
     * Valeurs texte coupees par setField() depuis la creation du tampon.
     *
     * @return list<ExportTruncation>
     */
    public function getTruncations(): array
    {
        return $this->truncations;
    }

    /**
     * Place un champ entier, cadre a droite et complete par des 0 a gauche
     * (guide DAPLOS v0.95, formats des messages).
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

        $this->place($start, $this->padNumber($formatted, $length));
    }

    /**
     * Place un champ decimal, cadre a droite et complete par des 0 a gauche
     * (guide DAPLOS v0.95 : 2,2 s'ecrit 0000002.2), sans perte de decimales
     * ni zeros inutiles en partie decimale.
     *
     * @throws DaplosExportException Si la valeur depasse la longueur du champ
     */
    public function setDecimal(int $start, int $length, ?float $value): void
    {
        if (null === $value) {
            return;
        }

        // Le cast PHP produit la representation decimale la plus courte qui
        // restitue exactement le float (serialize_precision=-1)
        $formatted = (string) $value;
        if (str_contains($formatted, 'E')) {
            $formatted = rtrim(rtrim(sprintf('%.10F', $value), '0'), '.');
        }

        // Zero initial omis si necessaire pour tenir dans le champ,
        // comme le font les emetteurs DAPLOS reels (ex. ".81999999")
        if (strlen($formatted) > $length) {
            $formatted = preg_replace('/^(-?)0\./', '$1.', $formatted) ?? $formatted;
        }

        if (strlen($formatted) > $length) {
            throw new DaplosExportException(sprintf('La valeur "%s" depasse la longueur du champ (%d) a la position %d', $formatted, $length, $start));
        }

        $this->place($start, $this->padNumber($formatted, $length));
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
     * Complete un nombre par des 0 a gauche jusqu'a la longueur du champ ;
     * le signe moins reste en tete (-5 sur 4 caracteres : -005).
     */
    private function padNumber(string $formatted, int $length): string
    {
        if (str_starts_with($formatted, '-')) {
            return '-'.str_pad(substr($formatted, 1), $length - 1, '0', STR_PAD_LEFT);
        }

        return str_pad($formatted, $length, '0', STR_PAD_LEFT);
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
