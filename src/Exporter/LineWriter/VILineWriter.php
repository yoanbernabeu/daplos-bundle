<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Intrant\Intrant;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG VI (Intrant).
 *
 * Positions symetriques du VILineParser (guide DAPLOS v0.95, pages 36-40).
 */
final class VILineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'VI';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $intrant = $this->assertDtoType($dto, Intrant::class);

        $buffer->setField(3, 8, $intrant->identifiantParcelle);
        $buffer->setInt(11, 4, $intrant->annee);
        $buffer->setField(15, 32, $intrant->refIntervention);
        $buffer->setField(47, 3, $intrant->codeTypeIntrant);
        $buffer->setField(50, 70, $intrant->designation);
        $buffer->setField(120, 13, $intrant->codeEAN);
        $buffer->setField(133, 35, $intrant->codeAMM);
        $buffer->setField(168, 7, $intrant->codeGNIS);
        $buffer->setField(175, 3, $intrant->codeApportOrganique);
        $buffer->setField(178, 3, $intrant->codeEAU);
        $buffer->setField(181, 3, $intrant->codeAdjuvant);
        $buffer->setField(184, 3, $intrant->codeCalcoMagnesien);
        $buffer->setField(187, 3, $intrant->codeQualifiantIntrant);
        $buffer->setField(190, 3, $intrant->codeQualifiantEffluent2);
        $buffer->setField(193, 3, $intrant->codeQualifiantEffluent3);
        $buffer->setField(196, 3, $intrant->codeQualifiantEffluent4);
        $buffer->setField(199, 3, $intrant->codeQualifiantEffluent5);
        $buffer->setField(202, 3, $intrant->codeQualifiantSemence1);
        $buffer->setField(205, 3, $intrant->codeQualifiantSemence2);
        $buffer->setField(208, 3, $intrant->codeQualifiantSemence3);
        $buffer->setDecimal(211, 9, $intrant->quantite);
        $buffer->setField(220, 3, $intrant->codeUnite);
        $buffer->setDecimal(223, 9, $intrant->quantiteEffectiveHa);
        $buffer->setField(232, 3, $intrant->codeUniteQuantiteEffectiveHa);
        $buffer->setDecimal(235, 9, $intrant->doseHaVisee);
        $buffer->setField(244, 3, $intrant->codeUniteDoseHaVisee);
        $buffer->setDecimal(247, 6, $intrant->nombrePassagesPreconises);
        $buffer->setField(253, 35, $intrant->origineEffluentRaisonSociale1);
        $buffer->setField(288, 35, $intrant->origineEffluentRaisonSociale2);
        $buffer->setField(323, 35, $intrant->origineEffluentAdresse1);
        $buffer->setField(358, 35, $intrant->origineEffluentAdresse2);
        $buffer->setField(393, 35, $intrant->origineEffluentVille);
        $buffer->setField(428, 9, $intrant->origineEffluentCodePostal);
        $buffer->setField(437, 2, $intrant->origineEffluentPays);
        $buffer->setDecimal(439, 9, $intrant->densiteVolumique);
    }
}
