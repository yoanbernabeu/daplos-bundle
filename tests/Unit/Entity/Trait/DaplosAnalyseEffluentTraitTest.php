<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Entity\Trait;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Intrant\AnalyseEffluent;
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosAnalyseEffluentTrait;

class DaplosAnalyseEffluentTraitTest extends TestCase
{
    public function testHydrateFromDto(): void
    {
        $dto = new AnalyseEffluent(
            identifiantParcelle: '000178',
            annee: 2025,
            refIntervention: 'A1B2C3D4E5F60718293A4B5C6D7E8F90',
            numeroBordereau: 'BORD-2025-000123',
            identificationLaboratoire: '123456789',
            laboratoireRaisonSociale1: 'Laboratoire Agro Ouest',
            laboratoireRaisonSociale2: 'Service analyses effluents',
            laboratoireAdresse1: '12 rue des Lilas',
            laboratoireAdresse2: 'BP 45',
            laboratoireVille: 'Rennes',
            laboratoireCodePostal: '35000',
            laboratoirePays: 'FR',
            dateAnalyse: new \DateTimeImmutable('2025-03-12'),
            datePrelevement: new \DateTimeImmutable('2025-03-05'),
        );

        $entity = new class {
            use DaplosAnalyseEffluentTrait;
        };

        $entity->hydrateFromDaplosAnalyseEffluent($dto);

        $this->assertSame('000178', $entity->getDaplosIdentifiantParcelle());
        $this->assertSame(2025, $entity->getDaplosAnnee());
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $entity->getDaplosRefIntervention());
        $this->assertSame('BORD-2025-000123', $entity->getDaplosNumeroBordereau());
        $this->assertSame('123456789', $entity->getDaplosIdentificationLaboratoire());
        $this->assertSame('Laboratoire Agro Ouest', $entity->getDaplosLaboratoireRaisonSociale1());
        $this->assertSame('Service analyses effluents', $entity->getDaplosLaboratoireRaisonSociale2());
        $this->assertSame('12 rue des Lilas', $entity->getDaplosLaboratoireAdresse1());
        $this->assertSame('BP 45', $entity->getDaplosLaboratoireAdresse2());
        $this->assertSame('Rennes', $entity->getDaplosLaboratoireVille());
        $this->assertSame('35000', $entity->getDaplosLaboratoireCodePostal());
        $this->assertSame('FR', $entity->getDaplosLaboratoirePays());
        $this->assertSame('20250312', $entity->getDaplosDateAnalyse()?->format('Ymd'));
        $this->assertSame('20250305', $entity->getDaplosDatePrelevement()?->format('Ymd'));

        // Champs hors guide : le parser ne les remplit plus
        $this->assertNull($entity->getDaplosTypeAnalyse());
        $this->assertNull($entity->getDaplosCodeElement());
        $this->assertNull($entity->getDaplosValeur());
        $this->assertNull($entity->getDaplosCodeUnite());
    }

    public function testHydrateWithEmptyDto(): void
    {
        $entity = new class {
            use DaplosAnalyseEffluentTrait;
        };

        $entity->hydrateFromDaplosAnalyseEffluent(new AnalyseEffluent());

        $this->assertNull($entity->getDaplosNumeroBordereau());
        $this->assertNull($entity->getDaplosIdentificationLaboratoire());
        $this->assertNull($entity->getDaplosLaboratoireRaisonSociale1());
        $this->assertNull($entity->getDaplosLaboratoireCodePostal());
        $this->assertNull($entity->getDaplosDateAnalyse());
        $this->assertNull($entity->getDaplosDatePrelevement());
    }
}
