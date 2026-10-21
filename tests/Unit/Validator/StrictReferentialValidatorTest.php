<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\DaplosDocument;
use YoanBernabeu\DaplosBundle\DTO\Intervention\CibleEvenement;
use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;
use YoanBernabeu\DaplosBundle\DTO\Intervention\HistoriqueDecision;
use YoanBernabeu\DaplosBundle\DTO\Intrant\CompositionFertilisation;
use YoanBernabeu\DaplosBundle\DTO\Intrant\Intrant;
use YoanBernabeu\DaplosBundle\DTO\Intrant\LotFabricant;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Amendement;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Historique;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\SurfaceParcelle;
use YoanBernabeu\DaplosBundle\DTO\Recolte\CaracterisationProduit;
use YoanBernabeu\DaplosBundle\DTO\Recolte\Recolte;
use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;
use YoanBernabeu\DaplosBundle\Validator\StrictReferentialValidator;
use YoanBernabeu\DaplosBundle\Validator\ValidationError;
use YoanBernabeu\DaplosBundle\Validator\ValidationResult;

class StrictReferentialValidatorTest extends TestCase
{
    /**
     * Codes présents dans les référentiels simulés, indexés par type.
     *
     * @var array<string, list<string>>
     */
    private const REFERENTIELS = [
        'categorie_d_intervention' => ['ZG7', 'ZF7', 'ZF8'],
        'intervention_agricole' => ['SEM', 'SEX'],
        'stade_vegetatif' => ['06BBCH3010', '06BBCH0010'],
        'organisme_vivant_cible_ou_auxiliaire' => ['0000001ACLRG'],
        'unite_de_mesure' => ['KGM', 'LTR', 'HAR'],
        'surface_exprimee' => ['A17'],
        'teneur_en_compose_chimique' => ['N'],
        'traitement_des_residus_de_culture' => ['ZRE'],
        'qualifiant_d_une_culture' => ['ZQA'],
        'periode_de_semis_d_une_culture' => ['ZPS'],
        'destination_d_une_culture' => ['ZDE'],
        'espece_botanique_d_une_culture' => ['ZDH'],
        'intrant_et_qualifiant_d_intrant' => ['ZIQ'],
        'amendements_du_sol' => ['ZAM'],
        'nature_du_lien' => ['ZL4'],
    ];

