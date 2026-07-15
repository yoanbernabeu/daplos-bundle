<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Intervention\HistoriqueDecision;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG VH (Historique Indicateur de décision).
 *
 * Positions symetriques du VHLineParser (guide DAPLOS v0.95, pages 49-50).
 */
final class VHLineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'VH';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $historique = $this->assertDtoType($dto, HistoriqueDecision::class);

        $buffer->setField(3, 8, $historique->identifiantParcelle);
        $buffer->setInt(11, 4, $historique->annee);
        $buffer->setField(15, 32, $historique->refIntervention);
        $buffer->setField(47, 3, $historique->codeTypeLien);
        $buffer->setField(50, 32, $historique->refEvenementConsidere);
        $buffer->setField(82, 4, $historique->numeroParcelleAnterieur);
        $buffer->setInt(86, 4, $historique->anneeRecolte);
        $buffer->setField(90, 17, $historique->identificationExploitation);
        $buffer->setField(107, 3, $historique->codeTypeIdentification);
        $buffer->setField(110, 35, $historique->exploitationRaisonSociale1);
        $buffer->setField(145, 35, $historique->exploitationRaisonSociale2);
        $buffer->setField(180, 35, $historique->exploitationAdresse1);
        $buffer->setField(215, 35, $historique->exploitationAdresse2);
        $buffer->setField(250, 35, $historique->exploitationVille);
        $buffer->setField(285, 9, $historique->exploitationCodePostal);
        $buffer->setField(294, 2, $historique->exploitationPays);
        $buffer->setField(296, 70, $historique->infoParcelleNonEdi1);
        $buffer->setField(366, 70, $historique->infoParcelleNonEdi2);
    }
}
