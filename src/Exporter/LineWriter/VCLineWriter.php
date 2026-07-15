<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Coordonnee;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG VC (Coordonnées géographiques de l'intervention).
 *
 * Positions symetriques du VCLineParser (guide DAPLOS v0.95, page 34).
 */
final class VCLineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'VC';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $coordonnee = $this->assertDtoType($dto, Coordonnee::class);

        $buffer->setField(3, 8, $coordonnee->identifiantParcelle);
        $buffer->setInt(11, 4, $coordonnee->annee);
        $buffer->setField(15, 32, $coordonnee->refIntervention);
        $buffer->setField(47, 3, $coordonnee->systemeCoordonnees);
        $buffer->setDecimal(50, 11, $coordonnee->x);
        $buffer->setDecimal(61, 10, $coordonnee->y);
        $buffer->setDecimal(71, 18, $coordonnee->altitude);
    }
}
