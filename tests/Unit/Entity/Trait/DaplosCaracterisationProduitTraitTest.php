<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Entity\Trait;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Recolte\CaracterisationProduit;
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosCaracterisationProduitTrait;

class DaplosCaracterisationProduitTraitTest extends TestCase
{
    public function testHydrateFromDto(): void
    {
        $dto = new CaracterisationProduit(
            identifiantParcelle: '000178',
            annee: 2025,
            refIntervention: 'A1B2C3D4E5F60718293A4B5C6D7E8F90',
            codeCaracteristique: 'ZJ4',
            valeur: '00014.500',
            codeUnite: 'PCT',
        );

        $entity = new class {
            use DaplosCaracterisationProduitTrait;
        };

        $entity->hydrateFromDaplosCaracterisationProduit($dto);

        $this->assertSame('000178', $entity->getDaplosIdentifiantParcelle());
        $this->assertSame(2025, $entity->getDaplosAnnee());
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $entity->getDaplosRefIntervention());
        $this->assertSame('ZJ4', $entity->getDaplosCodeCaracteristique());
        $this->assertSame('00014.500', $entity->getDaplosValeur());
        $this->assertSame(14.5, $entity->getDaplosValeurNumerique());
        $this->assertSame('PCT', $entity->getDaplosCodeUnite());
    }

    public function testValeurNumeriqueWithInvalidValue(): void
    {
        $entity = new class {
            use DaplosCaracterisationProduitTrait;
        };

        $this->assertNull($entity->getDaplosValeurNumerique());

        $entity->setDaplosValeur('abc');
        $this->assertNull($entity->getDaplosValeurNumerique());

        $entity->setDaplosValeur('00012,75');
        $this->assertSame(12.75, $entity->getDaplosValeurNumerique());
    }

    public function testHydrateWithEmptyDto(): void
    {
        $entity = new class {
            use DaplosCaracterisationProduitTrait;
        };

        $entity->hydrateFromDaplosCaracterisationProduit(new CaracterisationProduit());

        $this->assertNull($entity->getDaplosCodeCaracteristique());
        $this->assertNull($entity->getDaplosValeur());
        $this->assertNull($entity->getDaplosValeurNumerique());
        $this->assertNull($entity->getDaplosCodeUnite());
    }
}
