<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\SurfaceParcelle;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG PS (Surface Parcelle).
 *
 * Positions symetriques du PSLineParser (guide DAPLOS v0.95).
 */
final class PSLineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'PS';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $surface = $this->assertDtoType($dto, SurfaceParcelle::class);

        $buffer->setField(3, 8, $surface->identifiantParcelle);
        $buffer->setInt(11, 4, $surface->annee);
        $buffer->setField(15, 3, $surface->typeSurface);
        $buffer->setDecimal(18, 9, $surface->surface);
    }
}
