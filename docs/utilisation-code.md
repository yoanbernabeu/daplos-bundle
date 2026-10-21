# Utilisation dans votre Code

## L'Enum DaplosReferentialType

Le bundle fournit un Enum PHP avec les 53 référentiels :

```php
use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;

// Accéder aux métadonnées d'un type
$type = DaplosReferentialType::AMENDEMENTS_DU_SOL;
echo $type->getId();            // 633
echo $type->getLabel();         // "Amendements du sol"
echo $type->getRepositoryCode(); // "List_SpecifiedSoilSupplement_CodeType"

// Trouver un type par ID
$type = DaplosReferentialType::fromId(633);

// Trouver un type par code repository
$type = DaplosReferentialType::fromRepositoryCode('List_SpecifiedSoilSupplement_CodeType');

// Lister tous les types
foreach (DaplosReferentialType::cases() as $type) {
    echo $type->getLabel();
}
```

## Requêtes avec le Repository

```php
use App\Repository\DaplosReferentialRepository;
use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;

class MonService
{
    public function __construct(
        private DaplosReferentialRepository $repository
    ) {}

    public function exemple(): void
    {
        // Trouver un item par son ID DAPLOS et son type
        $item = $this->repository->findOneByDaplosIdAndType(
            daplosId: 123,
            type: DaplosReferentialType::CULTURES
        );

        // Trouver tous les items d'un type
        $cultures = $this->repository->findByReferentialType(
            DaplosReferentialType::CULTURES
        );

        // Requête personnalisée avec QueryBuilder
        $qb = $this->repository->createQueryBuilder('r')
            ->where('r.referentialType = :type')
            ->andWhere('r.daplosTitle LIKE :search')
            ->setParameter('type', DaplosReferentialType::CULTURES)
            ->setParameter('search', '%blé%');
    }
}
```

## Gestion du Cache

Le bundle utilise le système de cache Symfony avec support des tags.

```php
// Vider le cache d'un référentiel spécifique
$apiClient->clearReferentialCache(611);

// Vider tout le cache
$apiClient->clearAllCache();
```

## Valider les codes d'un document

Le validateur `StrictReferentialValidator` (alias `ReferentialValidatorInterface`, `yoanbernabeu_daplos.validator`) vérifie que chaque code d'un `DaplosDocument` existe dans le référentiel synchronisé (table de l'entité `DaplosReferential`), avec la nomenclature indiquée par le guide DAPLOS v0.95. Il **signale**, il ne bloque pas : le résultat liste des `ValidationError` (code, nomenclature, champ, contexte).

```php
use YoanBernabeu\DaplosBundle\Validator\ReferentialValidatorInterface;

$validator->setEntityClass(DaplosReferential::class);
$resultat = $validator->validate($document);

if (!$resultat->isValid()) {
    foreach ($resultat->getErrorMessages() as $message) {
        // Code "ZHK" non trouvé dans le référentiel "Unité de mesure" pour le champ "codeUniteRendement" (...)
    }
}
```

### Champs contrôlés

| FLAG | Positions | Champ du DTO | Nomenclature |
|------|-----------|--------------|--------------|
| DP | 47-49 | `codeEspeceBotanique` | Espèce botanique d'une culture |
| DP | 85-87 | `codeQualifiantCulture` | Qualifiant d'une culture |
| DP | 88-90 | `codePeriodeSemis` | Période de semis d'une culture |
| DP | 91-93 | `codeDestinationCulture` | Destination d'une culture |
| DP | 103-105 | `codeUniteRendement` | Unité de mesure |
| DP | 173-175 | `codeTypeSol` | Type de sol |
| DP | 217-219 | `codeTypeSousSol` | Type de sous-sol |
| DP | 220-222 | `codeCultureIntermediaire` | Espèce botanique d'une culture |
| DP | 230-232 | `codeGestionResidus` | Traitement des résidus de culture |
| PS | 15-17 | `typeSurface` | Surface exprimée |
| PH | 21-23 | `codeEspeceBotanique` | Espèce botanique d'une culture |
| PH | 59-61 | `codeQualifiantEspece` | Qualifiant d'une culture |
| PH | 62-64 | `codePeriodeSemis` | Période de semis d'une culture |
| PH | 65-67 | `codeDestination` | Destination d'une culture |
| PH | 68-70 | `codeGestionResidus` | Traitement des résidus de culture |
| HA | 15-17 | `codeAmendement` | Amendements du sol |
| HA | 70-72 | `codeUnite` | Unité de mesure |
| PV | 48-50 | `codeCategorieIntervention` | Catégorie d'intervention |
| PV | 51-53 | `codeStatutIntervention` | Statut d'une intervention |
| PV | 165-167 | `codeTypeTravail` | Intervention agricole |
| PV | 203-205 | `codeJustificationIntervention` | Justification de l'intervention |
| PV | 299-301 | `codeConditionsMeteo` | Conditions météorologiques |
| PV | 321-323, 333-335 | `uniteBouillieViseeHa`, `uniteBouillieEffectiveHa` | Unité de mesure |
| PV | 485-494 | `codeStadeCultureBBCH` | Stade végétatif |
| VB | 50-61 | `codeCibleV095` | Organisme vivant (cible ou auxiliaire) |
| VH | 47-49 | `codeTypeLien` | Nature du lien |
| VI | 47-49 | `codeTypeIntrant` | Famille d'intrant |
| VI | 175-177, 184-186 | `codeApportOrganique`, `codeCalcoMagnesien` | Intrant et qualifiant d'intrant |
| VI | 187-201 | `codeQualifiantIntrant`, `codeQualifiantEffluent2` à `5` | Intrant et qualifiant d'intrant |
| VI | 202-210 | `codeQualifiantSemence1` à `3` | Intrant et qualifiant d'intrant |
| VI | 220-222, 232-234, 244-246 | `codeUnite`, `codeUniteQuantiteEffectiveHa`, `codeUniteDoseHaVisee` | Unité de mesure |
| IC | 47-49 | `codeElement` | Teneur en composé chimique |
| IL | 126-128, 138-140 | `codeUnite`, `codeUnitePmg` | Unité de mesure |
| VR | 47-49 | `codeTypeProduitRecolte` | Type de produit récolté |
| VR | 50-52 | `codeEspeceBotanique` | Espèce botanique d'une culture |
| VR | 88-90 | `destinationProduit` | Destination d'une culture |
| VR | 100-102, 112-114, 124-126 | `codeUnite`, `codeUniteRendementCalcule`, `codeUniteRendementEstime` | Unité de mesure |
| LC | 59-61 | `codeUnite` | Unité de mesure |

### Champs non contrôlés

- Codifications obsolètes du guide : stade en code PV 127-129 (remplacé par le BBCH 485-494), cible v0.94 VB 47-49 (remplacée par la cible v0.95 50-61).
- Codes « combinés au code TPA » de la nomenclature Valeur de la caractéristique technique : DT 3-5, PE 15-17, DP 211-213 et 214-216, LC 47-49.
- Codes fixes ou externes : code eau (`EAU`) et adjuvant (`ADJ`) du VI, codes GNIS, AMM, INSEE, SIRET.
- Champs du DTO `ParcelleCulturale` absents du FLAG DP du guide v0.95 (`codeJustificationCulture`, `codeUniteSurface`, `codeModeProduction`) et champ déprécié `Historique::codeTraitementResidus` : le parser ne les remplit jamais.
