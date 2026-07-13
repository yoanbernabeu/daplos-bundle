<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Interchange\InterchangeHeader;

/**
 * Parser pour le FLAG EI (Enveloppe Interchange).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), page 8 :
 *
 * Position 3-16  : Identification de l'émetteur (14 an) — SIRET si exploitation, sinon EAN
 * Position 17-19 : Type de codification émetteur en code (3 an) — 5 SIRET / 14 EAN
 * Position 20-33 : Identification du destinataire (14 an) — SIRET si exploitation, sinon EAN
 * Position 34-36 : Type de codification destinataire en code (3 an) — 5 SIRET / 14 EAN
 * Position 37-40 : Nombre de documents dans l'envoi (4 n)
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
            identificationEmetteur: $this->extractField($line, 3, 14),
            identificationDestinataire: $this->extractField($line, 20, 14),
            typeCodificationEmetteur: $this->extractField($line, 17, 3),
            typeCodificationDestinataire: $this->extractField($line, 34, 3),
            nombreDocuments: $this->extractInt($line, 37, 4),
        );
    }
}