    /**
     * Chaque champ codé du guide v0.95 est contrôlé avec la nomenclature
     * indiquée par le guide.
     *
     * @return iterable<string, array{\Closure(string): DaplosDocument, string, DaplosReferentialType}>
     */
    public static function provideChampsControles(): iterable
    {
        $parcelle = static fn (string $code, string $champ): DaplosDocument => new DaplosDocument(parcelles: [
            new ParcelleCulturale(...['identifiant' => '0001', $champ => $code]),
        ]);
        $surface = static function (string $code): DaplosDocument {
            $parcelle = new ParcelleCulturale(identifiant: '0001');
            $parcelle->addSurface(new SurfaceParcelle(typeSurface: $code, surface: 1.0));

            return new DaplosDocument(parcelles: [$parcelle]);
        };
        $historique = static function (string $code, string $champ): DaplosDocument {
            $parcelle = new ParcelleCulturale(identifiant: '0001');
            $parcelle->addHistorique(new Historique(...['indexPrecedent' => -1, 'codeEspeceBotanique' => 'ZDH', $champ => $code]));

            return new DaplosDocument(parcelles: [$parcelle]);
        };
        $amendement = static function (string $code, string $champ): DaplosDocument {
            $historique = new Historique(indexPrecedent: -1, codeEspeceBotanique: 'ZDH');
            $historique->addAmendement(new Amendement(...[$champ => $code]));
            $parcelle = new ParcelleCulturale(identifiant: '0001');
            $parcelle->addHistorique($historique);

            return new DaplosDocument(parcelles: [$parcelle]);
        };
        $evenement = static function (Evenement $evenement): DaplosDocument {
            $parcelle = new ParcelleCulturale(identifiant: '0001');
            $parcelle->addEvenement($evenement);

            return new DaplosDocument(parcelles: [$parcelle]);
        };
        $intrant = static function (string $code, string $champ) use ($evenement): DaplosDocument {
            $ev = new Evenement(refIntervention: 'ABCD');
            $ev->addIntrant(new Intrant(...[$champ => $code]));

            return $evenement($ev);
        };
        $composition = static function (string $code) use ($evenement): DaplosDocument {
            $intrant = new Intrant();
            $intrant->addComposition(new CompositionFertilisation(codeElement: $code, teneur: 1.0));
            $ev = new Evenement(refIntervention: 'ABCD');
            $ev->addIntrant($intrant);

            return $evenement($ev);
        };
        $lot = static function (string $code, string $champ) use ($evenement): DaplosDocument {
            $intrant = new Intrant();
            $intrant->addLot(new LotFabricant(...[$champ => $code]));
            $ev = new Evenement(refIntervention: 'ABCD');
            $ev->addIntrant($intrant);

            return $evenement($ev);
        };
        $recolte = static function (string $code, string $champ) use ($evenement): DaplosDocument {
            $ev = new Evenement(refIntervention: 'ABCD');
            $ev->addRecolte(new Recolte(...[$champ => $code]));

            return $evenement($ev);
        };
        $caracterisation = static function (string $code) use ($evenement): DaplosDocument {
            $recolte = new Recolte();
            $recolte->addCaracterisation(new CaracterisationProduit(codeUnite: $code));
            $ev = new Evenement(refIntervention: 'ABCD');
            $ev->addRecolte($recolte);

            return $evenement($ev);
        };

        $unite = DaplosReferentialType::UNITE_DE_MESURE;
        $qualifiantIntrant = DaplosReferentialType::INTRANT_ET_QUALIFIANT_D_INTRANT;

        yield 'DP 103-105 unité de rendement' => [static fn (string $c) => $parcelle($c, 'codeUniteRendement'), 'codeUniteRendement', $unite];
        yield 'DP 220-222 culture intermédiaire' => [static fn (string $c) => $parcelle($c, 'codeCultureIntermediaire'), 'codeCultureIntermediaire', DaplosReferentialType::ESPECE_BOTANIQUE_D_UNE_CULTURE];
        yield 'DP 230-232 gestion des résidus' => [static fn (string $c) => $parcelle($c, 'codeGestionResidus'), 'codeGestionResidus', DaplosReferentialType::TRAITEMENT_DES_RESIDUS_DE_CULTURE];
        yield 'PS 15-17 type de surface' => [$surface, 'typeSurface', DaplosReferentialType::SURFACE_EXPRIMEE];
        yield 'PH 59-61 qualifiant d\'espèce' => [static fn (string $c) => $historique($c, 'codeQualifiantEspece'), 'codeQualifiantEspece', DaplosReferentialType::QUALIFIANT_D_UNE_CULTURE];
        yield 'PH 62-64 période de semis' => [static fn (string $c) => $historique($c, 'codePeriodeSemis'), 'codePeriodeSemis', DaplosReferentialType::PERIODE_DE_SEMIS_D_UNE_CULTURE];
        yield 'PH 65-67 destination' => [static fn (string $c) => $historique($c, 'codeDestination'), 'codeDestination', DaplosReferentialType::DESTINATION_D_UNE_CULTURE];
        yield 'PH 68-70 gestion des résidus' => [static fn (string $c) => $historique($c, 'codeGestionResidus'), 'codeGestionResidus', DaplosReferentialType::TRAITEMENT_DES_RESIDUS_DE_CULTURE];
        yield 'HA 15-17 type d\'amendement' => [static fn (string $c) => $amendement($c, 'codeAmendement'), 'codeAmendement', DaplosReferentialType::AMENDEMENTS_DU_SOL];
        yield 'HA 70-72 unité' => [static fn (string $c) => $amendement($c, 'codeUnite'), 'codeUnite', $unite];
        yield 'PV 321-323 unité de bouillie visée' => [static fn (string $c) => $evenement(new Evenement(uniteBouillieViseeHa: $c)), 'uniteBouillieViseeHa', $unite];
        yield 'PV 333-335 unité de bouillie effective' => [static fn (string $c) => $evenement(new Evenement(uniteBouillieEffectiveHa: $c)), 'uniteBouillieEffectiveHa', $unite];
        yield 'VI 184-186 calco-magnésien' => [static fn (string $c) => $intrant($c, 'codeCalcoMagnesien'), 'codeCalcoMagnesien', $qualifiantIntrant];
        foreach ([2, 3, 4, 5] as $n) {
            yield 'VI qualifiant effluent '.$n => [static fn (string $c) => $intrant($c, 'codeQualifiantEffluent'.$n), 'codeQualifiantEffluent'.$n, $qualifiantIntrant];
        }
        foreach ([1, 2, 3] as $n) {
            yield 'VI qualifiant semence '.$n => [static fn (string $c) => $intrant($c, 'codeQualifiantSemence'.$n), 'codeQualifiantSemence'.$n, $qualifiantIntrant];
        }
        yield 'VI 232-234 unité de la quantité par hectare' => [static fn (string $c) => $intrant($c, 'codeUniteQuantiteEffectiveHa'), 'codeUniteQuantiteEffectiveHa', $unite];
        yield 'VI 244-246 unité de la dose visée' => [static fn (string $c) => $intrant($c, 'codeUniteDoseHaVisee'), 'codeUniteDoseHaVisee', $unite];
        yield 'IC 47-49 composant' => [$composition, 'codeElement', DaplosReferentialType::TENEUR_EN_COMPOSE_CHIMIQUE];
        yield 'IL 126-128 unité' => [static fn (string $c) => $lot($c, 'codeUnite'), 'codeUnite', $unite];
        yield 'IL 138-140 unité du PMG' => [static fn (string $c) => $lot($c, 'codeUnitePmg'), 'codeUnitePmg', $unite];
        yield 'VR 88-90 destination' => [static fn (string $c) => $recolte($c, 'destinationProduit'), 'destinationProduit', DaplosReferentialType::DESTINATION_D_UNE_CULTURE];
        yield 'VR 112-114 unité du rendement calculé' => [static fn (string $c) => $recolte($c, 'codeUniteRendementCalcule'), 'codeUniteRendementCalcule', $unite];
        yield 'VR 124-126 unité du rendement estimé' => [static fn (string $c) => $recolte($c, 'codeUniteRendementEstime'), 'codeUniteRendementEstime', $unite];
        yield 'LC 59-61 unité' => [$caracterisation, 'codeUnite', $unite];
        yield 'VH 47-49 type de lien' => [static function (string $c) use ($evenement): DaplosDocument {
            $ev = new Evenement(refIntervention: 'ABCD');
            $ev->setHistoriqueDecision(new HistoriqueDecision(codeTypeLien: $c));

            return $evenement($ev);
        }, 'codeTypeLien', DaplosReferentialType::NATURE_DU_LIEN];
    }

