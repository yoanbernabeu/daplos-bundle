<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Amendement;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG HA (Amendement/Residus).
 *
 * Positions symetriques du HALineParser (guide DAPLOS v0.95, pages 27-28).
 */
final class HALineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'HA';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $amendement = $this->assertDtoType($dto, Amendement::class);

        $buffer->setField(3, 8, $amendement->identifiantParcelle);
        $buffer->setInt(11, 4, $amendement->annee);
        $buffer->setField(15, 3, $amendement->codeAmendement);
        $buffer->setField(18, 35, $amendement->complementTypeAmendement);
        $buffer->setDate(53, 8, $amendement->dateAmendement);
        $buffer->setDecimal(61, 9, $amendement->quantite);
        $buffer->setField(70, 3, $amendement->codeUnite);
        $buffer->setField(73, 35, $amendement->origineRaisonSociale1);
        $buffer->setField(108, 35, $amendement->origineRaisonSociale2);
        $buffer->setField(143, 35, $amendement->origineAdresseRue1);
        $buffer->setField(178, 35, $amendement->origineAdresseRue2);
        $buffer->setField(213, 35, $amendement->origineVille);
        $buffer->setField(248, 9, $amendement->origineCodePostal);
        $buffer->setField(257, 2, $amendement->originePays);
    }
}
