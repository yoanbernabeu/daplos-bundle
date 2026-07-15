<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Coordonnee;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG SC (Coordonnees Surface).
 *
 * Positions symetriques du SCLineParser (guide DAPLOS v0.95).
 */
final class SCLineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'SC';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $coordonnee = $this->assertDtoType($dto, Coordonnee::class);

        $buffer->setField(3, 8, $coordonnee->identifiantParcelle);
        $buffer->setInt(11, 4, $coordonnee->annee);
        $buffer->setField(15, 3, $coordonnee->systemeCoordonnees);
        $buffer->setDecimal(18, 11, $coordonnee->x);
        $buffer->setDecimal(29, 10, $coordonnee->y);
        $buffer->setDecimal(39, 18, $coordonnee->altitude);
    }
}
