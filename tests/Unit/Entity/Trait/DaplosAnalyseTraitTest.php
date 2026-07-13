<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Entity\Trait;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Analyse;
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosAnalyseTrait;

class DaplosAnalyseTraitTest extends TestCase
{
    public function testHydrateFromDto(): void
    {
        $dto = new Analyse(
            identifiantParcelle: '000266',
            annee: 2025,
            datePrelevement: new \DateTimeImmutable('2025-03-05'),
            dateAnalyse: new \DateTimeImmutable('2025-03-20'),
            numeroBordereau: 'BORD-2025-000123',
            identificationLaboratoire: '123456789',
            laboratoireRaisonSociale1: 'Laboratoire AgroSol',
            laboratoireRaisonSociale2: 'Departement analyses',
            laboratoireAdresseRue1: '5 avenue des Sciences',
            laboratoireAdresseRue2: 'ZI du Parc',
            laboratoireVille: 'Dijon',
            laboratoireCodePostal: '21000',
            laboratoirePays: 'FR',
        );

        $entity = new class {
            use DaplosAnalyseTrait;
        };

        $entity->hydrateFromDaplosAnalyse($dto);

        $this->assertSame('000266', $entity->getDaplosIdentifiantParcelle());
        $this->assertSame(2025, $entity->getDaplosAnnee());
        $this->assertSame('BORD-2025-000123', $entity->getDaplosNumeroBordereau());
        $this->assertSame('123456789', $entity->getDaplosIdentificationLaboratoire());
        $this->assertSame('Laboratoire AgroSol', $entity->getDaplosLaboratoireRaisonSociale1());
        $this->assertSame('Departement analyses', $entity->getDaplosLaboratoireRaisonSociale2());
        $this->assertSame('5 avenue des Sciences', $entity->getDaplosLaboratoireAdresseRue1());
        $this->assertSame('ZI du Parc', $entity->getDaplosLaboratoireAdresseRue2());
        $this->assertSame('Dijon', $entity->getDaplosLaboratoireVille());
        $this->assertSame('21000', $entity->getDaplosLaboratoireCodePostal());
        $this->assertSame('FR', $entity->getDaplosLaboratoirePays());
        $this->assertSame('20250320', $entity->getDaplosDateAnalyse()?->format('Ymd'));
        $this->assertSame('20250305', $entity->getDaplosDatePrelevement()?->format('Ymd'));

        // Champ hors guide v0.95 : plus jamais rempli par le parser
        $this->assertNull($entity->getDaplosTypeAnalyse());
    }

    public function testHydrateWithEmptyDto(): void
    {
        $entity = new class {
            use DaplosAnalyseTrait;
        };

        $entity->hydrateFromDaplosAnalyse(new Analyse());

        $this->assertNull($entity->getDaplosNumeroBordereau());
        $this->assertNull($entity->getDaplosIdentificationLaboratoire());
        $this->assertNull($entity->getDaplosLaboratoireRaisonSociale1());
        $this->assertNull($entity->getDaplosLaboratoirePays());
        $this->assertNull($entity->getDaplosDateAnalyse());
        $this->assertNull($entity->getDaplosDatePrelevement());
    }
}
