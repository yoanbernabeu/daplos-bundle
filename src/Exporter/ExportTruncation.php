<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter;

/**
 * Valeur texte coupée à l'export parce qu'elle dépasse la longueur de son champ.
 *
 * Le parser lit certaines zones au-delà de la largeur du guide (ex. DT 26-45,
 * PV 485-494) pour ne jamais perdre de données ; l'exporter, lui, respecte les
 * largeurs du guide et signale ici chaque valeur coupée.
 */
final class ExportTruncation
{
    /**
     * @param string   $flag         FLAG de la ligne (DT, PV...)
     * @param int      $position     Position de début du champ (1-based, comme le guide)
     * @param int      $length       Longueur du champ en octets
     * @param string   $value        Valeur complète reçue
     * @param string   $writtenValue Valeur effectivement écrite (UTF-8)
     * @param int|null $lineNumber   Numéro de la ligne dans le fichier exporté (1-based)
     */
    public function __construct(
        public readonly string $flag,
        public readonly int $position,
        public readonly int $length,
        public readonly string $value,
        public readonly string $writtenValue,
        public readonly ?int $lineNumber = null,
    ) {
    }

    public function withLineNumber(int $lineNumber): self
    {
        return new self($this->flag, $this->position, $this->length, $this->value, $this->writtenValue, $lineNumber);
    }

    public function getMessage(): string
    {
        return sprintf(
            '%s %d-%d%s : "%s" tronqué en "%s" (%d octets maximum)',
            $this->flag,
            $this->position,
            $this->position + $this->length - 1,
            null !== $this->lineNumber ? sprintf(' (ligne %d)', $this->lineNumber) : '',
            $this->value,
            $this->writtenValue,
            $this->length,
        );
    }
}
