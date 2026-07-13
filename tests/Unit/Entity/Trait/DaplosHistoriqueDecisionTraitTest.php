<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Entity\Trait;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Intervention\HistoriqueDecision;
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosHistoriqueDecisionTrait;

class DaplosHistoriqueDecisionTraitTest extends TestCase
{
    public function testHydrateFromDto(): void
    {
        $dto = new HistoriqueDecision(
            identifiantParcelle: '000178',
            annee: 2025,
            refIntervention: 'A1B2C3D4E5F60718293A4B5C6D7E8F90',
            codeTypeLien: 'ZL1',
            refEvenementConsidere: 'B2C3D4E5F60718293A4B5C6D7E8F90A1',
            numeroParcelleAnterieur: '0012',
            anneeRecolte: 2024,
            identificationExploitation: '12345678900012',
            codeTypeIdentification: '107',
            exploitationRaisonSociale1: 'EARL des Champs',
            exploitationRaisonSociale2: 'Site principal',
            exploitationAdresse1: '1 route de la Plaine',
            exploitationAdresse2: 'Lieu-dit Les Noues',
            exploitationVille: 'Chartres',
            exploitationCodePostal: '28000',
            exploitationPays: 'FR',
            infoParcelleNonEdi1: 'Parcelle historique hors EDI premiere info',
            infoParcelleNonEdi2: 'Seconde information libre',
        );

        $entity = new class {
            use DaplosHistoriqueDecisionTrait;
        };

        $entity->hydrateFromDaplosHistoriqueDecision($dto);

        $this->assertSame('000178', $entity->getDaplosIdentifiantParcelle());
        $this->assertSame(2025, $entity->getDaplosAnnee());
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $entity->getDaplosRefIntervention());
        $this->assertSame('ZL1', $entity->getDaplosCodeTypeLien());
        $this->assertSame('B2C3D4E5F60718293A4B5C6D7E8F90A1', $entity->getDaplosRefEvenementConsidere());
        $this->assertSame('0012', $entity->getDaplosNumeroParcelleAnterieur());
        $this->assertSame(2024, $entity->getDaplosAnneeRecolte());
        $this->assertSame('12345678900012', $entity->getDaplosIdentificationExploitation());
        $this->assertSame('107', $entity->getDaplosCodeTypeIdentification());
        $this->assertSame('EARL des Champs', $entity->getDaplosExploitationRaisonSociale1());
        $this->assertSame('Site principal', $entity->getDaplosExploitationRaisonSociale2());
        $this->assertSame('1 route de la Plaine', $entity->getDaplosExploitationAdresse1());
        $this->assertSame('Lieu-dit Les Noues', $entity->getDaplosExploitationAdresse2());
        $this->assertSame('Chartres', $entity->getDaplosExploitationVille());
        $this->assertSame('28000', $entity->getDaplosExploitationCodePostal());
        $this->assertSame('FR', $entity->getDaplosExploitationPays());
        $this->assertSame('Parcelle historique hors EDI premiere info', $entity->getDaplosInfoParcelleNonEdi1());
        $this->assertSame('Seconde information libre', $entity->getDaplosInfoParcelleNonEdi2());

        // Champs hors guide : le parser ne les remplit plus
        $this->assertNull($entity->getDaplosDecision());
        $this->assertNull($entity->getDaplosDateDecision());
    }

    public function testHydrateWithEmptyDto(): void
    {
        $entity = new class {
            use DaplosHistoriqueDecisionTrait;
        };

        $entity->hydrateFromDaplosHistoriqueDecision(new HistoriqueDecision());

        $this->assertNull($entity->getDaplosCodeTypeLien());
        $this->assertNull($entity->getDaplosRefEvenementConsidere());
        $this->assertNull($entity->getDaplosNumeroParcelleAnterieur());
        $this->assertNull($entity->getDaplosAnneeRecolte());
        $this->assertNull($entity->getDaplosIdentificationExploitation());
        $this->assertNull($entity->getDaplosCodeTypeIdentification());
        $this->assertNull($entity->getDaplosExploitationRaisonSociale1());
        $this->assertNull($entity->getDaplosExploitationPays());
        $this->assertNull($entity->getDaplosInfoParcelleNonEdi1());
        $this->assertNull($entity->getDaplosInfoParcelleNonEdi2());
        $this->assertNull($entity->getDaplosDecision());
        $this->assertNull($entity->getDaplosDateDecision());
    }
}
