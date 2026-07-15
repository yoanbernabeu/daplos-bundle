<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Intrant\CompositionFertilisation;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG IC (Composition du produit en cas de fertilisation minérale).
 *
 * Positions symetriques du ICLineParser (guide DAPLOS v0.95, pages 41-42).
 */
final class ICLineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'IC';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $composition = $this->assertDtoType($dto, CompositionFertilisation::class);

        $buffer->setField(3, 8, $composition->identifiantParcelle);
        $buffer->setInt(11, 4, $composition->annee);
        $buffer->setField(15, 32, $composition->refIntervention);
        $buffer->setField(47, 3, $composition->codeElement);
        $buffer->setDecimal(50, 9, $composition->teneur);
    }
}
