<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\DaplosDocument;
use YoanBernabeu\DaplosBundle\DTO\Intervention\CibleEvenement;
use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;
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
    ];

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
        $validator = new StrictReferentialValidator($this->entityManagerWithReferentiels());
        $validator->setEntityClass(\stdClass::class);

        return $validator->validate($this->documentWith($evenement));
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
