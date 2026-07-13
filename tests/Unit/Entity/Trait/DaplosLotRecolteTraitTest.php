<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Entity\Trait;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Recolte\LotRecolte;
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosLotRecolteTrait;

class DaplosLotRecolteTraitTest extends TestCase
{
    public function testHydrateFromDto(): void
    {
        $dto = new LotRecolte(
            identifiantParcelle: '000178',
            annee: 2025,
            refIntervention: 'A1B2C3D4E5F60718293A4B5C6D7E8F90',
            numeroLot: 'LOT-OS-2025-001',
            quantite: 123.456,
            numeroLotAgriculteur: 'LOT-FERME-42',
        );

        $entity = new class {
            use DaplosLotRecolteTrait;
        };

        $entity->hydrateFromDaplosLotRecolte($dto);

        $this->assertSame('000178', $entity->getDaplosIdentifiantParcelle());
        $this->assertSame(2025, $entity->getDaplosAnnee());
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $entity->getDaplosRefIntervention());
        $this->assertSame('LOT-OS-2025-001', $entity->getDaplosNumeroLot());
        $this->assertSame('LOT-FERME-42', $entity->getDaplosNumeroLotAgriculteur());
        $this->assertSame('123.456', $entity->getDaplosQuantite());

        // Champ hors guide : le parser ne le remplit plus
        $this->assertNull($entity->getDaplosCodeUnite());
    }

    public function testHydrateWithEmptyDto(): void
    {
        $entity = new class {
            use DaplosLotRecolteTrait;
        };

        $entity->hydrateFromDaplosLotRecolte(new LotRecolte());

        $this->assertNull($entity->getDaplosNumeroLot());
        $this->assertNull($entity->getDaplosNumeroLotAgriculteur());
        $this->assertNull($entity->getDaplosQuantite());
        $this->assertNull($entity->getDaplosCodeUnite());
    }
}
