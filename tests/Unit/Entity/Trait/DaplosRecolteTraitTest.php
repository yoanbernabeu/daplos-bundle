<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Entity\Trait;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Recolte\Recolte;
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosRecolteTrait;

class DaplosRecolteTraitTest extends TestCase
{
    public function testHydrateFromDto(): void
    {
        $dto = new Recolte(
            identifiantParcelle: '000178',
            annee: 2025,
            refIntervention: 'A1B2C3D4E5F60718293A4B5C6D7E8F90',
            codeTypeProduitRecolte: 'ZJH',
            codeEspeceBotanique: 'ZAR',
            libelleProduit: 'Ble tendre',
            quantite: 218.178,
            codeUnite: 'TNE',
            destinationProduit: 'ZG1',
            rendementCalcule: 7.5,
            codeUniteRendementCalcule: 'TNE',
            rendementEstime: 8.1,
            codeUniteRendementEstime: 'TNE',
        );

        $entity = new class {
            use DaplosRecolteTrait;
        };

        $entity->hydrateFromDaplosRecolte($dto);

        $this->assertSame('000178', $entity->getDaplosIdentifiantParcelle());
        $this->assertSame(2025, $entity->getDaplosAnnee());
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $entity->getDaplosRefIntervention());
        $this->assertSame('ZJH', $entity->getDaplosCodeTypeProduitRecolte());
        $this->assertSame('ZAR', $entity->getDaplosCodeEspeceBotanique());
        $this->assertSame('Ble tendre', $entity->getDaplosLibelleProduit());
        $this->assertSame('218.178', $entity->getDaplosQuantite());
        $this->assertSame('TNE', $entity->getDaplosCodeUnite());
        $this->assertSame('ZG1', $entity->getDaplosDestinationProduit());
        $this->assertSame('7.5', $entity->getDaplosRendementCalcule());
        $this->assertSame('TNE', $entity->getDaplosCodeUniteRendementCalcule());
        $this->assertSame('8.1', $entity->getDaplosRendementEstime());
        $this->assertSame('TNE', $entity->getDaplosCodeUniteRendementEstime());
    }

    public function testSettersAcceptFloatAndString(): void
    {
        $entity = new class {
            use DaplosRecolteTrait;
        };

        $entity->setDaplosRendementCalcule(7.5);
        $this->assertSame('7.5', $entity->getDaplosRendementCalcule());

        $entity->setDaplosRendementEstime('8.1000');
        $this->assertSame('8.1000', $entity->getDaplosRendementEstime());

        $entity->setDaplosRendementCalcule(null);
        $this->assertNull($entity->getDaplosRendementCalcule());
    }

    public function testHydrateWithEmptyDto(): void
    {
        $entity = new class {
            use DaplosRecolteTrait;
        };

        $entity->hydrateFromDaplosRecolte(new Recolte());

        $this->assertNull($entity->getDaplosDestinationProduit());
        $this->assertNull($entity->getDaplosRendementCalcule());
        $this->assertNull($entity->getDaplosCodeUniteRendementCalcule());
        $this->assertNull($entity->getDaplosRendementEstime());
        $this->assertNull($entity->getDaplosCodeUniteRendementEstime());
    }
}
