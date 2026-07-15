<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Analyse;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG PA (Analyse de sol).
 *
 * Positions symetriques du PALineParser (guide DAPLOS v0.95, page 29).
 */
final class PALineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'PA';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $analyse = $this->assertDtoType($dto, Analyse::class);

        $buffer->setField(3, 8, $analyse->identifiantParcelle);
        $buffer->setInt(11, 4, $analyse->annee);
        $buffer->setField(15, 35, $analyse->numeroBordereau);
        $buffer->setField(50, 9, $analyse->identificationLaboratoire);
        $buffer->setField(59, 35, $analyse->laboratoireRaisonSociale1);
        $buffer->setField(94, 35, $analyse->laboratoireRaisonSociale2);
        $buffer->setField(129, 35, $analyse->laboratoireAdresseRue1);
        $buffer->setField(164, 35, $analyse->laboratoireAdresseRue2);
        $buffer->setField(199, 35, $analyse->laboratoireVille);
        $buffer->setField(234, 9, $analyse->laboratoireCodePostal);
        $buffer->setField(243, 2, $analyse->laboratoirePays);
        $buffer->setDate(245, 8, $analyse->dateAnalyse);
        $buffer->setDate(253, 8, $analyse->datePrelevement);
    }
}
