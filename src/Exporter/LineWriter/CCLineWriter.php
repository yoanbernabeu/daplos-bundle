<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Coordonnee;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG CC (Coordonnees Cadastrales).
 *
 * Positions symetriques du CCLineParser (guide DAPLOS v0.95).
 */
final class CCLineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'CC';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $coordonnee = $this->assertDtoType($dto, Coordonnee::class);

        $buffer->setField(3, 8, $coordonnee->identifiantParcelle);
        $buffer->setInt(11, 4, $coordonnee->annee);
        $buffer->setField(15, 16, $coordonnee->numeroParcelleCadastrale);
        $buffer->setField(31, 3, $coordonnee->systemeCoordonnees);
        $buffer->setDecimal(34, 11, $coordonnee->x);
        $buffer->setDecimal(45, 10, $coordonnee->y);
        $buffer->setDecimal(55, 18, $coordonnee->altitude);
    }
}
