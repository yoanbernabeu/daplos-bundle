<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Entity\Trait;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Intervention\CibleEvenement;
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosCibleEvenementTrait;

class DaplosCibleEvenementTraitTest extends TestCase
{
    public function testHydrateFromDto(): void
    {
        $dto = new CibleEvenement(
            identifiantParcelle: '000178',
            annee: 2025,
            refIntervention: 'A1B2C3D4E5F60718293A4B5C6D7E8F90',
            codeOrganismeCible: 'ZB1',
            codeCibleV095: 'ORGANISME012',
        );

        $entity = new class {
            use DaplosCibleEvenementTrait;
        };

        $entity->hydrateFromDaplosCibleEvenement($dto);

        $this->assertSame('000178', $entity->getDaplosIdentifiantParcelle());
        $this->assertSame(2025, $entity->getDaplosAnnee());
        $this->assertSame('A1B2C3D4E5F60718293A4B5C6D7E8F90', $entity->getDaplosRefIntervention());
        $this->assertSame('ZB1', $entity->getDaplosCodeOrganismeCible());
        $this->assertSame('ORGANISME012', $entity->getDaplosCodeCibleV095());
        $this->assertNull($entity->getDaplosCodeSousTypeOrganisme());
    }

    public function testHydrateWithEmptyDto(): void
    {
        $entity = new class {
            use DaplosCibleEvenementTrait;
        };

        $entity->hydrateFromDaplosCibleEvenement(new CibleEvenement());

        $this->assertNull($entity->getDaplosIdentifiantParcelle());
        $this->assertNull($entity->getDaplosCodeOrganismeCible());
        $this->assertNull($entity->getDaplosCodeCibleV095());
    }

    public function testFluentSetters(): void
    {
        $entity = new class {
            use DaplosCibleEvenementTrait;
        };

        $result = $entity->setDaplosCodeCibleV095('ZB100518');

        $this->assertSame($entity, $result);
        $this->assertSame('ZB100518', $entity->getDaplosCodeCibleV095());
    }
}