    /**
     * @param \Closure(string): DaplosDocument $document
     */
    #[DataProvider('provideChampsControles')]
    public function testChampCodeEstControleAvecLaNomenclatureDuGuide(\Closure $document, string $champ, DaplosReferentialType $type): void
    {
        $result = $this->validateDocument($document('ZZZ'));

        $this->assertSame([$champ], $this->erroredFields($result));
        $this->assertSame($type, $result->getErrors()[0]->referentialType);
        $this->assertSame('ZZZ', $result->getErrors()[0]->code);

        $valide = self::REFERENTIELS[$type->value][0];
        $this->assertTrue($this->validateDocument($document($valide))->isValid(), $champ.' = '.$valide);
    }

    /**
     * Ces champs du DTO ne figurent pas dans le FLAG DP du guide v0.95 :
     * le parser ne les remplit jamais, le validateur ne les contrôle pas.
     */
    public function testChampsDpHorsGuideNeSontPasControles(): void
    {
        $result = $this->validateDocument(new DaplosDocument(parcelles: [
            new ParcelleCulturale(
                identifiant: '0001',
                codeJustificationCulture: 'ZZZ',
                codeUniteSurface: 'ZZZ',
                codeModeProduction: 'ZZZ',
            ),
        ]));

        $this->assertTrue($result->isValid(), implode("\n", $result->getErrorMessages()));
    }

    public function testReturnsValidResultWithoutEntityClass(): void
    {
        $validator = new StrictReferentialValidator($this->createMock(EntityManagerInterface::class));

        $result = $validator->validate($this->documentWith(new Evenement(codeCategorieIntervention: 'XXX')));

        $this->assertTrue($result->isValid());
    }

    public function testRealWorldEvenementIsValid(): void
    {
        $result = $this->validate(new Evenement(
            codeIntervention: 'ZG7',
            codeCategorieIntervention: 'ZG7',
            codeStadeVegetatif: 'SAC',
            codeTypeTravail: 'SEM',
            codeStadeCultureBBCH: '06BBCH3010',
        ));

        $this->assertTrue($result->isValid(), implode("\n", $result->getErrorMessages()));
    }

    public function testCodeInterventionIsNotValidatedAgainstInterventionAgricole(): void
    {
        $result = $this->validate(new Evenement(codeIntervention: 'ZG7', codeCategorieIntervention: 'ZG7'));

        $this->assertNotContains('codeIntervention', $this->erroredFields($result));
    }

    public function testCodeCategorieInterventionIsValidated(): void
    {
        $result = $this->validate(new Evenement(codeCategorieIntervention: 'SEM'));

        $this->assertSame(['codeCategorieIntervention'], $this->erroredFields($result));
        $this->assertSame(DaplosReferentialType::CATEGORIE_D_INTERVENTION, $result->getErrors()[0]->referentialType);
    }

