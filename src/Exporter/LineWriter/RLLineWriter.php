<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Recolte\LotRecolte;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG RL (Lot Récolte).
 *
 * Positions symetriques du RLLineParser (guide DAPLOS v0.95, page 47).
 */
final class RLLineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'RL';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $lot = $this->assertDtoType($dto, LotRecolte::class);

        $buffer->setField(3, 8, $lot->identifiantParcelle);
        $buffer->setInt(11, 4, $lot->annee);
        $buffer->setField(15, 32, $lot->refIntervention);
        $buffer->setField(47, 35, $lot->numeroLot);
        $buffer->setField(82, 35, $lot->numeroLotAgriculteur);
        $buffer->setDecimal(117, 9, $lot->quantite);
    }
}
