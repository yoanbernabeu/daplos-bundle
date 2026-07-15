<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Recolte\CaracterisationProduit;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG LC (Caractérisation du produit récolté pour le lot).
 *
 * Positions symetriques du LCLineParser (guide DAPLOS v0.95, page 48).
 */
final class LCLineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'LC';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $caracterisation = $this->assertDtoType($dto, CaracterisationProduit::class);

        $buffer->setField(3, 8, $caracterisation->identifiantParcelle);
        $buffer->setInt(11, 4, $caracterisation->annee);
        $buffer->setField(15, 32, $caracterisation->refIntervention);
        $buffer->setField(47, 3, $caracterisation->codeCaracteristique);
        $buffer->setField(50, 9, $caracterisation->valeur);
        $buffer->setField(59, 3, $caracterisation->codeUnite);
    }
}
