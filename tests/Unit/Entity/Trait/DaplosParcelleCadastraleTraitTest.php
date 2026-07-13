<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Entity\Trait;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCadastrale;
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosParcelleCadastraleTrait;

class DaplosParcelleCadastraleTraitTest extends TestCase
{
    public function testHydrateFromDto(): void
    {
        $dto = new ParcelleCadastrale(
            identifiantParcelle: '000178',
            annee: 2025,
            codeCommune: '077210',
            section: 'AB',
            numero: '000123',
            surface: 12.5,
            numeroParcelleCadastrale: '077210AB00012301',
            subdivisionFiscale: '01',
        );

        $entity = new class {
            use DaplosParcelleCadastraleTrait;
        };

        $entity->hydrateFromDaplosParcelleCadastrale($dto);

        $this->assertSame('000178', $entity->getDaplosIdentifiantParcelle());
        $this->assertSame(2025, $entity->getDaplosAnnee());
        $this->assertSame('077210', $entity->getDaplosCodeCommune());
        $this->assertSame('AB', $entity->getDaplosSection());
        $this->assertSame('000123', $entity->getDaplosNumero());
        $this->assertSame('12.5', $entity->getDaplosSurface());
        $this->assertSame('077210AB00012301', $entity->getDaplosNumeroParcelleCadastrale());
        $this->assertSame('01', $entity->getDaplosSubdivisionFiscale());

        // Champ déprécié : le parser ne le remplit plus
        $this->assertNull($entity->getDaplosPrefixe());
    }

    public function testHydrateWithEmptyDto(): void
    {
        $entity = new class {
            use DaplosParcelleCadastraleTrait;
        };

        $entity->hydrateFromDaplosParcelleCadastrale(new ParcelleCadastrale());

        $this->assertNull($entity->getDaplosIdentifiantParcelle());
        $this->assertNull($entity->getDaplosAnnee());
        $this->assertNull($entity->getDaplosCodeCommune());
        $this->assertNull($entity->getDaplosNumeroParcelleCadastrale());
        $this->assertNull($entity->getDaplosSubdivisionFiscale());
        $this->assertNull($entity->getDaplosSurface());
    }

    public function testSettersReturnSelf(): void
    {
        $entity = new class {
            use DaplosParcelleCadastraleTrait;
        };

        $result = $entity
            ->setDaplosIdentifiantParcelle('000178')
            ->setDaplosAnnee(2025)
            ->setDaplosNumeroParcelleCadastrale('077210AB00012301')
            ->setDaplosSubdivisionFiscale('01');

        $this->assertSame($entity, $result);
    }

    public function testSurfaceSetterAcceptsFloatAndString(): void
    {
        $entity = new class {
            use DaplosParcelleCadastraleTrait;
        };

        $entity->setDaplosSurface(12.5);
        $this->assertSame('12.5', $entity->getDaplosSurface());

        $entity->setDaplosSurface('8.25');
        $this->assertSame('8.25', $entity->getDaplosSurface());

        $entity->setDaplosSurface(null);
        $this->assertNull($entity->getDaplosSurface());
    }

    public function testAllSettersAndGetters(): void
    {
        $entity = new class {
            use DaplosParcelleCadastraleTrait;
        };

        $entity->setDaplosCodeCommune('089055');
        $entity->setDaplosPrefixe('000');
        $entity->setDaplosSection('ZC');
        $entity->setDaplosNumero('001234');

        $this->assertSame('089055', $entity->getDaplosCodeCommune());
        $this->assertSame('000', $entity->getDaplosPrefixe());
        $this->assertSame('ZC', $entity->getDaplosSection());
        $this->assertSame('001234', $entity->getDaplosNumero());
    }
}
