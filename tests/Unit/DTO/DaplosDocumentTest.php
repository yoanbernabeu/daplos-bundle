<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\DTO;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\DaplosDocument;
use YoanBernabeu\DaplosBundle\DTO\Document\DocumentHeader;
use YoanBernabeu\DaplosBundle\DTO\Document\Intervenant;
use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;

class DaplosDocumentTest extends TestCase
{
    public function testEmptyDocument(): void
    {
        $document = new DaplosDocument();

        $this->assertNull($document->interchange);
        $this->assertNull($document->header);
        $this->assertEmpty($document->intervenants);
        $this->assertEmpty($document->parcelles);
        $this->assertSame(0, $document->countParcelles());
        $this->assertSame(0, $document->countInterventions());
    }

    public function testWithHeader(): void
    {
        $header = new DocumentHeader(versionFormat: '0.95');
        $document = new DaplosDocument(header: $header);

        $this->assertSame('0.95', $document->getVersion());
    }

    public function testGetExploitant(): void
    {
        $exploitant = new Intervenant(
            typeIntervenant: Intervenant::TYPE_TF,
            raisonSociale1: 'EARL Test',
        );
        $fournisseur = new Intervenant(
            typeIntervenant: Intervenant::TYPE_FR,
            raisonSociale1: 'Fournisseur Test',
        );

        $document = new DaplosDocument(
            intervenants: [$fournisseur, $exploitant],
        );

        $result = $document->getExploitant();

        $this->assertNotNull($result);
        $this->assertSame('EARL Test', $result->raisonSociale1);
        $this->assertTrue($result->isExploitant());
    }

    public function testGetFournisseur(): void
    {
        $exploitant = new Intervenant(
            typeIntervenant: Intervenant::TYPE_TF,
            raisonSociale1: 'EARL Test',
        );
        $fournisseur = new Intervenant(
            typeIntervenant: Intervenant::TYPE_FR,
            raisonSociale1: 'Fournisseur Test',
        );

        $document = new DaplosDocument(
            intervenants: [$exploitant, $fournisseur],
        );

        $result = $document->getFournisseur();

        $this->assertNotNull($result);
        $this->assertSame('Fournisseur Test', $result->raisonSociale1);
        $this->assertTrue($result->isFournisseur());
    }

    public function testGetMandataire(): void
    {
        $mandataire = new Intervenant(
            typeIntervenant: Intervenant::TYPE_MR,
            raisonSociale1: 'Mandataire Test',
        );

        $document = new DaplosDocument(
            intervenants: [$mandataire],
        );

        $result = $document->getMandataire();

        $this->assertNotNull($result);
        $this->assertSame('Mandataire Test', $result->raisonSociale1);
    }

    public function testCountParcelles(): void
    {
        $parcelle1 = new ParcelleCulturale(identifiant: '00001');
        $parcelle2 = new ParcelleCulturale(identifiant: '00002');

        $document = new DaplosDocument(
            parcelles: [$parcelle1, $parcelle2],
        );

        $this->assertSame(2, $document->countParcelles());
    }

    public function testCountInterventions(): void
    {
        $parcelle1 = new ParcelleCulturale(identifiant: '00001');
        $parcelle1->addEvenement(new Evenement(refIntervention: 'INT1'));
        $parcelle1->addEvenement(new Evenement(refIntervention: 'INT2'));

        $parcelle2 = new ParcelleCulturale(identifiant: '00002');
        $parcelle2->addEvenement(new Evenement(refIntervention: 'INT3'));

        $document = new DaplosDocument(
            parcelles: [$parcelle1, $parcelle2],
        );

        $this->assertSame(3, $document->countInterventions());
    }

    public function testNoExploitantReturnsNull(): void
    {
        $document = new DaplosDocument();

        $this->assertNull($document->getExploitant());
    }

    public function testSourceFile(): void
    {
        $document = new DaplosDocument(sourceFile: '/path/to/file.dap');

        $this->assertSame('/path/to/file.dap', $document->sourceFile);
    }
}
