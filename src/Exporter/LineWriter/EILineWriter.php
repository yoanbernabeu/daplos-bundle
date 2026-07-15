<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Interchange\InterchangeHeader;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG EI (Enveloppe Interchange).
 *
 * Positions symetriques du EILineParser (guide DAPLOS v0.95, page 8).
 */
final class EILineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'EI';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $header = $this->assertDtoType($dto, InterchangeHeader::class);

        $buffer->setField(3, 14, $header->identificationEmetteur);
        $buffer->setField(17, 3, $header->typeCodificationEmetteur);
        $buffer->setField(20, 14, $header->identificationDestinataire);
        $buffer->setField(34, 3, $header->typeCodificationDestinataire);
        $buffer->setInt(37, 4, $header->nombreDocuments);
    }
}
