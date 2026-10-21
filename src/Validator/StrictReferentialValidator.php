<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use YoanBernabeu\DaplosBundle\DTO\DaplosDocument;
use YoanBernabeu\DaplosBundle\DTO\Intervention\CibleEvenement;
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

        // FLAG DP (guide v0.95, pages 13-16). Les champs codeJustificationCulture,
        // codeUniteSurface et codeModeProduction du DTO ne figurent pas dans le FLAG DP
        // du guide : le parser ne les remplit jamais, ils ne sont pas contrôlés.
        $this->validateCodes([
            [$parcelle->codeEspeceBotanique, DaplosReferentialType::ESPECE_BOTANIQUE_D_UNE_CULTURE, 'codeEspeceBotanique'],
            [$parcelle->codeQualifiantCulture, DaplosReferentialType::QUALIFIANT_D_UNE_CULTURE, 'codeQualifiantCulture'],
            [$parcelle->codePeriodeSemis, DaplosReferentialType::PERIODE_DE_SEMIS_D_UNE_CULTURE, 'codePeriodeSemis'],
            [$parcelle->codeDestinationCulture, DaplosReferentialType::DESTINATION_D_UNE_CULTURE, 'codeDestinationCulture'],
            [$parcelle->codeUniteRendement, DaplosReferentialType::UNITE_DE_MESURE, 'codeUniteRendement'],
            [$parcelle->codeTypeSol, DaplosReferentialType::TYPE_DE_SOL, 'codeTypeSol'],
            [$parcelle->codeTypeSousSol, DaplosReferentialType::TYPE_DE_SOUS_SOL, 'codeTypeSousSol'],
            [$parcelle->codeCultureIntermediaire, DaplosReferentialType::ESPECE_BOTANIQUE_D_UNE_CULTURE, 'codeCultureIntermediaire'],
            [$parcelle->codeGestionResidus, DaplosReferentialType::TRAITEMENT_DES_RESIDUS_DE_CULTURE, 'codeGestionResidus'],
        ], $context, $result);

        // FLAG PS (page 22)
        foreach ($parcelle->getSurfaces() as $surface) {
            $this->validateCodes([
                [$surface->typeSurface, DaplosReferentialType::SURFACE_EXPRIMEE, 'typeSurface'],
            ], sprintf('%s, Surface', $context), $result);
        }

        foreach ($parcelle->getHistoriques() as $historique) {
            $this->validateHistorique($historique, $result, $context);
        }

        foreach ($parcelle->getEvenements() as $evenement) {
            $this->validateEvenement($evenement, $result, $context);
        }
    }

    private function validateHistorique(Historique $historique, ValidationResult $result, string $parcelleContext): void
    {
        $context = sprintf('%s, Historique %d', $parcelleContext, $historique->annee ?? 0);

        // FLAG PH (pages 26-27). codeTraitementResidus (déprécié, hors guide) n'est plus
        // contrôlé : la gestion des résidus du guide (68-70) est dans codeGestionResidus.
        $this->validateCodes([
            [$historique->codeEspeceBotanique, DaplosReferentialType::ESPECE_BOTANIQUE_D_UNE_CULTURE, 'codeEspeceBotanique'],
            [$historique->codeQualifiantEspece, DaplosReferentialType::QUALIFIANT_D_UNE_CULTURE, 'codeQualifiantEspece'],
            [$historique->codePeriodeSemis, DaplosReferentialType::PERIODE_DE_SEMIS_D_UNE_CULTURE, 'codePeriodeSemis'],
            [$historique->codeDestination, DaplosReferentialType::DESTINATION_D_UNE_CULTURE, 'codeDestination'],
            [$historique->codeGestionResidus, DaplosReferentialType::TRAITEMENT_DES_RESIDUS_DE_CULTURE, 'codeGestionResidus'],
        ], $context, $result);

        // FLAG HA (page 28)
        foreach ($historique->getAmendements() as $amendement) {
            $this->validateCodes([
                [$amendement->codeAmendement, DaplosReferentialType::AMENDEMENTS_DU_SOL, 'codeAmendement'],
                [$amendement->codeUnite, DaplosReferentialType::UNITE_DE_MESURE, 'codeUnite'],
            ], sprintf('%s, Amendement', $context), $result);
        }
    }

    private function validateEvenement(Evenement $evenement, ValidationResult $result, string $parcelleContext): void
    {
        $context = sprintf('%s, Intervention %s', $parcelleContext, $evenement->refIntervention ?? 'inconnue');

        // FLAG PV (pages 30-33). Le stade en code 127-129 (codification obsolète) n'est
        // pas contrôlé : seul le code BBCH v0.95 (485-494) l'est.
        $this->validateCodes([
            [$evenement->codeCategorieIntervention, DaplosReferentialType::CATEGORIE_D_INTERVENTION, 'codeCategorieIntervention'],
            [$evenement->codeStatutIntervention, DaplosReferentialType::STATUT_D_UNE_INTERVENTION, 'codeStatutIntervention'],
            [$evenement->codeTypeTravail, DaplosReferentialType::INTERVENTION_AGRICOLE, 'codeTypeTravail'],
            [$evenement->codeJustificationIntervention, DaplosReferentialType::JUSTIFICATION_DE_L_INTERVENTION, 'codeJustificationIntervention'],
            [$evenement->codeConditionsMeteo, DaplosReferentialType::CONDITIONS_METEROLOGIQUES, 'codeConditionsMeteo'],
            [$evenement->uniteBouillieViseeHa, DaplosReferentialType::UNITE_DE_MESURE, 'uniteBouillieViseeHa'],
            [$evenement->uniteBouillieEffectiveHa, DaplosReferentialType::UNITE_DE_MESURE, 'uniteBouillieEffectiveHa'],
            [$evenement->codeStadeCultureBBCH, DaplosReferentialType::STADE_VEGETATIF, 'codeStadeCultureBBCH'],
        ], $context, $result);

        // FLAG VB (page 35) : seule la cible v0.95 (50-61) est contrôlée
        foreach ($evenement->getCibles() as $cible) {
            $this->validateCible($cible, $result, $context);
        }

        // FLAG VH (pages 49-50)
        $historiqueDecision = $evenement->getHistoriqueDecision();
        if (null !== $historiqueDecision) {
            $this->validateCodes([
                [$historiqueDecision->codeTypeLien, DaplosReferentialType::NATURE_DU_LIEN, 'codeTypeLien'],
            ], sprintf('%s, Historique décision', $context), $result);
        }

        foreach ($evenement->getIntrants() as $intrant) {
            $this->validateIntrant($intrant, $result, $context);
        }

        foreach ($evenement->getRecoltes() as $recolte) {
            $this->validateRecolte($recolte, $result, $context);
        }
    }

    private function validateCible(CibleEvenement $cible, ValidationResult $result, string $evenementContext): void
    {
        $this->validateCode(
            $cible->codeCibleV095,
            DaplosReferentialType::ORGANISME_VIVANT_CIBLE_OU_AUXILIAIRE,
            'codeCibleV095',
            sprintf('%s, Cible', $evenementContext),
            $result,
        );
    }

    private function validateIntrant(Intrant $intrant, ValidationResult $result, string $evenementContext): void
    {
        $context = sprintf('%s, Intrant %s', $evenementContext, $intrant->designation ?? 'inconnu');
        $qualifiant = DaplosReferentialType::INTRANT_ET_QUALIFIANT_D_INTRANT;
        $unite = DaplosReferentialType::UNITE_DE_MESURE;

        // FLAG VI (pages 36-40). Les codes eau (178-180) et adjuvant (181-183) portent
        // des codes fixes (EAU, ADJ) : ils ne sont pas contrôlés.
        $this->validateCodes([
            [$intrant->codeTypeIntrant, DaplosReferentialType::FAMILLE_D_INTRANT, 'codeTypeIntrant'],
            [$intrant->codeApportOrganique, $qualifiant, 'codeApportOrganique'],
            [$intrant->codeCalcoMagnesien, $qualifiant, 'codeCalcoMagnesien'],
            [$intrant->codeQualifiantIntrant, $qualifiant, 'codeQualifiantIntrant'],
            [$intrant->codeQualifiantEffluent2, $qualifiant, 'codeQualifiantEffluent2'],
            [$intrant->codeQualifiantEffluent3, $qualifiant, 'codeQualifiantEffluent3'],
            [$intrant->codeQualifiantEffluent4, $qualifiant, 'codeQualifiantEffluent4'],
            [$intrant->codeQualifiantEffluent5, $qualifiant, 'codeQualifiantEffluent5'],
            [$intrant->codeQualifiantSemence1, $qualifiant, 'codeQualifiantSemence1'],
            [$intrant->codeQualifiantSemence2, $qualifiant, 'codeQualifiantSemence2'],
            [$intrant->codeQualifiantSemence3, $qualifiant, 'codeQualifiantSemence3'],
            [$intrant->codeUnite, $unite, 'codeUnite'],
            [$intrant->codeUniteQuantiteEffectiveHa, $unite, 'codeUniteQuantiteEffectiveHa'],
            [$intrant->codeUniteDoseHaVisee, $unite, 'codeUniteDoseHaVisee'],
        ], $context, $result);

        // FLAG IC (pages 41-42)
        foreach ($intrant->getCompositions() as $composition) {
            $this->validateCodes([
                [$composition->codeElement, DaplosReferentialType::TENEUR_EN_COMPOSE_CHIMIQUE, 'codeElement'],
            ], sprintf('%s, Composition', $context), $result);
        }

        // FLAG IL (page 43)
        foreach ($intrant->getLots() as $lot) {
            $this->validateCodes([
                [$lot->codeUnite, $unite, 'codeUnite'],
                [$lot->codeUnitePmg, $unite, 'codeUnitePmg'],
            ], sprintf('%s, Lot', $context), $result);
        }
    }

    private function validateRecolte(Recolte $recolte, ValidationResult $result, string $evenementContext): void
    {
        $context = sprintf('%s, Récolte', $evenementContext);
        $unite = DaplosReferentialType::UNITE_DE_MESURE;

        // FLAG VR (pages 45-46)
        $this->validateCodes([
            [$recolte->codeTypeProduitRecolte, DaplosReferentialType::TYPE_DE_PRODUIT_RECOLTE, 'codeTypeProduitRecolte'],
            [$recolte->codeEspeceBotanique, DaplosReferentialType::ESPECE_BOTANIQUE_D_UNE_CULTURE, 'codeEspeceBotanique'],
            [$recolte->destinationProduit, DaplosReferentialType::DESTINATION_D_UNE_CULTURE, 'destinationProduit'],
            [$recolte->codeUnite, $unite, 'codeUnite'],
            [$recolte->codeUniteRendementCalcule, $unite, 'codeUniteRendementCalcule'],
            [$recolte->codeUniteRendementEstime, $unite, 'codeUniteRendementEstime'],
        ], $context, $result);

        // FLAG LC (page 48) : le type de caractéristique (nomenclature Valeur de la
        // caractéristique technique, codes combinés) n'est pas contrôlé, l'unité l'est.
        foreach ($recolte->getCaracterisations() as $caracterisation) {
            $this->validateCodes([
                [$caracterisation->codeUnite, $unite, 'codeUnite'],
            ], sprintf('%s, Caractérisation', $context), $result);
        }
    }

    /**
     * @param list<array{?string, DaplosReferentialType, string}> $codes
     */
    private function validateCodes(array $codes, string $context, ValidationResult $result): void
    {
        foreach ($codes as [$code, $type, $field]) {
            $this->validateCode($code, $type, $field, $context, $result);
        }
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
