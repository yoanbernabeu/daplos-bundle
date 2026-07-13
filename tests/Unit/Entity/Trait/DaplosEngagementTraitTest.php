<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Entity\Trait;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Engagement;
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosEngagementTrait;

class DaplosEngagementTraitTest extends TestCase
{
    public function testHydrateFromDto(): void
    {
        $dto = new Engagement(
            identifiantParcelle: '000178',
            annee: 2025,
            libelle: 'Contrat agriculture durable',
            codeEngagement: 'TPA',
            numeroContrat: 'CTR-2025-00042',
            dateContrat: new \DateTimeImmutable('2025-01-15'),
            identificationContractant: '12345678901234',
            typeIdentificationContractant: '107',
            contractantRaisonSociale1: 'Cooperative AgriValley',
            contractantRaisonSociale2: 'Service contrats',
            contractantAdresseRue1: '12 rue des Champs',
            contractantAdresseRue2: 'Batiment B',
            contractantVille: 'Auxerre',
            contractantCodePostal: '89000',
            contractantPays: 'FR',
        );

        $entity = new class {
            use DaplosEngagementTrait;
        };

        $entity->hydrateFromDaplosEngagement($dto);

        $this->assertSame('000178', $entity->getDaplosIdentifiantParcelle());
        $this->assertSame(2025, $entity->getDaplosAnnee());
        $this->assertSame('Contrat agriculture durable', $entity->getDaplosLibelle());
        $this->assertSame('TPA', $entity->getDaplosCodeEngagement());
        $this->assertSame('CTR-2025-00042', $entity->getDaplosNumeroContrat());
        $this->assertSame('20250115', $entity->getDaplosDateContrat()?->format('Ymd'));
        $this->assertSame('12345678901234', $entity->getDaplosIdentificationContractant());
        $this->assertSame('107', $entity->getDaplosTypeIdentificationContractant());
        $this->assertSame('Cooperative AgriValley', $entity->getDaplosContractantRaisonSociale1());
        $this->assertSame('Service contrats', $entity->getDaplosContractantRaisonSociale2());
        $this->assertSame('12 rue des Champs', $entity->getDaplosContractantAdresseRue1());
        $this->assertSame('Batiment B', $entity->getDaplosContractantAdresseRue2());
        $this->assertSame('Auxerre', $entity->getDaplosContractantVille());
        $this->assertSame('89000', $entity->getDaplosContractantCodePostal());
        $this->assertSame('FR', $entity->getDaplosContractantPays());
    }

    public function testHydrateWithEmptyDto(): void
    {
        $entity = new class {
            use DaplosEngagementTrait;
        };

        $entity->hydrateFromDaplosEngagement(new Engagement());

        $this->assertNull($entity->getDaplosCodeEngagement());
        $this->assertNull($entity->getDaplosNumeroContrat());
        $this->assertNull($entity->getDaplosDateContrat());
        $this->assertNull($entity->getDaplosIdentificationContractant());
        $this->assertNull($entity->getDaplosContractantRaisonSociale1());
        $this->assertNull($entity->getDaplosContractantPays());
    }
}
