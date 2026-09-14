<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Exporter\LineWriter;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Document\DocumentHeader;
use YoanBernabeu\DaplosBundle\DTO\Document\Intervenant;
use YoanBernabeu\DaplosBundle\DTO\Document\TypeAgriculture;
use YoanBernabeu\DaplosBundle\DTO\Interchange\InterchangeHeader;
use YoanBernabeu\DaplosBundle\DTO\Intervention\CibleEvenement;
use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;
use YoanBernabeu\DaplosBundle\DTO\Intervention\HistoriqueDecision;
use YoanBernabeu\DaplosBundle\DTO\Intrant\AnalyseEffluent;
use YoanBernabeu\DaplosBundle\DTO\Intrant\CompositionFertilisation;
use YoanBernabeu\DaplosBundle\DTO\Intrant\Intrant;
use YoanBernabeu\DaplosBundle\DTO\Intrant\LotFabricant;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Amendement;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Analyse;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Coordonnee;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Engagement;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Historique;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCadastrale;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\SurfaceParcelle;
use YoanBernabeu\DaplosBundle\DTO\Recolte\CaracterisationProduit;
use YoanBernabeu\DaplosBundle\DTO\Recolte\LotRecolte;
use YoanBernabeu\DaplosBundle\DTO\Recolte\Recolte;
use YoanBernabeu\DaplosBundle\Exporter\Contract\LineWriterInterface;
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
use YoanBernabeu\DaplosBundle\Parser\Contract\LineParserInterface;
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

/**
 * Vérifie la symétrie writer/parser pour chaque FLAG :
 * parse(write($dto)) doit redonner un DTO équivalent.
 */
class LineWriterSymmetryTest extends TestCase
{
    #[DataProvider('provideFlags')]
    public function testWriteThenParseReturnsEquivalentDto(
        LineWriterInterface $writer,
        LineParserInterface $parser,
        object $dto,
    ): void {
        $line = $writer->write($dto);

        $this->assertStringStartsWith($writer->getFlag(), $line);

        $parsed = $parser->parse($line);

        $this->assertEquals($dto, $parsed);
    }

