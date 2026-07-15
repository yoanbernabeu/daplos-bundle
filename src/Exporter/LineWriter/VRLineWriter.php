<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Recolte\Recolte;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG VR (Récolte).
 *
 * Positions symetriques du VRLineParser (guide DAPLOS v0.95, pages 45-46).
 */
final class VRLineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'VR';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $recolte = $this->assertDtoType($dto, Recolte::class);

        $buffer->setField(3, 8, $recolte->identifiantParcelle);
        $buffer->setInt(11, 4, $recolte->annee);
        $buffer->setField(15, 32, $recolte->refIntervention);
        $buffer->setField(47, 3, $recolte->codeTypeProduitRecolte);
        $buffer->setField(50, 3, $recolte->codeEspeceBotanique);
        $buffer->setField(53, 35, $recolte->libelleProduit);
        $buffer->setField(88, 3, $recolte->destinationProduit);
        $buffer->setDecimal(91, 9, $recolte->quantite);
        $buffer->setField(100, 3, $recolte->codeUnite);
        $buffer->setDecimal(103, 9, $recolte->rendementCalcule);
        $buffer->setField(112, 3, $recolte->codeUniteRendementCalcule);
        $buffer->setDecimal(115, 9, $recolte->rendementEstime);
        $buffer->setField(124, 3, $recolte->codeUniteRendementEstime);
    }
}
