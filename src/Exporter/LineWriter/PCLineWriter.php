<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCadastrale;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG PC (Parcelle Cadastrale).
 *
 * Positions symetriques du PCLineParser (guide DAPLOS v0.95, pages 19-20).
 * Le bloc cadastral 15-30 est ecrit depuis numeroParcelleCadastrale s'il est
 * renseigne, sinon compose depuis codeCommune + section + numero + subdivision.
 */
final class PCLineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'PC';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $parcelle = $this->assertDtoType($dto, ParcelleCadastrale::class);

        $buffer->setField(3, 8, $parcelle->identifiantParcelle);
        $buffer->setInt(11, 4, $parcelle->annee);
        $buffer->setField(15, 16, $this->buildBlocCadastral($parcelle));
        $buffer->setDecimal(31, 9, $parcelle->surface);
    }

    /**
     * Construit le bloc cadastral complet (16 an) : departement + commune (6),
     * section (2), numero (6), subdivision fiscale (2).
     */
    private function buildBlocCadastral(ParcelleCadastrale $parcelle): ?string
    {
        if (null !== $parcelle->numeroParcelleCadastrale) {
            return $parcelle->numeroParcelleCadastrale;
        }

        $bloc = str_pad((string) $parcelle->codeCommune, 6)
            .str_pad((string) $parcelle->section, 2)
            .str_pad((string) $parcelle->numero, 6)
            .str_pad((string) $parcelle->subdivisionFiscale, 2);

        return '' === trim($bloc) ? null : $bloc;
    }
}
