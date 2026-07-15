<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Exporter;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\DaplosDocument;
use YoanBernabeu\DaplosBundle\DTO\Document\DocumentHeader;
use YoanBernabeu\DaplosBundle\DTO\Document\Intervenant;
use YoanBernabeu\DaplosBundle\DTO\Document\TypeAgriculture;
use YoanBernabeu\DaplosBundle\DTO\Interchange\InterchangeHeader;
use YoanBernabeu\DaplosBundle\DTO\Intervention\CibleEvenement;
use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;
use YoanBernabeu\DaplosBundle\DTO\Intervention\HistoriqueDecision;
use YoanBernabeu\DaplosBundle\DTO\Intrant\CompositionFertilisation;
use YoanBernabeu\DaplosBundle\DTO\Intrant\Intrant;
use YoanBernabeu\DaplosBundle\DTO\Intrant\LotFabricant;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Coordonnee;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Historique;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCadastrale;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\SurfaceParcelle;
use YoanBernabeu\DaplosBundle\DTO\Recolte\LotRecolte;
use YoanBernabeu\DaplosBundle\DTO\Recolte\Recolte;
use YoanBernabeu\DaplosBundle\Exporter\DaplosFileExporter;
use YoanBernabeu\DaplosBundle\Exporter\Exception\DaplosExportException;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\CCLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\DALineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\DELineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\DPLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\DTLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\EILineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\HALineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\IALineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\ICLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\ILLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\LCLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\PALineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\PCLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\PELineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\PHLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\PSLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\PVLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\RLLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\SCLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\VBLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\VCLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\VHLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\VILineWriter;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\VRLineWriter;
use YoanBernabeu\DaplosBundle\Exporter\Registry\LineWriterRegistry;
use YoanBernabeu\DaplosBundle\Parser\DaplosFileParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\CCLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DALineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DELineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DPLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\DTLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\EILineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\HALineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\IALineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\ICLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\ILLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\LCLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PALineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PCLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PELineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PHLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PSLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\PVLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\RLLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\SCLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\VBLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\VCLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\VHLineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\VILineParser;
use YoanBernabeu\DaplosBundle\Parser\LineParser\VRLineParser;
use YoanBernabeu\DaplosBundle\Parser\Registry\LineParserRegistry;

class DaplosFileExporterTest extends TestCase
{
    private DaplosFileExporter $exporter;
    private DaplosFileParser $parser;

    protected function setUp(): void
    {
        $this->exporter = new DaplosFileExporter(self::createWriterRegistry());
        $this->parser = new DaplosFileParser(self::createParserRegistry());
    }

    public function testExportEmptyDocumentReturnsEmptyString(): void
    {
        $this->assertSame('', $this->exporter->exportToString(new DaplosDocument()));
    }

    public function testExportUsesCrLfLineEnding(): void
    {
        $document = new DaplosDocument(
            interchange: new InterchangeHeader(identificationEmetteur: '12345678901234'),
            header: new DocumentHeader(versionFormat: '0.95'),
        );

        $output = $this->exporter->exportToString($document);

        $this->assertStringContainsString("\r\n", $output);
        $this->assertStringEndsWith("\r\n", $output);
    }

    public function testExportEncodesInIso88591ByDefault(): void
    {
        $document = new DaplosDocument(
            intervenants: [new Intervenant(typeIntervenant: 'TF', ville: 'Availles-Limouzine, Vézelay')],
        );

        $output = $this->exporter->exportToString($document);

        // "é" en ISO-8859-1 = \xE9 (un seul octet)
        $this->assertStringContainsString("V\xE9zelay", $output);
        $this->assertFalse(mb_check_encoding($output, 'UTF-8'));
    }

    public function testExportInUtf8WhenConfigured(): void
    {
        $exporter = new DaplosFileExporter(self::createWriterRegistry(), 'UTF-8');
        $document = new DaplosDocument(
            intervenants: [new Intervenant(typeIntervenant: 'TF', ville: 'Vézelay')],
        );

        $output = $exporter->exportToString($document);

        $this->assertStringContainsString('Vézelay', $output);
        $this->assertTrue(mb_check_encoding($output, 'UTF-8'));
    }

    public function testExportToFileWritesFile(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'daplos_test_');
        $this->assertNotFalse($path);

