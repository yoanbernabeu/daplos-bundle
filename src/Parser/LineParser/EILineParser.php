<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Interchange\InterchangeHeader;

/**
 * Parser pour le FLAG EI (Enveloppe Interchange).
 *
 * Format de la ligne :
 * Position 1-2   : FLAG "EI"
 * Position 3-37  : Identification emetteur (35 an)
 * Position 38-72 : Identification destinataire (35 an)
 * Position 73-86 : Date/heure preparation (14 n) YYYYMMDDHHMM
 * Position 87-100: Reference interchange (14 an)
 */
final class EILineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'EI';
    }

    protected function doParse(string $line, int $lineNumber): InterchangeHeader
    {
        return new InterchangeHeader(
            identificationEmetteur: $this->extractField($line, 3, 35),
            identificationDestinataire: $this->extractField($line, 38, 35),
            dateHeurePreparation: $this->extractDateTime($line, 73, 14),
            referenceInterchange: $this->extractField($line, 87, 14),
        );
    }
}
