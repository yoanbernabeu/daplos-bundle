<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Entity\Trait;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosParcelleCulturaleTrait;

class DaplosParcelleCulturaleTraitTest extends TestCase
{
    public function testHydrateFromDto(): void
    {
        $dto = new ParcelleCulturale(
            identifiant: '00001',
            annee: 2024,
            nom: 'Champ du moulin',
            codeEspeceBotanique: 'ZDH',
            codeVariete: 'APACHE',
            surface: 25.54,
            codeUniteSurface: 'HA',
            numeroIlot: 12,
            codeCommune: '01234',
        );

        $entity = new class {
            use DaplosParcelleCulturaleTrait;
        };

        $entity->hydrateFromDaplosParcelle($dto);

        $this->assertSame('00001', $entity->getDaplosIdentifiant());
        $this->assertSame(2024, $entity->getDaplosAnnee());
        $this->assertSame('Champ du moulin', $entity->getDaplosNom());
        $this->assertSame('ZDH', $entity->getDaplosCodeEspeceBotanique());
        $this->assertSame('APACHE', $entity->getDaplosCodeVariete());
        $this->assertSame(25.54, $entity->getDaplosSurface());
        $this->assertSame('HA', $entity->getDaplosCodeUniteSurface());
        $this->assertSame(12, $entity->getDaplosNumeroIlot());
        $this->assertSame('01234', $entity->getDaplosCodeCommune());
    }

    public function testSettersReturnSelf(): void
    {
        $entity = new class {
            use DaplosParcelleCulturaleTrait;
        };

        $result = $entity
            ->setDaplosIdentifiant('00001')
            ->setDaplosAnnee(2024)
            ->setDaplosNom('Test');

        $this->assertSame($entity, $result);
    }

    public function testNullValues(): void
    {
        $entity = new class {
            use DaplosParcelleCulturaleTrait;
        };

        $entity->setDaplosIdentifiant(null);
        $entity->setDaplosAnnee(null);

        $this->assertNull($entity->getDaplosIdentifiant());
        $this->assertNull($entity->getDaplosAnnee());
    }

    public function testAllSettersAndGetters(): void
    {
        $entity = new class {
            use DaplosParcelleCulturaleTrait;
        };

        $date = new \DateTimeImmutable('2024-01-15');

        $entity->setDaplosDateCreation($date);
        $entity->setDaplosDateDebutCampagne($date);
        $entity->setDaplosDateFinCampagne($date);
        $entity->setDaplosCodeQualifiantCulture('ZCT');
        $entity->setDaplosCodeDestinationCulture('ZL0');
        $entity->setDaplosCodePeriodeSemis('ZLS');
        $entity->setDaplosCodeTypeSol('ZF8');
        $entity->setDaplosCodeTypeSousSol('ZF4');
        $entity->setDaplosCodeModeProduction('ZBP');
        $entity->setDaplosNumeroRPG('RPG123');

        $this->assertEquals($date, $entity->getDaplosDateCreation());
        $this->assertEquals($date, $entity->getDaplosDateDebutCampagne());
        $this->assertEquals($date, $entity->getDaplosDateFinCampagne());
        $this->assertSame('ZCT', $entity->getDaplosCodeQualifiantCulture());
        $this->assertSame('ZL0', $entity->getDaplosCodeDestinationCulture());
        $this->assertSame('ZLS', $entity->getDaplosCodePeriodeSemis());
        $this->assertSame('ZF8', $entity->getDaplosCodeTypeSol());
        $this->assertSame('ZF4', $entity->getDaplosCodeTypeSousSol());
        $this->assertSame('ZBP', $entity->getDaplosCodeModeProduction());
        $this->assertSame('RPG123', $entity->getDaplosNumeroRPG());
    }
}