        try {
            $document = new DaplosDocument(
                interchange: new InterchangeHeader(identificationEmetteur: '12345678901234'),
            );

            $this->exporter->exportToFile($document, $path);

            $this->assertFileExists($path);
            $content = file_get_contents($path);
            $this->assertNotFalse($content);
            $this->assertStringStartsWith('EI', $content);
        } finally {
            @unlink($path);
        }
    }

    public function testExportToFileThrowsOnUnwritablePath(): void
    {
        $this->expectException(DaplosExportException::class);

        $this->exporter->exportToFile(new DaplosDocument(), '/chemin/inexistant/export.dap');
    }

    public function testRoundTripFullDocument(): void
    {
        $document = self::createFullDocument();

        $output = $this->exporter->exportToString($document);
        $parsed = $this->parser->parseString($output);

        $this->assertEquals($document, $parsed);
    }

    /**
     * Construit un document DAPLOS représentatif : en-têtes, intervenants,
     * parcelles avec surfaces + coordonnées, cadastre + coordonnées,
     * historiques + amendements, interventions avec intrants et récoltes.
     */
    private static function createFullDocument(): DaplosDocument
    {
        $surface = new SurfaceParcelle(
            identifiantParcelle: '0001A001',
            annee: 2025,
            typeSurface: 'A17',
            surface: 12.34,
        );
        $surface->addCoordonnee(new Coordonnee(
            identifiantParcelle: '0001A001',
            annee: 2025,
            systemeCoordonnees: '4',
            x: 3.283,
            y: 48.19,
            altitude: 82.5,
        ));

        $cadastrale = new ParcelleCadastrale(
            identifiantParcelle: '0001A001',
            annee: 2025,
            codeCommune: '089123',
            section: 'AB',
            numero: '000123',
            surface: 1.25,
            numeroParcelleCadastrale: '089123AB000123CD',
            subdivisionFiscale: 'CD',
        );
        $cadastrale->addCoordonnee(new Coordonnee(
            identifiantParcelle: '0001A001',
            annee: 2025,
            systemeCoordonnees: '4',
            x: 3.285,
            y: 48.191,
            numeroParcelleCadastrale: '089123AB000123CD',
            altitude: 81.0,
        ));

        $historique = new Historique(
            identifiantParcelle: '0001A001',
            annee: 2025,
            indexPrecedent: -1,
            codeEspeceBotanique: 'ZAR',
        );
        $historique->addAmendement(new \YoanBernabeu\DaplosBundle\DTO\Parcelle\Amendement(
            identifiantParcelle: '0001A001',
            annee: 2025,
            codeAmendement: 'ZM1',
            quantite: 15.5,
            codeUnite: 'TNE',
        ));

        $intrant = new Intrant(
            identifiantParcelle: '0001A001',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            codeTypeIntrant: 'ZJC',
            designation: 'Ammonitrate 33.5',
            quantite: 250.5,
            codeUnite: 'KGM',
        );
        $intrant->addComposition(new CompositionFertilisation(
            identifiantParcelle: '0001A001',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            codeElement: 'NT',
            teneur: 33.5,
        ));
        $intrant->addLot(new LotFabricant(
            identifiantParcelle: '0001A001',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            numeroLot: 'LOT-01',
            quantite: 500.0,
            codeUnite: 'KGM',
        ));
        $intrant->addAnalyseEffluent(new \YoanBernabeu\DaplosBundle\DTO\Intrant\AnalyseEffluent(
            identifiantParcelle: '0001A001',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            numeroBordereau: 'BORD-EFF-01',
            dateAnalyse: new \DateTimeImmutable('2024-12-05'),
        ));

        $recolte = new Recolte(
            identifiantParcelle: '0001A001',
            annee: 2025,
            refIntervention: 'EFGH5678901234EFGH5678901234EFGH',
            codeTypeProduitRecolte: 'ZP1',
            codeEspeceBotanique: 'ZDH',
            quantite: 95.4,
            codeUnite: 'TNE',
        );
        $recolte->addLot(new LotRecolte(
            identifiantParcelle: '0001A001',
            annee: 2025,
            refIntervention: 'EFGH5678901234EFGH5678901234EFGH',
            numeroLot: 'LOT-OS-01',
            quantite: 42.5,
        ));
        $recolte->addCaracterisation(new \YoanBernabeu\DaplosBundle\DTO\Recolte\CaracterisationProduit(
            identifiantParcelle: '0001A001',
            annee: 2025,
            refIntervention: 'EFGH5678901234EFGH5678901234EFGH',
            codeCaracteristique: 'ZQ1',
            valeur: '11.5',
            codeUnite: 'PCT',
        ));

        $semis = new Evenement(
            identifiantParcelle: '0001A001',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            codeIntervention: 'ZG7',
            codeCategorieIntervention: 'ZG7',
            libelleIntervention: 'Fertilisation azotée',
            dateDebutIntervention: new \DateTimeImmutable('2025-03-15 08:30'),
            codeStatutIntervention: 'ZF8',
        );
        $semis->addCible(new CibleEvenement(
            identifiantParcelle: '0001A001',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            codeCibleV095: 'SEPTORIA01',
        ));
        $semis->setHistoriqueDecision(new HistoriqueDecision(
            identifiantParcelle: '0001A001',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            codeTypeLien: 'ZL4',
            infoParcelleNonEdi1: 'Décision sur reliquat azoté',
        ));
        $semis->addCoordonnee(new Coordonnee(
            identifiantParcelle: '0001A001',
            annee: 2025,
            systemeCoordonnees: '4',
            x: 3.284,
            y: 48.192,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
        ));
        $semis->addIntrant($intrant);

        $moisson = new Evenement(
            identifiantParcelle: '0001A001',
            annee: 2025,
            refIntervention: 'EFGH5678901234EFGH5678901234EFGH',
            codeIntervention: 'ZH1',
            codeCategorieIntervention: 'ZH1',
            libelleIntervention: 'Moisson',
            codeStatutIntervention: 'ZF8',
        );
        $moisson->addRecolte($recolte);

        $parcelle1 = new ParcelleCulturale(
            identifiant: '0001A001',
            annee: 2025,
            codeEspeceBotanique: 'ZDH',
            nom: 'Parcelle du haut',
        );
        $parcelle1->addSurface($surface);
        $parcelle1->addParcelleCadastrale($cadastrale);
        $parcelle1->addEngagement(new \YoanBernabeu\DaplosBundle\DTO\Parcelle\Engagement(
            identifiantParcelle: '0001A001',
            annee: 2025,
            codeEngagement: 'ZK1',
            numeroContrat: 'CTR-42',
        ));
        $parcelle1->addHistorique($historique);
        $parcelle1->addAnalyse(new \YoanBernabeu\DaplosBundle\DTO\Parcelle\Analyse(
            identifiantParcelle: '0001A001',
            annee: 2025,
            numeroBordereau: 'BORD-2024-789',
            dateAnalyse: new \DateTimeImmutable('2024-11-20'),
        ));
        $parcelle1->addEvenement($semis);
        $parcelle1->addEvenement($moisson);

        $parcelle2 = new ParcelleCulturale(
            identifiant: '0002A002',
            annee: 2025,
            codeEspeceBotanique: 'ZAR',
            nom: 'Parcelle du bas',
        );

        return new DaplosDocument(
            interchange: new InterchangeHeader(
                identificationEmetteur: '12345678901234',
                identificationDestinataire: '98765432109876',
                typeCodificationEmetteur: '5',
                typeCodificationDestinataire: '14',
                nombreDocuments: 1,
            ),
            header: new DocumentHeader(
                referenceDocument: 'DOC-2025-001',
                dateHeureDocument: new \DateTimeImmutable('2025-10-07'),
                versionFormat: '0.95',
                codeFonction: '9',
                nombreFichesParcellaires: 2,
            ),
            intervenants: [
                new Intervenant(
                    typeIntervenant: 'TF',
                    identification: '12345678901234',
                    typeIdentification: '107',
                    raisonSociale1: 'Ferme des Grands Champs',
                    ville: 'Vézelay',
                    codePostal: '89450',
                    codePays: 'FR',
                ),
            ],
            typesAgriculture: [
                new TypeAgriculture(codeTypeAgriculture: 'ZA1', numeroCertificat: 'CERT-42'),
            ],
            parcelles: [$parcelle1, $parcelle2],
        );
    }

    private static function createWriterRegistry(): LineWriterRegistry
    {
        return new LineWriterRegistry([
            new EILineWriter(), new DELineWriter(), new DALineWriter(), new DTLineWriter(),
            new DPLineWriter(), new PSLineWriter(), new SCLineWriter(), new PCLineWriter(),
            new CCLineWriter(), new PELineWriter(), new PHLineWriter(), new HALineWriter(),
            new PALineWriter(), new PVLineWriter(), new VBLineWriter(), new VHLineWriter(),
            new VCLineWriter(), new VILineWriter(), new ICLineWriter(), new ILLineWriter(),
            new IALineWriter(), new VRLineWriter(), new RLLineWriter(), new LCLineWriter(),
        ]);
    }

    private static function createParserRegistry(): LineParserRegistry
    {
        return new LineParserRegistry([
            new EILineParser(), new DELineParser(), new DALineParser(), new DTLineParser(),
            new DPLineParser(), new PSLineParser(), new SCLineParser(), new PCLineParser(),
            new CCLineParser(), new PELineParser(), new PHLineParser(), new HALineParser(),
            new PALineParser(), new PVLineParser(), new VBLineParser(), new VHLineParser(),
            new VCLineParser(), new VILineParser(), new ICLineParser(), new ILLineParser(),
            new IALineParser(), new VRLineParser(), new RLLineParser(), new LCLineParser(),
        ]);
    }
}
