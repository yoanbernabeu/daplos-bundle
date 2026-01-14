<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use YoanBernabeu\DaplosBundle\DTO\DaplosDocument;
use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;
use YoanBernabeu\DaplosBundle\DTO\Intrant\Intrant;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\Historique;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;
use YoanBernabeu\DaplosBundle\DTO\Recolte\Recolte;
use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;

/**
 * Validateur strict des codes contre les référentiels synchronisés.
 */
final class StrictReferentialValidator implements ReferentialValidatorInterface
{
    /** @var array<string, array<string, bool>> Cache des codes validés par type */
    private array $validatedCodes = [];

    /** @var class-string|null Classe de l'entité référentielle */
    private ?string $entityClass = null;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Configure la classe d'entité à utiliser pour la validation.
     *
     * @param class-string $entityClass
     */
    public function setEntityClass(string $entityClass): void
    {
        $this->entityClass = $entityClass;
    }

    public function validate(DaplosDocument $document): ValidationResult
    {
        $result = new ValidationResult();

        // Si aucune entité configurée, on ne peut pas valider
        if (null === $this->entityClass) {
            return $result;
        }

        // Valider les parcelles
        foreach ($document->parcelles as $parcelle) {
            $this->validateParcelle($parcelle, $result);
        }

        return $result;
    }

    private function validateParcelle(ParcelleCulturale $parcelle, ValidationResult $result): void
    {
        $context = sprintf('Parcelle %s', $parcelle->identifiant ?? 'inconnue');

        // Code espèce botanique
        $this->validateCode(
            $parcelle->codeEspeceBotanique,
            DaplosReferentialType::ESPECE_BOTANIQUE_D_UNE_CULTURE,
            'codeEspeceBotanique',
            $context,
            $result,
        );

        // Code qualifiant culture
        $this->validateCode(
            $parcelle->codeQualifiantCulture,
            DaplosReferentialType::QUALIFIANT_D_UNE_CULTURE,
            'codeQualifiantCulture',
            $context,
            $result,
        );

        // Code destination culture
        $this->validateCode(
            $parcelle->codeDestinationCulture,
            DaplosReferentialType::DESTINATION_D_UNE_CULTURE,
            'codeDestinationCulture',
            $context,
            $result,
        );

        // Code période semis
        $this->validateCode(
            $parcelle->codePeriodeSemis,
            DaplosReferentialType::PERIODE_DE_SEMIS_D_UNE_CULTURE,
            'codePeriodeSemis',
            $context,
            $result,
        );

        // Code justification culture
        $this->validateCode(
            $parcelle->codeJustificationCulture,
            DaplosReferentialType::JUSTIFICATION_DE_LA_CULTURE,
            'codeJustificationCulture',
            $context,
            $result,
        );

        // Code type de sol
        $this->validateCode(
            $parcelle->codeTypeSol,
            DaplosReferentialType::TYPE_DE_SOL,
            'codeTypeSol',
            $context,
            $result,
        );

        // Code type sous-sol
        $this->validateCode(
            $parcelle->codeTypeSousSol,
            DaplosReferentialType::TYPE_DE_SOUS_SOL,
            'codeTypeSousSol',
            $context,
            $result,
        );

        // Code unité de mesure (surface)
        $this->validateCode(
            $parcelle->codeUniteSurface,
            DaplosReferentialType::UNITE_DE_MESURE,
            'codeUniteSurface',
            $context,
            $result,
        );

        // Code mode de production
        $this->validateCode(
            $parcelle->codeModeProduction,
            DaplosReferentialType::MODE_DE_PRODUCTION,
            'codeModeProduction',
            $context,
            $result,
        );

        // Valider les historiques
        foreach ($parcelle->getHistoriques() as $historique) {
            $this->validateHistorique($historique, $result, $context);
        }

        // Valider les événements
        foreach ($parcelle->getEvenements() as $evenement) {
            $this->validateEvenement($evenement, $result, $context);
        }
    }

    private function validateHistorique(Historique $historique, ValidationResult $result, string $parcelleContext): void
    {
        $context = sprintf('%s, Historique %d', $parcelleContext, $historique->annee ?? 0);

        // Code traitement résidus
        $this->validateCode(
            $historique->codeTraitementResidus,
            DaplosReferentialType::TRAITEMENT_DES_RESIDUS_DE_CULTURE,
            'codeTraitementResidus',
            $context,
            $result,
        );

        // Code espèce botanique précédent
        $this->validateCode(
            $historique->codeEspeceBotanique,
            DaplosReferentialType::ESPECE_BOTANIQUE_D_UNE_CULTURE,
            'codeEspeceBotanique',
            $context,
            $result,
        );
    }

