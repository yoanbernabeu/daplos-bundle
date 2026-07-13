<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Entity\Trait;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Intrant\Intrant;
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosIntrantTrait;

class DaplosIntrantTraitTest extends TestCase
{
    public function testHydrateFromDto(): void
    {
        $dto = new Intrant(
            identifiantParcelle: '000178',
            annee: 2025,
            refIntervention: 'A1B2C3D4E5F60718293A4B5C6D7E8F90',
            codeTypeIntrant: 'ZJB',
            designation: 'Fumier de bovins composte',
            quantite: 523.9578,
            codeUnite: 'KGM',
            codeAMM: '2100042',
            codeGNIS: '123ABCD',
            codeApportOrganique: 'ZL1',
            codeEAU: 'EAU',
            codeAdjuvant: 'ADJ',
            codeCalcoMagnesien: 'ZK5',
            codeQualifiantIntrant: 'ZQ1',
            codeEAN: '3401234567890',
            codeQualifiantEffluent2: 'ZQ2',
            codeQualifiantEffluent3: 'ZQ3',
            codeQualifiantEffluent4: 'ZQ4',
            codeQualifiantEffluent5: 'ZQ5',
            codeQualifiantSemence1: 'ZS1',
            codeQualifiantSemence2: 'ZS2',
            codeQualifiantSemence3: 'ZS3',
            quantiteEffectiveHa: 0.075,
            codeUniteQuantiteEffectiveHa: 'ZKK',
            doseHaVisee: 1.5,
            codeUniteDoseHaVisee: 'LTR',
            nombrePassagesPreconises: 0.5,
            origineEffluentRaisonSociale1: 'GAEC DE LA VALLEE',
            origineEffluentRaisonSociale2: 'Site de Montbard',
            origineEffluentAdresse1: '12 route des Champs',
            origineEffluentAdresse2: 'Lieu-dit Les Pres',
            origineEffluentVille: 'MONTBARD',
            origineEffluentCodePostal: '21500',
            origineEffluentPays: 'FR',
            densiteVolumique: 1.3,
        );

        $entity = new class {
            use DaplosIntrantTrait;
        };

        $entity->hydrateFromDaplosIntrant($dto);

        $this->assertSame('000178', $entity->getDaplosIdentifiantParcelle());
        $this->assertSame('ZJB', $entity->getDaplosCodeTypeIntrant());
        $this->assertSame('Fumier de bovins composte', $entity->getDaplosDesignation());
        $this->assertSame('523.9578', $entity->getDaplosQuantite());
        $this->assertSame('KGM', $entity->getDaplosCodeUnite());
        $this->assertSame('2100042', $entity->getDaplosCodeAMM());
        $this->assertSame('ZK5', $entity->getDaplosCodeCalcoMagnesien());
        $this->assertSame('ZQ1', $entity->getDaplosCodeQualifiantIntrant());
        $this->assertSame('3401234567890', $entity->getDaplosCodeEAN());
        $this->assertSame('ZQ2', $entity->getDaplosCodeQualifiantEffluent2());
        $this->assertSame('ZQ3', $entity->getDaplosCodeQualifiantEffluent3());
        $this->assertSame('ZQ4', $entity->getDaplosCodeQualifiantEffluent4());
        $this->assertSame('ZQ5', $entity->getDaplosCodeQualifiantEffluent5());
        $this->assertSame('ZS1', $entity->getDaplosCodeQualifiantSemence1());
        $this->assertSame('ZS2', $entity->getDaplosCodeQualifiantSemence2());
        $this->assertSame('ZS3', $entity->getDaplosCodeQualifiantSemence3());
        $this->assertSame('0.075', $entity->getDaplosQuantiteEffectiveHa());
        $this->assertSame('ZKK', $entity->getDaplosCodeUniteQuantiteEffectiveHa());
        $this->assertSame('1.5', $entity->getDaplosDoseHaVisee());
        $this->assertSame('LTR', $entity->getDaplosCodeUniteDoseHaVisee());
        $this->assertSame('0.5', $entity->getDaplosNombrePassagesPreconises());
        $this->assertSame('GAEC DE LA VALLEE', $entity->getDaplosOrigineEffluentRaisonSociale1());
        $this->assertSame('Site de Montbard', $entity->getDaplosOrigineEffluentRaisonSociale2());
        $this->assertSame('12 route des Champs', $entity->getDaplosOrigineEffluentAdresse1());
        $this->assertSame('Lieu-dit Les Pres', $entity->getDaplosOrigineEffluentAdresse2());
        $this->assertSame('MONTBARD', $entity->getDaplosOrigineEffluentVille());
        $this->assertSame('21500', $entity->getDaplosOrigineEffluentCodePostal());
        $this->assertSame('FR', $entity->getDaplosOrigineEffluentPays());
        $this->assertSame('1.3', $entity->getDaplosDensiteVolumique());
    }

    public function testHydrateWithEmptyDto(): void
    {
        $entity = new class {
            use DaplosIntrantTrait;
        };

        $entity->hydrateFromDaplosIntrant(new Intrant());

        $this->assertNull($entity->getDaplosCodeEAN());
        $this->assertNull($entity->getDaplosCodeCalcoMagnesien());
        $this->assertNull($entity->getDaplosQuantiteEffectiveHa());
        $this->assertNull($entity->getDaplosDensiteVolumique());
    }
}
