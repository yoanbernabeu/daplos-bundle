<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Entity\Trait;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Amendement;
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosAmendementTrait;

class DaplosAmendementTraitTest extends TestCase
{
    public function testHydrateFromDto(): void
    {
        $dto = new Amendement(
            identifiantParcelle: '000154',
            annee: 2025,
            codeAmendement: 'ZA5',
            quantite: 12.5,
            codeUnite: 'TNE',
            complementTypeAmendement: 'Compost de fumier de bovins',
            dateAmendement: new \DateTimeImmutable('2025-02-10'),
            origineRaisonSociale1: 'EARL des Prairies',
            origineRaisonSociale2: 'Atelier compostage',
            origineAdresseRue1: '3 chemin des Pres',
            origineAdresseRue2: 'Lieu-dit Le Bourg',
            origineVille: 'Toucy',
            origineCodePostal: '89130',
            originePays: 'FR',
        );

        $entity = new class {
            use DaplosAmendementTrait;
        };

        $entity->hydrateFromDaplosAmendement($dto);

        $this->assertSame('000154', $entity->getDaplosIdentifiantParcelle());
        $this->assertSame(2025, $entity->getDaplosAnnee());
        $this->assertSame('ZA5', $entity->getDaplosCodeAmendement());
        $this->assertSame('12.5', $entity->getDaplosQuantite());
        $this->assertSame('TNE', $entity->getDaplosCodeUnite());
        $this->assertSame('Compost de fumier de bovins', $entity->getDaplosComplementTypeAmendement());
        $this->assertSame('20250210', $entity->getDaplosDateAmendement()?->format('Ymd'));
        $this->assertSame('EARL des Prairies', $entity->getDaplosOrigineRaisonSociale1());
        $this->assertSame('Atelier compostage', $entity->getDaplosOrigineRaisonSociale2());
        $this->assertSame('3 chemin des Pres', $entity->getDaplosOrigineAdresseRue1());
        $this->assertSame('Lieu-dit Le Bourg', $entity->getDaplosOrigineAdresseRue2());
        $this->assertSame('Toucy', $entity->getDaplosOrigineVille());
        $this->assertSame('89130', $entity->getDaplosOrigineCodePostal());
        $this->assertSame('FR', $entity->getDaplosOriginePays());
    }

    public function testHydrateWithEmptyDto(): void
    {
        $entity = new class {
            use DaplosAmendementTrait;
        };

        $entity->hydrateFromDaplosAmendement(new Amendement());

        $this->assertNull($entity->getDaplosCodeAmendement());
        $this->assertNull($entity->getDaplosComplementTypeAmendement());
        $this->assertNull($entity->getDaplosDateAmendement());
        $this->assertNull($entity->getDaplosQuantite());
        $this->assertNull($entity->getDaplosOrigineRaisonSociale1());
        $this->assertNull($entity->getDaplosOriginePays());
    }
}