    private function validateEvenement(Evenement $evenement, ValidationResult $result, string $parcelleContext): void
    {
        $context = sprintf('%s, Intervention %s', $parcelleContext, $evenement->refIntervention ?? 'inconnue');

        // Code intervention
        $this->validateCode(
            $evenement->codeIntervention,
            DaplosReferentialType::INTERVENTION_AGRICOLE,
            'codeIntervention',
            $context,
            $result,
        );

        // Code catégorie intervention
        $this->validateCode(
            $evenement->codeCategorieIntervention,
            DaplosReferentialType::CATEGORIE_D_INTERVENTION,
            'codeCategorieIntervention',
            $context,
            $result,
        );

        // Code statut intervention
        $this->validateCode(
            $evenement->codeStatutIntervention,
            DaplosReferentialType::STATUT_D_UNE_INTERVENTION,
            'codeStatutIntervention',
            $context,
            $result,
        );

        // Code justification intervention
        $this->validateCode(
            $evenement->codeJustificationIntervention,
            DaplosReferentialType::JUSTIFICATION_DE_L_INTERVENTION,
            'codeJustificationIntervention',
            $context,
            $result,
        );

        // Code stade végétatif
        $this->validateCode(
            $evenement->codeStadeVegetatif,
            DaplosReferentialType::STADE_VEGETATIF,
            'codeStadeVegetatif',
            $context,
            $result,
        );

        // Code conditions météo
        $this->validateCode(
            $evenement->codeConditionsMeteo,
            DaplosReferentialType::CONDITIONS_METEROLOGIQUES,
            'codeConditionsMeteo',
            $context,
            $result,
        );

        // Valider les intrants
        foreach ($evenement->getIntrants() as $intrant) {
            $this->validateIntrant($intrant, $result, $context);
        }

        // Valider les récoltes
        foreach ($evenement->getRecoltes() as $recolte) {
            $this->validateRecolte($recolte, $result, $context);
        }
    }

    private function validateIntrant(Intrant $intrant, ValidationResult $result, string $evenementContext): void
    {
        $context = sprintf('%s, Intrant %s', $evenementContext, $intrant->designation ?? 'inconnu');

        // Code type intrant (famille)
        $this->validateCode(
            $intrant->codeTypeIntrant,
            DaplosReferentialType::FAMILLE_D_INTRANT,
            'codeTypeIntrant',
            $context,
            $result,
        );

        // Code unité
        $this->validateCode(
            $intrant->codeUnite,
            DaplosReferentialType::UNITE_DE_MESURE,
            'codeUnite',
            $context,
            $result,
        );

        // Code apport organique
        $this->validateCode(
            $intrant->codeApportOrganique,
            DaplosReferentialType::INTRANT_ET_QUALIFIANT_D_INTRANT,
            'codeApportOrganique',
            $context,
            $result,
        );

        // Code qualifiant intrant
        $this->validateCode(
            $intrant->codeQualifiantIntrant,
            DaplosReferentialType::INTRANT_ET_QUALIFIANT_D_INTRANT,
            'codeQualifiantIntrant',
            $context,
            $result,
        );
    }

    private function validateRecolte(Recolte $recolte, ValidationResult $result, string $evenementContext): void
    {
        $context = sprintf('%s, Récolte', $evenementContext);

        // Code type produit récolté
        $this->validateCode(
            $recolte->codeTypeProduitRecolte,
            DaplosReferentialType::TYPE_DE_PRODUIT_RECOLTE,
            'codeTypeProduitRecolte',
            $context,
            $result,
        );

        // Code espèce botanique
        $this->validateCode(
            $recolte->codeEspeceBotanique,
            DaplosReferentialType::ESPECE_BOTANIQUE_D_UNE_CULTURE,
            'codeEspeceBotanique',
            $context,
            $result,
        );

        // Code unité
        $this->validateCode(
            $recolte->codeUnite,
            DaplosReferentialType::UNITE_DE_MESURE,
            'codeUnite',
            $context,
            $result,
        );
    }

    private function validateCode(
        ?string $code,
        DaplosReferentialType $type,
        string $field,
        string $context,
        ValidationResult $result,
    ): void {
        // Ignorer les codes vides
        if (null === $code || '' === trim($code)) {
            return;
        }

        // Vérifier dans le cache
        $cacheKey = $type->value;
        if (isset($this->validatedCodes[$cacheKey][$code])) {
            if (!$this->validatedCodes[$cacheKey][$code]) {
                $result->addError(new ValidationError($code, $type, $field, $context));
            }

            return;
        }

        // Vérifier dans la base de données
        $exists = $this->codeExistsInDatabase($code, $type);

        // Mettre en cache
        if (!isset($this->validatedCodes[$cacheKey])) {
            $this->validatedCodes[$cacheKey] = [];
        }
        $this->validatedCodes[$cacheKey][$code] = $exists;

        // Ajouter l'erreur si le code n'existe pas
        if (!$exists) {
            $result->addError(new ValidationError($code, $type, $field, $context));
        }
    }

    private function codeExistsInDatabase(string $code, DaplosReferentialType $type): bool
    {
        if (null === $this->entityClass) {
            return true;
        }

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('COUNT(e)')
            ->from($this->entityClass, 'e')
            ->where('e.daplosReferenceCode = :code')
            ->andWhere('e.referentialType = :type')
            ->setParameter('code', $code)
            ->setParameter('type', $type);

        return (int) $qb->getQuery()->getSingleScalarResult() > 0;
    }

    /**
     * Réinitialise le cache des codes validés.
     */
    public function clearCache(): void
    {
        $this->validatedCodes = [];
    }
}
