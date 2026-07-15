<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Intrant\LotFabricant;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG IL (Lot fabricant).
 *
 * Positions symetriques du ILLineParser (guide DAPLOS v0.95, page 43).
 */
final class ILLineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'IL';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $lot = $this->assertDtoType($dto, LotFabricant::class);

        $buffer->setField(3, 8, $lot->identifiantParcelle);
        $buffer->setInt(11, 4, $lot->annee);
        $buffer->setField(15, 32, $lot->refIntervention);
        $buffer->setField(47, 35, $lot->codeProduit);
        $buffer->setField(82, 35, $lot->numeroLot);
        $buffer->setDecimal(117, 9, $lot->quantite);
        $buffer->setField(126, 3, $lot->codeUnite);
        $buffer->setDecimal(129, 9, $lot->pmg);
        $buffer->setField(138, 3, $lot->codeUnitePmg);
    }
}
