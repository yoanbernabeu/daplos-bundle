<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Entity\Trait;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Intrant\LotFabricant;
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosLotFabricantTrait;

class DaplosLotFabricantTraitTest extends TestCase
{
    public function testHydrateFromDto(): void
    {
        $dto = new LotFabricant(
            identifiantParcelle: '000178',
            annee: 2025,
            refIntervention: 'A1B2C3D4E5F60718293A4B5C6D7E8F90',
            numeroLot: 'LOT-2025-0042',
            quantite: 3970.7704,
            codeUnite: 'LTR',
            codeProduit: '580G491',
            pmg: 45.5,
            codeUnitePmg: 'KGM',
        );

        $entity = new class {
            use DaplosLotFabricantTrait;
        };

        $entity->hydrateFromDaplosLotFabricant($dto);

        $this->assertSame('000178', $entity->getDaplosIdentifiantParcelle());
        $this->assertSame(2025, $entity->getDaplosAnnee());
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $entity->getDaplosRefIntervention());
        $this->assertSame('580G491', $entity->getDaplosCodeProduit());
        $this->assertSame('LOT-2025-0042', $entity->getDaplosNumeroLot());
        $this->assertSame('3970.7704', $entity->getDaplosQuantite());
        $this->assertSame('LTR', $entity->getDaplosCodeUnite());
        $this->assertSame('45.5', $entity->getDaplosPmg());
        $this->assertSame('KGM', $entity->getDaplosCodeUnitePmg());
        $this->assertNull($entity->getDaplosIndexLot());
    }

    public function testHydrateWithEmptyDto(): void
    {
        $entity = new class {
            use DaplosLotFabricantTrait;
        };

        $entity->hydrateFromDaplosLotFabricant(new LotFabricant());

        $this->assertNull($entity->getDaplosCodeProduit());
        $this->assertNull($entity->getDaplosNumeroLot());
        $this->assertNull($entity->getDaplosQuantite());
        $this->assertNull($entity->getDaplosPmg());
        $this->assertNull($entity->getDaplosCodeUnitePmg());
    }

    public function testPmgSetterAcceptsFloatAndString(): void
    {
        $entity = new class {
            use DaplosLotFabricantTrait;
        };

        $entity->setDaplosPmg(45.5);
        $this->assertSame('45.5', $entity->getDaplosPmg());

        $entity->setDaplosPmg('47.25');
        $this->assertSame('47.25', $entity->getDaplosPmg());

        $entity->setDaplosPmg(null);
        $this->assertNull($entity->getDaplosPmg());
    }
}