    public function testCodeTypeTravailIsValidatedAgainstInterventionAgricole(): void
    {
        $result = $this->validate(new Evenement(codeTypeTravail: 'ZG7'));

        $this->assertSame(['codeTypeTravail'], $this->erroredFields($result));
        $this->assertSame(DaplosReferentialType::INTERVENTION_AGRICOLE, $result->getErrors()[0]->referentialType);
    }

    public function testObsoleteCodeStadeVegetatifIsNotValidated(): void
    {
        $result = $this->validate(new Evenement(codeStadeVegetatif: 'SAC'));

        $this->assertTrue($result->isValid());
    }

    public function testCodeStadeCultureBBCHIsValidatedAgainstStadeVegetatif(): void
    {
        $result = $this->validate(new Evenement(codeStadeCultureBBCH: '06BBCH3010'));

        $this->assertTrue($result->isValid());
    }

    /**
     * Le guide v0.95 impose un code de la nomenclature Stade végétatif (an10) :
     * les formats hors référentiel sont signalés.
     */
    public function testCodeStadeCultureBBCHOutsideReferentialIsReported(): void
    {
        foreach (['BBCH31', '06BBCH0000a'] as $code) {
            $result = $this->validate(new Evenement(codeStadeCultureBBCH: $code));

            $this->assertSame(['codeStadeCultureBBCH'], $this->erroredFields($result), $code);
            $this->assertSame(DaplosReferentialType::STADE_VEGETATIF, $result->getErrors()[0]->referentialType);
        }
    }

    public function testCodeCibleV095IsValidatedAgainstOrganismeVivant(): void
    {
        $evenement = new Evenement(refIntervention: 'ABCD');
        $evenement->addCible(new CibleEvenement(codeCibleV095: '0000001ACLRG'));
        $evenement->addCible(new CibleEvenement(codeCibleV095: 'INCONNU'));

        $result = $this->validate($evenement);

        $this->assertSame(['codeCibleV095'], $this->erroredFields($result));
        $this->assertSame('INCONNU', $result->getErrors()[0]->code);
        $this->assertSame(DaplosReferentialType::ORGANISME_VIVANT_CIBLE_OU_AUXILIAIRE, $result->getErrors()[0]->referentialType);
    }

    public function testObsoleteCodeOrganismeCibleIsNotValidated(): void
    {
        $evenement = new Evenement();
        $evenement->addCible(new CibleEvenement(codeOrganismeCible: 'R54'));

        $this->assertTrue($this->validate($evenement)->isValid());
    }

    private function validate(Evenement $evenement): ValidationResult
    {
        return $this->validateDocument($this->documentWith($evenement));
    }

    private function validateDocument(DaplosDocument $document): ValidationResult
    {
        $validator = new StrictReferentialValidator($this->entityManagerWithReferentiels());
        $validator->setEntityClass(\stdClass::class);

        return $validator->validate($document);
    }

    private function documentWith(Evenement $evenement): DaplosDocument
    {
        $parcelle = new ParcelleCulturale(identifiant: '0001');
        $parcelle->addEvenement($evenement);

        return new DaplosDocument(parcelles: [$parcelle]);
    }

    /**
     * @return list<string>
     */
    private function erroredFields(ValidationResult $result): array
    {
        return array_map(static fn (ValidationError $error): string => $error->field, $result->getErrors());
    }

    private function entityManagerWithReferentiels(): EntityManagerInterface
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method('createQueryBuilder')->willReturnCallback(function (): QueryBuilder {
            /** @var array<string, mixed> $parameters */
            $parameters = [];

            $query = $this->createMock(Query::class);
            $query->method('getSingleScalarResult')->willReturnCallback(
                static function () use (&$parameters): int {
                    $codes = self::REFERENTIELS[$parameters['type']->value] ?? [];

                    return in_array($parameters['code'], $codes, true) ? 1 : 0;
                }
            );

            $queryBuilder = $this->createMock(QueryBuilder::class);
            foreach (['select', 'from', 'where', 'andWhere'] as $method) {
                $queryBuilder->method($method)->willReturnSelf();
            }
            $queryBuilder->method('setParameter')->willReturnCallback(
                static function (string $key, mixed $value) use (&$parameters, $queryBuilder): QueryBuilder {
                    $parameters[$key] = $value;

                    return $queryBuilder;
                }
            );
            $queryBuilder->method('getQuery')->willReturn($query);

            return $queryBuilder;
        });

        return $entityManager;
    }
}
