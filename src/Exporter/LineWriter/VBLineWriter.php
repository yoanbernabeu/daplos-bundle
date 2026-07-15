<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Intervention\CibleEvenement;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG VB (Cible évènement).
 *
 * Positions symetriques du VBLineParser (guide DAPLOS v0.95, page 35).
 */
final class VBLineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'VB';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $cible = $this->assertDtoType($dto, CibleEvenement::class);

        $buffer->setField(3, 8, $cible->identifiantParcelle);
        $buffer->setInt(11, 4, $cible->annee);
        $buffer->setField(15, 32, $cible->refIntervention);
        $buffer->setField(47, 3, $cible->codeOrganismeCible);
        $buffer->setField(50, 12, $cible->codeCibleV095);
    }
}
