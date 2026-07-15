<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Document\TypeAgriculture;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG DT (Type d'agriculture pratiquée).
 *
 * Positions symetriques du DTLineParser (guide DAPLOS v0.95, page 12).
 */
final class DTLineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'DT';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $type = $this->assertDtoType($dto, TypeAgriculture::class);

        $buffer->setField(3, 3, $type->codeTypeAgriculture);
        $buffer->setField(6, 20, $type->numeroCertificat);
        $buffer->setField(26, 20, $type->libelle);
    }
}
