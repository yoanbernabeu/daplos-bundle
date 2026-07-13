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
            codeEspeceBotanique: 'ZDH',
            codeVariete: '512D574',
            codeQualifiantCulture: 'ZES',
            codeDestinationCulture: 'ZLR',
            codePeriodeSemis: 'ZFB',
            codeTypeSol: 'ZFJ',
            codeTypeSousSol: 'ZF8',
            surface: 25.54,
            codeUniteSurface: 'HA',
            nom: 'Champ du moulin',
            codeCommune: '89173',
            dateDebutParcelle: new \DateTimeImmutable('2024-09-01'),
            dateCreationFiche: new \DateTimeImmutable('2024-08-15'),
            dateDerniereSaisie: new \DateTimeImmutable('2025-03-10'),
            dateFinParcelle: new \DateTimeImmutable('2025-07-15'),
            codeVariete2: '512D296',
            codeVariete3: '515C875',
            codeVariete4: '512E081',
            codeVariete5: '580G491',
            rendementObjectif: 7.5,
            codeUniteRendement: 'ZHK',
            numeroIlotPac: 'ILOT-2025A',
            numeroParcellePerenne: 'PER001',
            profondeurSol: 30,
            pierrosite: 15,
            autreTypeSol: 'Limon argileux',
            codeAcidite: 'ZF1',
            codeProfondeurSousSol: 'ZF4',
            codeCultureIntermediaire: 'ZDH',
            solHydromorphe: true,
            parcelleDrainee: false,
            parcelleRedecoupee: true,
            cleParcelleInitiale: 'P001',
            codeGestionResidus: 'ZLJ',
            quantiteEpandue: 3.5,
            codeTypeSolV095: 'BO0513001',
            doseAzote: 150.0,
        );

        $entity = new class {
            use DaplosParcelleCulturaleTrait;
        };

        $entity->hydrateFromDaplosParcelle($dto);

        $this->assertSame('00001', $entity->getDaplosIdentifiant());
        $this->assertSame(2024, $entity->getDaplosAnnee());
        $this->assertSame('Champ du moulin', $entity->getDaplosNom());
        $this->assertSame('ZDH', $entity->getDaplosCodeEspeceBotanique());
        $this->assertSame('512D574', $entity->getDaplosCodeVariete());
        $this->assertSame('ZES', $entity->getDaplosCodeQualifiantCulture());
        $this->assertSame('ZLR', $entity->getDaplosCodeDestinationCulture());
        $this->assertSame('ZFB', $entity->getDaplosCodePeriodeSemis());
        $this->assertSame('ZFJ', $entity->getDaplosCodeTypeSol());
        $this->assertSame('ZF8', $entity->getDaplosCodeTypeSousSol());
        $this->assertSame('25.54', $entity->getDaplosSurface());
        $this->assertSame('HA', $entity->getDaplosCodeUniteSurface());
        $this->assertSame('89173', $entity->getDaplosCodeCommune());

        // Nouveaux champs du guide v0.95
        $this->assertSame('20240901', $entity->getDaplosDateDebutParcelle()?->format('Ymd'));
        $this->assertSame('20240815', $entity->getDaplosDateCreationFiche()?->format('Ymd'));
        $this->assertSame('20250310', $entity->getDaplosDateDerniereSaisie()?->format('Ymd'));
        $this->assertSame('20250715', $entity->getDaplosDateFinParcelle()?->format('Ymd'));
        $this->assertSame('512D296', $entity->getDaplosCodeVariete2());
        $this->assertSame('515C875', $entity->getDaplosCodeVariete3());
        $this->assertSame('512E081', $entity->getDaplosCodeVariete4());
        $this->assertSame('580G491', $entity->getDaplosCodeVariete5());
        $this->assertSame('7.5', $entity->getDaplosRendementObjectif());
        $this->assertSame('ZHK', $entity->getDaplosCodeUniteRendement());
        $this->assertSame('ILOT-2025A', $entity->getDaplosNumeroIlotPac());
        $this->assertSame('PER001', $entity->getDaplosNumeroParcellePerenne());
        $this->assertSame(30, $entity->getDaplosProfondeurSol());
        $this->assertSame(15, $entity->getDaplosPierrosite());
        $this->assertSame('Limon argileux', $entity->getDaplosAutreTypeSol());
        $this->assertSame('ZF1', $entity->getDaplosCodeAcidite());
        $this->assertSame('ZF4', $entity->getDaplosCodeProfondeurSousSol());
        $this->assertSame('ZDH', $entity->getDaplosCodeCultureIntermediaire());
        $this->assertTrue($entity->getDaplosSolHydromorphe());
        $this->assertFalse($entity->getDaplosParcelleDrainee());
        $this->assertTrue($entity->getDaplosParcelleRedecoupee());
        $this->assertSame('P001', $entity->getDaplosCleParcelleInitiale());
        $this->assertSame('ZLJ', $entity->getDaplosCodeGestionResidus());
        $this->assertSame('3.5', $entity->getDaplosQuantiteEpandue());
        $this->assertSame('BO0513001', $entity->getDaplosCodeTypeSolV095());
        $this->assertSame('150', $entity->getDaplosDoseAzote());

        // Champs dépréciés : le parser ne les remplit plus
        $this->assertNull($entity->getDaplosDateCreation());
        $this->assertNull($entity->getDaplosDateDebutCampagne());
        $this->assertNull($entity->getDaplosDateFinCampagne());
        $this->assertNull($entity->getDaplosNumeroIlot());
        $this->assertNull($entity->getDaplosNumeroRPG());
    }

    public function testHydrateWithEmptyDto(): void
    {
        $entity = new class {
            use DaplosParcelleCulturaleTrait;
        };

        $entity->hydrateFromDaplosParcelle(new ParcelleCulturale());

        $this->assertNull($entity->getDaplosIdentifiant());
        $this->assertNull($entity->getDaplosDateDebutParcelle());
        $this->assertNull($entity->getDaplosCodeVariete2());
        $this->assertNull($entity->getDaplosRendementObjectif());
        $this->assertNull($entity->getDaplosNumeroIlotPac());
        $this->assertNull($entity->getDaplosSolHydromorphe());
        $this->assertNull($entity->getDaplosCodeTypeSolV095());
        $this->assertNull($entity->getDaplosDoseAzote());
    }

    public function testSettersReturnSelf(): void
    {
        $entity = new class {
            use DaplosParcelleCulturaleTrait;
        };

        $result = $entity
            ->setDaplosIdentifiant('00001')
            ->setDaplosAnnee(2024)
            ->setDaplosNom('Test')
            ->setDaplosNumeroIlotPac('12')
            ->setDaplosSolHydromorphe(true);

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

    public function testDecimalSettersAcceptFloatAndString(): void
    {
        $entity = new class {
            use DaplosParcelleCulturaleTrait;
        };

        $entity->setDaplosRendementObjectif(7.5);
        $this->assertSame('7.5', $entity->getDaplosRendementObjectif());

        $entity->setDaplosRendementObjectif('8.25');
        $this->assertSame('8.25', $entity->getDaplosRendementObjectif());

        $entity->setDaplosQuantiteEpandue(3.5);
        $this->assertSame('3.5', $entity->getDaplosQuantiteEpandue());

        $entity->setDaplosDoseAzote(null);
        $this->assertNull($entity->getDaplosDoseAzote());
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
        $entity->setDaplosDateDebutParcelle($date);
        $entity->setDaplosDateCreationFiche($date);
        $entity->setDaplosDateDerniereSaisie($date);
        $entity->setDaplosDateFinParcelle($date);
        $entity->setDaplosCodeQualifiantCulture('ZCT');
        $entity->setDaplosCodeDestinationCulture('ZL0');
        $entity->setDaplosCodePeriodeSemis('ZLS');
        $entity->setDaplosCodeTypeSol('ZF8');
        $entity->setDaplosCodeTypeSousSol('ZF4');
        $entity->setDaplosCodeModeProduction('ZBP');
        $entity->setDaplosNumeroIlot(12);
        $entity->setDaplosNumeroRPG('RPG123');
        $entity->setDaplosCodeVariete2('V2');
        $entity->setDaplosCodeVariete3('V3');
        $entity->setDaplosCodeVariete4('V4');
        $entity->setDaplosCodeVariete5('V5');
        $entity->setDaplosCodeUniteRendement('ZHK');
        $entity->setDaplosNumeroParcellePerenne('PER001');
        $entity->setDaplosProfondeurSol(30);
        $entity->setDaplosPierrosite(15);
        $entity->setDaplosAutreTypeSol('Limon');
        $entity->setDaplosCodeAcidite('ZF1');
        $entity->setDaplosCodeProfondeurSousSol('ZF4');
        $entity->setDaplosCodeCultureIntermediaire('ZDH');
        $entity->setDaplosParcelleDrainee(true);
        $entity->setDaplosParcelleRedecoupee(false);
        $entity->setDaplosCleParcelleInitiale('P001');
        $entity->setDaplosCodeGestionResidus('ZLJ');
        $entity->setDaplosCodeTypeSolV095('BO0513001');

        $this->assertEquals($date, $entity->getDaplosDateCreation());
        $this->assertEquals($date, $entity->getDaplosDateDebutCampagne());
        $this->assertEquals($date, $entity->getDaplosDateFinCampagne());
        $this->assertEquals($date, $entity->getDaplosDateDebutParcelle());
        $this->assertEquals($date, $entity->getDaplosDateCreationFiche());
        $this->assertEquals($date, $entity->getDaplosDateDerniereSaisie());
        $this->assertEquals($date, $entity->getDaplosDateFinParcelle());
        $this->assertSame('ZCT', $entity->getDaplosCodeQualifiantCulture());
        $this->assertSame('ZL0', $entity->getDaplosCodeDestinationCulture());
        $this->assertSame('ZLS', $entity->getDaplosCodePeriodeSemis());
        $this->assertSame('ZF8', $entity->getDaplosCodeTypeSol());
        $this->assertSame('ZF4', $entity->getDaplosCodeTypeSousSol());
        $this->assertSame('ZBP', $entity->getDaplosCodeModeProduction());
        $this->assertSame(12, $entity->getDaplosNumeroIlot());
        $this->assertSame('RPG123', $entity->getDaplosNumeroRPG());
        $this->assertSame('V2', $entity->getDaplosCodeVariete2());
        $this->assertSame('V3', $entity->getDaplosCodeVariete3());
        $this->assertSame('V4', $entity->getDaplosCodeVariete4());
        $this->assertSame('V5', $entity->getDaplosCodeVariete5());
        $this->assertSame('ZHK', $entity->getDaplosCodeUniteRendement());
        $this->assertSame('PER001', $entity->getDaplosNumeroParcellePerenne());
        $this->assertSame(30, $entity->getDaplosProfondeurSol());
        $this->assertSame(15, $entity->getDaplosPierrosite());
        $this->assertSame('Limon', $entity->getDaplosAutreTypeSol());
        $this->assertSame('ZF1', $entity->getDaplosCodeAcidite());
        $this->assertSame('ZF4', $entity->getDaplosCodeProfondeurSousSol());
        $this->assertSame('ZDH', $entity->getDaplosCodeCultureIntermediaire());
        $this->assertTrue($entity->getDaplosParcelleDrainee());
        $this->assertFalse($entity->getDaplosParcelleRedecoupee());
        $this->assertSame('P001', $entity->getDaplosCleParcelleInitiale());
        $this->assertSame('ZLJ', $entity->getDaplosCodeGestionResidus());
        $this->assertSame('BO0513001', $entity->getDaplosCodeTypeSolV095());
    }
}
