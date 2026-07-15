<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG DP (Parcelle Culturale).
 *
 * Positions symetriques du DPLineParser (guide DAPLOS v0.95, pages 13-16).
 */
final class DPLineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'DP';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $parcelle = $this->assertDtoType($dto, ParcelleCulturale::class);

        $buffer->setField(3, 8, $parcelle->identifiant);
        $buffer->setInt(11, 4, $parcelle->annee);
        $buffer->setDate(15, 8, $parcelle->dateDebutParcelle);
        $buffer->setDate(23, 8, $parcelle->dateCreationFiche);
        $buffer->setDate(31, 8, $parcelle->dateDerniereSaisie);
        $buffer->setDate(39, 8, $parcelle->dateFinParcelle);
        $buffer->setField(47, 3, $parcelle->codeEspeceBotanique);
        $buffer->setField(50, 7, $parcelle->codeVariete);
        $buffer->setField(57, 7, $parcelle->codeVariete2);
        $buffer->setField(64, 7, $parcelle->codeVariete3);
        $buffer->setField(71, 7, $parcelle->codeVariete4);
        $buffer->setField(78, 7, $parcelle->codeVariete5);
        $buffer->setField(85, 3, $parcelle->codeQualifiantCulture);
        $buffer->setField(88, 3, $parcelle->codePeriodeSemis);
        $buffer->setField(91, 3, $parcelle->codeDestinationCulture);
        $buffer->setDecimal(94, 9, $parcelle->rendementObjectif);
        $buffer->setField(103, 3, $parcelle->codeUniteRendement);
        $buffer->setField(106, 35, $parcelle->nom);
        $buffer->setField(141, 10, $parcelle->numeroIlotPac);
        $buffer->setField(151, 10, $parcelle->numeroParcellePerenne);
        $buffer->setField(161, 6, $parcelle->codeCommune);
        $buffer->setInt(167, 3, $parcelle->profondeurSol);
        $buffer->setInt(170, 3, $parcelle->pierrosite);
        $buffer->setField(173, 3, $parcelle->codeTypeSol);
        $buffer->setField(176, 35, $parcelle->autreTypeSol);
        $buffer->setField(211, 3, $parcelle->codeAcidite);
        $buffer->setField(214, 3, $parcelle->codeProfondeurSousSol);
        $buffer->setField(217, 3, $parcelle->codeTypeSousSol);
        $buffer->setField(220, 3, $parcelle->codeCultureIntermediaire);
        $buffer->setBool(223, $parcelle->solHydromorphe);
        $buffer->setBool(224, $parcelle->parcelleDrainee);
        $buffer->setBool(225, $parcelle->parcelleRedecoupee);
        $buffer->setField(226, 4, $parcelle->cleParcelleInitiale);
        $buffer->setField(230, 3, $parcelle->codeGestionResidus);
        $buffer->setDecimal(233, 9, $parcelle->quantiteEpandue);
        $buffer->setField(242, 9, $parcelle->codeTypeSolV095);
        $buffer->setDecimal(251, 9, $parcelle->doseAzote);
    }
}
