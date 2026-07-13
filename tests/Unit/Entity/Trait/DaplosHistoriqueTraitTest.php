<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Entity\Trait;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Historique;
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosHistoriqueTrait;

class DaplosHistoriqueTraitTest extends TestCase
{
    public function testHydrateFromDto(): void
    {
        $dto = new Historique(
            identifiantParcelle: '000154',
            annee: 2025,
            indexPrecedent: -1,
            codeEspeceBotanique: 'ZOJ',
            cleParcellePrecedent: 'P154',
            varieteSemee1: 'BLE0001',
            varieteSemee2: 'BLE0002',
            varieteSemee3: 'BLE0003',
            varieteSemee4: 'BLE0004',
            varieteSemee5: 'BLE0005',
            codeQualifiantEspece: 'ZA1',
            codePeriodeSemis: 'ZB2',
            codeDestination: 'ZC3',
            codeGestionResidus: 'ZD4',
            quantiteEpandue: 3.5,
        );

        $entity = new class {
            use DaplosHistoriqueTrait;
        };

        $entity->hydrateFromDaplosHistorique($dto);

        $this->assertSame('000154', $entity->getDaplosIdentifiantParcelle());
        $this->assertSame(2025, $entity->getDaplosAnnee());
        $this->assertSame(-1, $entity->getDaplosIndexPrecedent());
        $this->assertSame('P154', $entity->getDaplosCleParcellePrecedent());
        $this->assertSame('ZOJ', $entity->getDaplosCodeEspeceBotanique());
        $this->assertSame('BLE0001', $entity->getDaplosVarieteSemee1());
        $this->assertSame('BLE0002', $entity->getDaplosVarieteSemee2());
        $this->assertSame('BLE0003', $entity->getDaplosVarieteSemee3());
        $this->assertSame('BLE0004', $entity->getDaplosVarieteSemee4());
        $this->assertSame('BLE0005', $entity->getDaplosVarieteSemee5());
        $this->assertSame('ZA1', $entity->getDaplosCodeQualifiantEspece());
        $this->assertSame('ZB2', $entity->getDaplosCodePeriodeSemis());
        $this->assertSame('ZC3', $entity->getDaplosCodeDestination());
        $this->assertSame('ZD4', $entity->getDaplosCodeGestionResidus());
        $this->assertSame('3.5', $entity->getDaplosQuantiteEpandue());

        // Champs hors guide v0.95 : plus jamais remplis par le parser
        $this->assertNull($entity->getDaplosAnneePrecedent());
        $this->assertNull($entity->getDaplosCodeTraitementResidus());
        $this->assertNull($entity->getDaplosCodeModeProduction());
    }

    public function testHydrateWithEmptyDto(): void
    {
        $entity = new class {
            use DaplosHistoriqueTrait;
        };

        $entity->hydrateFromDaplosHistorique(new Historique());

        $this->assertNull($entity->getDaplosCleParcellePrecedent());
        $this->assertNull($entity->getDaplosVarieteSemee1());
        $this->assertNull($entity->getDaplosCodeQualifiantEspece());
        $this->assertNull($entity->getDaplosCodePeriodeSemis());
        $this->assertNull($entity->getDaplosCodeDestination());
        $this->assertNull($entity->getDaplosCodeGestionResidus());
        $this->assertNull($entity->getDaplosQuantiteEpandue());
    }

    public function testQuantiteEpandueSetterAcceptsFloatAndString(): void
    {
        $entity = new class {
            use DaplosHistoriqueTrait;
        };

        $entity->setDaplosQuantiteEpandue(3.5);
        $this->assertSame('3.5', $entity->getDaplosQuantiteEpandue());

        $entity->setDaplosQuantiteEpandue('4.2500');
        $this->assertSame('4.2500', $entity->getDaplosQuantiteEpandue());

        $entity->setDaplosQuantiteEpandue(null);
        $this->assertNull($entity->getDaplosQuantiteEpandue());
    }
}