    /**
     * @return iterable<string, array{LineWriterInterface, LineParserInterface, object}>
     */
    public static function provideFlags(): iterable
    {
        yield 'EI' => [new EILineWriter(), new EILineParser(), new InterchangeHeader(
            identificationEmetteur: '12345678901234',
            identificationDestinataire: '98765432109876',
            typeCodificationEmetteur: '5',
            typeCodificationDestinataire: '14',
            nombreDocuments: 1,
        )];

        yield 'DE' => [new DELineWriter(), new DELineParser(), new DocumentHeader(
            referenceDocument: 'DOC-2025-001',
            dateHeureDocument: new \DateTimeImmutable('2025-10-07'),
            versionFormat: '0.95',
            codeFonction: '9',
            nombreFichesParcellaires: 4,
        )];

        yield 'DA' => [new DALineWriter(), new DALineParser(), new Intervenant(
            typeIntervenant: 'TF',
            identification: '12345678901234567',
            typeIdentification: '107',
            raisonSociale1: 'Ferme des Grands Champs',
            raisonSociale2: 'EARL Bernabé',
            adresseRue1: '12 route de la Plaine',
            adresseRue2: 'Lieu-dit Les Vignes',
            ville: 'Sens',
            codePostal: '89100',
            codePays: 'FR',
            numeroPackage: 'PAC123456',
            referenceComplementaire1: 'REF-EXP-01',
            codeMSA: 'MSA789',
        )];

        yield 'DT' => [new DTLineWriter(), new DTLineParser(), new TypeAgriculture(
            codeTypeAgriculture: 'ZA1',
            libelle: 'Agriculture bio',
            numeroCertificat: 'CERT-2025-42',
        )];

        yield 'DP' => [new DPLineWriter(), new DPLineParser(), new ParcelleCulturale(
            identifiant: '00011234',
            annee: 2025,
            codeEspeceBotanique: 'ZDH',
            codeVariete: '1234ABC',
            codeQualifiantCulture: 'ZB1',
            codeDestinationCulture: 'ZC2',
            codePeriodeSemis: 'ZD3',
            codeTypeSol: 'ZE4',
            codeTypeSousSol: 'ZF5',
            nom: 'Parcelle du haut',
            codeCommune: '89100',
            dateDebutParcelle: new \DateTimeImmutable('2024-09-15'),
            dateCreationFiche: new \DateTimeImmutable('2024-09-01'),
            dateDerniereSaisie: new \DateTimeImmutable('2025-06-30'),
            dateFinParcelle: new \DateTimeImmutable('2025-08-15'),
            codeVariete2: '5678DEF',
            codeVariete3: '9012GHI',
            codeVariete4: '3456JKL',
            codeVariete5: '7890MNO',
            rendementObjectif: 85.5,
            codeUniteRendement: 'QTL',
            numeroIlotPac: 'ILOT12',
            numeroParcellePerenne: 'PER34',
            profondeurSol: 30,
            pierrosite: 15,
            autreTypeSol: 'Limon argileux profond',
            codeAcidite: 'ZG6',
            codeProfondeurSousSol: 'ZH7',
            codeCultureIntermediaire: 'ZAR',
            solHydromorphe: true,
            parcelleDrainee: false,
            parcelleRedecoupee: true,
            cleParcelleInitiale: 'A001',
            codeGestionResidus: 'ZI8',
            quantiteEpandue: 3.5,
            codeTypeSolV095: 'ARV123',
            doseAzote: 120.5,
        )];

        yield 'PS' => [new PSLineWriter(), new PSLineParser(), new SurfaceParcelle(
            identifiantParcelle: '00011234',
            annee: 2025,
            typeSurface: 'A17',
            surface: 12.34,
        )];

        yield 'SC' => [new SCLineWriter(), new SCLineParser(), new Coordonnee(
            identifiantParcelle: '00011234',
            annee: 2025,
            systemeCoordonnees: '4',
            x: 3.283,
            y: 48.19,
            altitude: 82.5,
        )];

        yield 'PC' => [new PCLineWriter(), new PCLineParser(), new ParcelleCadastrale(
            identifiantParcelle: '00011234',
            annee: 2025,
            codeCommune: '089123',
            section: 'AB',
            numero: '000123',
            surface: 1.25,
            numeroParcelleCadastrale: '089123AB000123CD',
            subdivisionFiscale: 'CD',
        )];

        yield 'CC' => [new CCLineWriter(), new CCLineParser(), new Coordonnee(
            identifiantParcelle: '00011234',
            annee: 2025,
            systemeCoordonnees: '4',
            x: 3.283,
            y: 48.19,
            numeroParcelleCadastrale: '089123AB000123CD',
            altitude: 82.5,
        )];

        yield 'PE' => [new PELineWriter(), new PELineParser(), new Engagement(
            identifiantParcelle: '00011234',
            annee: 2025,
            libelle: 'Contrat filière blé dur',
            codeEngagement: 'ZK1',
            numeroContrat: 'CTR-2025-0042',
            dateContrat: new \DateTimeImmutable('2025-01-10'),
            identificationContractant: '12345678901234',
            typeIdentificationContractant: '107',
            contractantRaisonSociale1: 'Coopérative du Sénonais',
            contractantRaisonSociale2: 'Union des producteurs',
            contractantAdresseRue1: '1 avenue des Champs',
            contractantAdresseRue2: 'BP 42',
            contractantVille: 'Auxerre',
            contractantCodePostal: '89000',
            contractantPays: 'FR',
        )];

        yield 'PH' => [new PHLineWriter(), new PHLineParser(), new Historique(
            identifiantParcelle: '00011234',
            annee: 2025,
            indexPrecedent: -1,
            codeEspeceBotanique: 'ZAR',
            cleParcellePrecedent: 'A001',
            varieteSemee1: '1234ABC',
            varieteSemee2: '5678DEF',
            varieteSemee3: '9012GHI',
            varieteSemee4: '3456JKL',
            varieteSemee5: '7890MNO',
            codeQualifiantEspece: 'ZB1',
            codePeriodeSemis: 'ZD3',
            codeDestination: 'ZC2',
            codeGestionResidus: 'ZI8',
            quantiteEpandue: 2.5,
        )];

        yield 'HA' => [new HALineWriter(), new HALineParser(), new Amendement(
            identifiantParcelle: '00011234',
            annee: 2025,
            codeAmendement: 'ZM1',
            quantite: 15.5,
            codeUnite: 'TNE',
            complementTypeAmendement: 'Fumier de bovin composté',
            dateAmendement: new \DateTimeImmutable('2024-10-20'),
            origineRaisonSociale1: 'GAEC de la Vallée',
            origineRaisonSociale2: 'Élevage bio',
            origineAdresseRue1: '3 chemin des Prés',
            origineAdresseRue2: 'Hameau du Moulin',
            origineVille: 'Joigny',
            origineCodePostal: '89300',
            originePays: 'FR',
        )];

        yield 'PA' => [new PALineWriter(), new PALineParser(), new Analyse(
            identifiantParcelle: '00011234',
            annee: 2025,
            datePrelevement: new \DateTimeImmutable('2024-11-05'),
            dateAnalyse: new \DateTimeImmutable('2024-11-20'),
            numeroBordereau: 'BORD-2024-789',
            identificationLaboratoire: '123456789',
            laboratoireRaisonSociale1: 'Labo Agro Analyses',
            laboratoireRaisonSociale2: 'Département sols',
            laboratoireAdresseRue1: '10 rue des Sciences',
            laboratoireAdresseRue2: 'Zone industrielle Nord',
            laboratoireVille: 'Dijon',
            laboratoireCodePostal: '21000',
            laboratoirePays: 'FR',
        )];

        yield 'PV' => [new PVLineWriter(), new PVLineParser(), new Evenement(
            identifiantParcelle: '00011234',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            codeIntervention: 'ZG7',
            codeCategorieIntervention: 'ZG7',
            libelleIntervention: 'Semis blé tendre',
            dateDebutIntervention: new \DateTimeImmutable('2024-10-15 08:30'),
            dateFinIntervention: new \DateTimeImmutable('2024-10-15 17:45'),
            codeStatutIntervention: 'ZF8',
            codeJustificationIntervention: 'ZJ1',
            codeStadeVegetatif: 'SAC',
            libelleStadeVegetatif: 'Levée',
            codeConditionsMeteo: 'ZW2',
            commentaire: 'Conditions optimales',
            surfaceTraitee: 12.34,
            codeAction: '2',
            dureeTraitement: '000915',
            datePreconisation: new \DateTimeImmutable('2024-10-10'),
            codeTypeTravail: 'ZT3',
            complementTypeTravail: 'Semis direct',
            complementMotivation: 'Fenêtre météo favorable',
            codeTypeOperateur: 'ZHM',
            numeroLicenceOperateur: 'LIC-42',
            nomOperateur: 'Jean Dupont',
            codeTraitementsSpeciaux: 'ZKF',
            temperatureExterieure: -3,
            pourcentageHygrometrie: 65,
            quantiteBouillieViseeHa: 180.5,
            uniteBouillieViseeHa: 'LTR',
            quantiteBouillieEffectiveHa: 175.25,
            uniteBouillieEffectiveHa: 'LTR',
            codeStadeCultureBBCH: '06BBCH0010',
        )];

        yield 'VB' => [new VBLineWriter(), new VBLineParser(), new CibleEvenement(
            identifiantParcelle: '00011234',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            codeOrganismeCible: 'ZO1',
            codeCibleV095: 'SEPTORIA01',
        )];

        yield 'VH' => [new VHLineWriter(), new VHLineParser(), new HistoriqueDecision(
            identifiantParcelle: '00011234',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            codeTypeLien: 'ZL4',
            refEvenementConsidere: 'EFGH5678901234EFGH5678901234EFGH',
            numeroParcelleAnterieur: 'A002',
            anneeRecolte: 2024,
            identificationExploitation: '12345678901234567',
            codeTypeIdentification: '107',
            exploitationRaisonSociale1: 'Ferme voisine',
            exploitationRaisonSociale2: 'GAEC des Coteaux',
            exploitationAdresse1: '5 rue du Lavoir',
            exploitationAdresse2: 'Le Bourg',
            exploitationVille: 'Villeneuve',
            exploitationCodePostal: '89500',
            exploitationPays: 'FR',
            infoParcelleNonEdi1: 'Parcelle reprise en 2024',
            infoParcelleNonEdi2: 'Ancien verger',
        )];

        yield 'VC' => [new VCLineWriter(), new VCLineParser(), new Coordonnee(
            identifiantParcelle: '00011234',
            annee: 2025,
            systemeCoordonnees: '4',
            x: 3.283,
            y: 48.19,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            altitude: 82.5,
        )];

        yield 'VI' => [new VILineWriter(), new VILineParser(), new Intrant(
            identifiantParcelle: '00011234',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            codeTypeIntrant: 'ZJC',
            designation: 'Ammonitrate 33.5',
            quantite: 250.5,
            codeUnite: 'KGM',
            codeAMM: 'AMM-123456',
            codeGNIS: '1234ABC',
            codeApportOrganique: 'ZA1',
            codeEAU: 'ZE1',
            codeAdjuvant: 'ZQ1',
            codeCalcoMagnesien: 'ZC1',
            codeQualifiantIntrant: 'ZF1',
            codeEAN: '3123456789012',
            codeQualifiantEffluent2: 'ZF2',
            codeQualifiantEffluent3: 'ZF3',
            codeQualifiantEffluent4: 'ZF4',
            codeQualifiantEffluent5: 'ZF5',
            codeQualifiantSemence1: 'ZQA',
            codeQualifiantSemence2: 'ZS2',
            codeQualifiantSemence3: 'ZS3',
            quantiteEffectiveHa: 20.5,
            codeUniteQuantiteEffectiveHa: 'KGM',
            doseHaVisee: 22.0,
            codeUniteDoseHaVisee: 'KGM',
            nombrePassagesPreconises: 1.5,
            origineEffluentRaisonSociale1: 'Élevage du Plateau',
            origineEffluentRaisonSociale2: 'SCEA des Prés',
            origineEffluentAdresse1: '8 route des Fermes',
            origineEffluentAdresse2: 'La Grange',
            origineEffluentVille: 'Toucy',
            origineEffluentCodePostal: '89130',
            origineEffluentPays: 'FR',
            densiteVolumique: 1.32,
        )];

        yield 'IC' => [new ICLineWriter(), new ICLineParser(), new CompositionFertilisation(
            identifiantParcelle: '00011234',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            codeElement: 'NT',
            teneur: 33.5,
        )];

        yield 'IL' => [new ILLineWriter(), new ILLineParser(), new LotFabricant(
            identifiantParcelle: '00011234',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            numeroLot: 'LOT-FAB-001',
            quantite: 500.0,
            codeUnite: 'KGM',
            codeProduit: 'PROD-42',
            pmg: 45.2,
            codeUnitePmg: 'GRM',
        )];

        yield 'IA' => [new IALineWriter(), new IALineParser(), new AnalyseEffluent(
            identifiantParcelle: '00011234',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            numeroBordereau: 'BORD-EFF-2024-12',
            identificationLaboratoire: '987654321',
            laboratoireRaisonSociale1: 'Labo Effluents',
            laboratoireRaisonSociale2: 'Pôle environnement',
            laboratoireAdresse1: '2 impasse des Analyses',
            laboratoireAdresse2: 'Bâtiment C',
            laboratoireVille: 'Troyes',
            laboratoireCodePostal: '10000',
            laboratoirePays: 'FR',
            dateAnalyse: new \DateTimeImmutable('2024-12-05'),
            datePrelevement: new \DateTimeImmutable('2024-12-01'),
        )];

        yield 'VR' => [new VRLineWriter(), new VRLineParser(), new Recolte(
            identifiantParcelle: '00011234',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            codeTypeProduitRecolte: 'ZP1',
            codeEspeceBotanique: 'ZDH',
            libelleProduit: 'Blé tendre meunier',
            quantite: 95.4,
            codeUnite: 'TNE',
            destinationProduit: 'ZC2',
            rendementCalcule: 77.3,
            codeUniteRendementCalcule: 'QTL',
            rendementEstime: 80.0,
            codeUniteRendementEstime: 'QTL',
        )];

        yield 'RL' => [new RLLineWriter(), new RLLineParser(), new LotRecolte(
            identifiantParcelle: '00011234',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            numeroLot: 'LOT-OS-2025-01',
            quantite: 42.5,
            numeroLotAgriculteur: 'LOT-AGRI-07',
        )];

        yield 'LC' => [new LCLineWriter(), new LCLineParser(), new CaracterisationProduit(
            identifiantParcelle: '00011234',
            annee: 2025,
            refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
            codeCaracteristique: 'ZQ1',
            valeur: '11.5',
            codeUnite: 'PCT',
        )];
    }

    public function testWriteWithWrongDtoTypeThrows(): void
    {
        $writer = new EILineWriter();

        $this->expectException(\YoanBernabeu\DaplosBundle\Exporter\Exception\DaplosExportException::class);

        $writer->write(new DocumentHeader());
    }
}
