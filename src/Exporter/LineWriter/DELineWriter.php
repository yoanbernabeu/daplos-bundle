<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Document\DocumentHeader;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG DE (Entête du document).
 *
 * Positions symetriques du DELineParser (guide DAPLOS v0.95, page 9).
 */
final class DELineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'DE';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $header = $this->assertDtoType($dto, DocumentHeader::class);

        $buffer->setField(3, 35, $header->referenceDocument);
        $buffer->setField(38, 1, $header->codeFonction);
        $buffer->setDate(39, 8, $header->dateHeureDocument);
        $buffer->setInt(47, 4, $header->nombreFichesParcellaires);
        $buffer->setField(51, 4, $header->versionFormat);
    }
}
