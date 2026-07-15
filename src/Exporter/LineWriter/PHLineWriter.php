<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Historique;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG PH (Historique/Precedent cultural).
 *
 * Positions symetriques du PHLineParser (guide DAPLOS v0.95, pages 26-27).
 */
final class PHLineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'PH';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $historique = $this->assertDtoType($dto, Historique::class);

        $buffer->setField(3, 8, $historique->identifiantParcelle);
        $buffer->setInt(11, 4, $historique->annee);
        // N° d'ordre du precedent : chiffre negatif de -1 a -9 (2 an)
        if (null !== $historique->indexPrecedent) {
            $buffer->setField(15, 2, (string) $historique->indexPrecedent);
        }
        $buffer->setField(17, 4, $historique->cleParcellePrecedent);
        $buffer->setField(21, 3, $historique->codeEspeceBotanique);
        $buffer->setField(24, 7, $historique->varieteSemee1);
        $buffer->setField(31, 7, $historique->varieteSemee2);
        $buffer->setField(38, 7, $historique->varieteSemee3);
        $buffer->setField(45, 7, $historique->varieteSemee4);
        $buffer->setField(52, 7, $historique->varieteSemee5);
        $buffer->setField(59, 3, $historique->codeQualifiantEspece);
        $buffer->setField(62, 3, $historique->codePeriodeSemis);
        $buffer->setField(65, 3, $historique->codeDestination);
        $buffer->setField(68, 3, $historique->codeGestionResidus);
        $buffer->setDecimal(71, 9, $historique->quantiteEpandue);
    }
}
