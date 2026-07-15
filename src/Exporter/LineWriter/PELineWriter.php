<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Engagement;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG PE (Engagement).
 *
 * Positions symetriques du PELineParser (guide DAPLOS v0.95, page 24).
 */
final class PELineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'PE';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $engagement = $this->assertDtoType($dto, Engagement::class);

        $buffer->setField(3, 8, $engagement->identifiantParcelle);
        $buffer->setInt(11, 4, $engagement->annee);
        $buffer->setField(15, 3, $engagement->codeEngagement);
        $buffer->setField(18, 35, $engagement->libelle);
        $buffer->setField(53, 35, $engagement->numeroContrat);
        $buffer->setDate(88, 8, $engagement->dateContrat);
        $buffer->setField(96, 14, $engagement->identificationContractant);
        $buffer->setField(110, 3, $engagement->typeIdentificationContractant);
        $buffer->setField(113, 35, $engagement->contractantRaisonSociale1);
        $buffer->setField(148, 35, $engagement->contractantRaisonSociale2);
        $buffer->setField(183, 35, $engagement->contractantAdresseRue1);
        $buffer->setField(218, 35, $engagement->contractantAdresseRue2);
        $buffer->setField(253, 35, $engagement->contractantVille);
        $buffer->setField(288, 9, $engagement->contractantCodePostal);
        $buffer->setField(297, 2, $engagement->contractantPays);
    }
}
