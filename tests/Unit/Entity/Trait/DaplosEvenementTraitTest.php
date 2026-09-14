<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Entity\Trait;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosEvenementTrait;

class DaplosEvenementTraitTest extends TestCase
{
    public function testHydrateFromDto(): void
    {
        $dto = new Evenement(
            identifiantParcelle: '000178',
            annee: 2025,
            refIntervention: 'A1B2C3D4E5F60718293A4B5C6D7E8F90',
            codeIntervention: 'ZG7',
            codeCategorieIntervention: 'ZG7',
            libelleIntervention: 'Pulverisation fongicide',
            dateDebutIntervention: new \DateTimeImmutable('2025-03-15 08:30'),
            dateFinIntervention: new \DateTimeImmutable('2025-03-15 10:30'),
            codeStatutIntervention: 'ZK1',
            codeJustificationIntervention: 'ZB1',
            codeStadeVegetatif: 'SAC',
            libelleStadeVegetatif: 'Debut montaison',
            codeConditionsMeteo: 'ZC1',
            commentaire: 'Commentaire',
            surfaceTraitee: 12.34,
            codeAction: '2',
            dureeTraitement: '010430',
            datePreconisation: new \DateTimeImmutable('2025-03-10'),
            codeTypeTravail: 'PUL',
            complementTypeTravail: 'Passage cuve 2000L',
            complementMotivation: 'Pression maladie forte',
            codeTypeOperateur: 'ZHM',
            numeroLicenceOperateur: 'CERT-2025-00042',
            nomOperateur: 'Jean Dupont',
            codeTraitementsSpeciaux: 'ZKF',
            temperatureExterieure: -5,
            pourcentageHygrometrie: 65,
            quantiteBouillieViseeHa: 150.5,
            uniteBouillieViseeHa: 'LTR',
            quantiteBouillieEffectiveHa: 148.2,
            uniteBouillieEffectiveHa: 'LTR',
            codeStadeCultureBBCH: '06BBCH3070',
        );

        $entity = new class {
            use DaplosEvenementTrait;
        };

        $entity->hydrateFromDaplosEvenement($dto);

        $this->assertSame('000178', $entity->getDaplosIdentifiantParcelle());
        $this->assertSame(2025, $entity->getDaplosAnnee());
        $this->assertSame('ZG7', $entity->getDaplosCodeIntervention());
        $this->assertSame('ZK1', $entity->getDaplosCodeStatutIntervention());
        $this->assertSame('2', $entity->getDaplosCodeAction());
        $this->assertSame('010430', $entity->getDaplosDureeTraitement());
        $this->assertSame(1710, $entity->getDaplosDureeTraitementEnMinutes());
        $this->assertSame('20250310', $entity->getDaplosDatePreconisation()?->format('Ymd'));
        $this->assertSame('PUL', $entity->getDaplosCodeTypeTravail());
        $this->assertSame('Passage cuve 2000L', $entity->getDaplosComplementTypeTravail());
        $this->assertSame('Pression maladie forte', $entity->getDaplosComplementMotivation());
        $this->assertSame('ZHM', $entity->getDaplosCodeTypeOperateur());
        $this->assertSame('CERT-2025-00042', $entity->getDaplosNumeroLicenceOperateur());
        $this->assertSame('Jean Dupont', $entity->getDaplosNomOperateur());
        $this->assertSame('ZKF', $entity->getDaplosCodeTraitementsSpeciaux());
        $this->assertSame(-5, $entity->getDaplosTemperatureExterieure());
        $this->assertSame(65, $entity->getDaplosPourcentageHygrometrie());
        $this->assertSame('150.5', $entity->getDaplosQuantiteBouillieViseeHa());
        $this->assertSame('LTR', $entity->getDaplosUniteBouillieViseeHa());
        $this->assertSame('148.2', $entity->getDaplosQuantiteBouillieEffectiveHa());
        $this->assertSame('LTR', $entity->getDaplosUniteBouillieEffectiveHa());
        $this->assertSame('06BBCH3070', $entity->getDaplosCodeStadeCultureBBCH());
    }

    public function testDureeTraitementEnMinutesWithInvalidValue(): void
    {
        $entity = new class {
            use DaplosEvenementTrait;
        };

        $this->assertNull($entity->getDaplosDureeTraitementEnMinutes());

        $entity->setDaplosDureeTraitement('abc');
        $this->assertNull($entity->getDaplosDureeTraitementEnMinutes());

        $entity->setDaplosDureeTraitement('000130');
        $this->assertSame(90, $entity->getDaplosDureeTraitementEnMinutes());
    }

    public function testHydrateWithEmptyDto(): void
    {
        $entity = new class {
            use DaplosEvenementTrait;
        };

        $entity->hydrateFromDaplosEvenement(new Evenement());

        $this->assertNull($entity->getDaplosCodeAction());
        $this->assertNull($entity->getDaplosDureeTraitement());
        $this->assertNull($entity->getDaplosDatePreconisation());
        $this->assertNull($entity->getDaplosTemperatureExterieure());
        $this->assertNull($entity->getDaplosCodeStadeCultureBBCH());
    }
}
