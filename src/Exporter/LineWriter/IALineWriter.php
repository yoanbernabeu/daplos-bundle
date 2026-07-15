<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Intrant\AnalyseEffluent;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG IA (Analyse d'effluent).
 *
 * Positions symetriques du IALineParser (guide DAPLOS v0.95, page 44).
 */
final class IALineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'IA';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $analyse = $this->assertDtoType($dto, AnalyseEffluent::class);

        $buffer->setField(3, 8, $analyse->identifiantParcelle);
        $buffer->setInt(11, 4, $analyse->annee);
        $buffer->setField(15, 32, $analyse->refIntervention);
        $buffer->setField(47, 35, $analyse->numeroBordereau);
        $buffer->setField(82, 9, $analyse->identificationLaboratoire);
        $buffer->setField(91, 35, $analyse->laboratoireRaisonSociale1);
        $buffer->setField(126, 35, $analyse->laboratoireRaisonSociale2);
        $buffer->setField(161, 35, $analyse->laboratoireAdresse1);
        $buffer->setField(196, 35, $analyse->laboratoireAdresse2);
        $buffer->setField(231, 35, $analyse->laboratoireVille);
        $buffer->setField(266, 9, $analyse->laboratoireCodePostal);
        $buffer->setField(275, 2, $analyse->laboratoirePays);
        $buffer->setDate(277, 8, $analyse->dateAnalyse);
        $buffer->setDate(285, 8, $analyse->datePrelevement);
    }
}
