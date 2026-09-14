<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\LineWriter;

use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

/**
 * Writer pour le FLAG PV (Evenement/Intervention).
 *
 * Positions symetriques du PVLineParser (guide DAPLOS v0.95, pages 30-33).
 */
final class PVLineWriter extends AbstractLineWriter
{
    public function getFlag(): string
    {
        return 'PV';
    }

    protected function fillBuffer(LineBuffer $buffer, object $dto): void
    {
        $evenement = $this->assertDtoType($dto, Evenement::class);

        $buffer->setField(3, 8, $evenement->identifiantParcelle);
        $buffer->setInt(11, 4, $evenement->annee);
        $buffer->setField(15, 32, $evenement->refIntervention);
        $buffer->setField(47, 1, $evenement->codeAction);
        // Type d'évènement : nomenclature Catégorie d'intervention (l'intervention agricole va en 165-167)
        $buffer->setField(48, 3, $evenement->codeCategorieIntervention ?? $evenement->codeIntervention);
        $buffer->setField(51, 3, $evenement->codeStatutIntervention);
        $buffer->setField(54, 35, $evenement->libelleIntervention);
        $buffer->setDate(89, 12, $evenement->dateDebutIntervention);
        $buffer->setDate(101, 12, $evenement->dateFinIntervention);
        $buffer->setField(113, 6, $evenement->dureeTraitement);
        $buffer->setDate(119, 8, $evenement->datePreconisation);
        $buffer->setField(127, 3, $evenement->codeStadeVegetatif);
        $buffer->setField(130, 35, $evenement->libelleStadeVegetatif);
        $buffer->setField(165, 3, $evenement->codeTypeTravail);
        $buffer->setField(168, 35, $evenement->complementTypeTravail);
        $buffer->setField(203, 3, $evenement->codeJustificationIntervention);
        $buffer->setField(206, 35, $evenement->complementMotivation);
        $buffer->setField(241, 3, $evenement->codeTypeOperateur);
        $buffer->setField(244, 18, $evenement->numeroLicenceOperateur);
        $buffer->setField(262, 37, $evenement->nomOperateur);
        $buffer->setField(299, 3, $evenement->codeConditionsMeteo);
        $buffer->setField(302, 3, $evenement->codeTraitementsSpeciaux);

        // Temperature : signe en 305, valeur absolue en 306-308
        if (null !== $evenement->temperatureExterieure) {
            $buffer->setField(305, 1, $evenement->temperatureExterieure < 0 ? '-' : '+');
            $buffer->setInt(306, 3, abs($evenement->temperatureExterieure));
        }

        $buffer->setInt(309, 3, $evenement->pourcentageHygrometrie);
        $buffer->setDecimal(312, 9, $evenement->quantiteBouillieViseeHa);
        $buffer->setField(321, 3, $evenement->uniteBouillieViseeHa);
        $buffer->setDecimal(324, 9, $evenement->quantiteBouillieEffectiveHa);
        $buffer->setField(333, 3, $evenement->uniteBouillieEffectiveHa);
        $buffer->setDecimal(336, 9, $evenement->surfaceTraitee);

        [$commentaire1, $commentaire2] = $this->splitCommentaire($evenement->commentaire);
        $buffer->setField(345, 70, $commentaire1);
        $buffer->setField(415, 70, $commentaire2);

        $buffer->setField(485, 10, $evenement->codeStadeCultureBBCH);
    }

    /**
     * Repartit le commentaire sur les deux zones de 70 caracteres (345-414 et 415-484).
     *
     * La coupure se fait sur le dernier espace avant la limite : le parser
     * reconcatene les deux zones avec un espace, ce qui restitue le
     * commentaire d'origine. Au-dela de 141 caracteres, le texte est tronque.
     *
     * @return array{?string, ?string}
     */
    private function splitCommentaire(?string $commentaire): array
    {
        if (null === $commentaire || mb_strlen($commentaire) <= 70) {
            return [$commentaire, null];
        }

        $lastSpace = mb_strrpos(mb_substr($commentaire, 0, 71), ' ');
        if (false === $lastSpace || 0 === $lastSpace) {
            return [mb_substr($commentaire, 0, 70), mb_substr($commentaire, 70, 70)];
        }

        return [mb_substr($commentaire, 0, $lastSpace), mb_substr($commentaire, $lastSpace + 1, 70)];
    }
}
