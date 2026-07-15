<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Document\Intervenant;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG DA (Adresses intervenants).
 *
 * Positions symetriques du DALineParser (guide DAPLOS v0.95, pages 10-11).
 */
final class DALineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'DA';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $intervenant = $this->assertDtoType($dto, Intervenant::class);

        $buffer->setField(3, 3, $intervenant->typeIntervenant);
        $buffer->setField(6, 17, $intervenant->identification);
        $buffer->setField(23, 3, $intervenant->typeIdentification);
        $buffer->setField(26, 35, $intervenant->raisonSociale1);
        $buffer->setField(61, 35, $intervenant->raisonSociale2);
        $buffer->setField(96, 35, $intervenant->adresseRue1);
        $buffer->setField(131, 35, $intervenant->adresseRue2);
        $buffer->setField(166, 35, $intervenant->ville);
        $buffer->setField(201, 9, $intervenant->codePostal);
        $buffer->setField(210, 2, $intervenant->codePays);
        $buffer->setField(212, 20, $intervenant->referenceComplementaire1);
        $buffer->setField(232, 20, $intervenant->numeroPackage);
        $buffer->setField(252, 20, $intervenant->codeMSA);
    }
}
