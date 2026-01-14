# Traits et DTOs

Le bundle fournit des traits Doctrine et des DTOs (Data Transfer Objects) pour faciliter l'intégration des données DAPLOS dans vos entités.

## Traits Doctrine

Les traits permettent d'ajouter les propriétés DAPLOS à vos propres entités Doctrine. Chaque trait inclut :
- Les propriétés avec mappings ORM
- Les getters/setters
- Une méthode `hydrateFromDaplos*()` pour peupler depuis un DTO

### DaplosParcelleCulturaleTrait

Pour les entités représentant une parcelle agricole.

```php
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosParcelleCulturaleTrait;

#[ORM\Entity]
class Parcelle
{
    use DaplosParcelleCulturaleTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Vos propriétés métier...
}
```

**Propriétés disponibles :**

| Propriété | Type | Description |
| --------- | ---- | ----------- |
| `daplosIdentifiant` | `string(32)` | Identifiant unique de la parcelle |
| `daplosAnnee` | `int` | Année de campagne |
| `daplosNom` | `string(255)` | Nom de la parcelle |
| `daplosDateCreation` | `DateTimeImmutable` | Date de création |
| `daplosDateDebutCampagne` | `DateTimeImmutable` | Début de campagne |
| `daplosDateFinCampagne` | `DateTimeImmutable` | Fin de campagne |
| `daplosCodeEspeceBotanique` | `string(10)` | Code espèce (référentiel DAPLOS) |
| `daplosCodeVariete` | `string(50)` | Code variété (référentiel DAPLOS) |
| `daplosCodeQualifiantCulture` | `string(10)` | Qualifiant culture |
| `daplosCodeDestinationCulture` | `string(10)` | Destination de la culture |
| `daplosCodePeriodeSemis` | `string(10)` | Période de semis |
| `daplosCodeTypeSol` | `string(10)` | Type de sol |
| `daplosCodeTypeSousSol` | `string(10)` | Type de sous-sol |
| `daplosSurface` | `decimal(10,4)` | Surface |
| `daplosCodeUniteSurface` | `string(10)` | Unité de surface |
| `daplosNumeroIlot` | `int` | Numéro d'îlot PAC |
| `daplosCodeCommune` | `string(10)` | Code INSEE commune |
| `daplosCodeModeProduction` | `string(10)` | Mode de production (bio, etc.) |
| `daplosNumeroRPG` | `string(20)` | Numéro RPG |

**Hydratation depuis un DTO :**

```php
$parcelle = new Parcelle();
$parcelle->hydrateFromDaplosParcelle($dtoFromParser);
```

---

### DaplosEvenementTrait

Pour les entités représentant une intervention/événement cultural.

```php
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosEvenementTrait;

#[ORM\Entity]
class Intervention
{
    use DaplosEvenementTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Parcelle::class)]
    private ?Parcelle $parcelle = null;
}
```

**Propriétés disponibles :**

| Propriété | Type | Description |
| --------- | ---- | ----------- |
| `daplosIdentifiantParcelle` | `string(32)` | Référence à la parcelle |
| `daplosAnnee` | `int` | Année de campagne |
| `daplosRefIntervention` | `string(64)` | UUID unique de l'intervention |
| `daplosCodeIntervention` | `string(10)` | Code type intervention |
| `daplosCodeCategorieIntervention` | `string(10)` | Catégorie d'intervention |
| `daplosLibelleIntervention` | `string(255)` | Libellé de l'intervention |
| `daplosDateDebutIntervention` | `DateTimeImmutable` | Date de début |
| `daplosDateFinIntervention` | `DateTimeImmutable` | Date de fin |
| `daplosCodeStatutIntervention` | `string(10)` | Statut (planifié, réalisé) |
| `daplosCodeJustificationIntervention` | `string(10)` | Justification |
| `daplosCodeStadeVegetatif` | `string(10)` | Stade végétatif |
| `daplosLibelleStadeVegetatif` | `string(100)` | Libellé du stade |
| `daplosCodeConditionsMeteo` | `string(10)` | Conditions météo |
| `daplosCommentaire` | `text` | Commentaire libre |
| `daplosSurfaceTraitee` | `decimal(10,4)` | Surface traitée |

---

### DaplosIntrantTrait

Pour les entités représentant un intrant (produit phyto, semence, engrais...).

```php
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosIntrantTrait;

#[ORM\Entity]
class Intrant
{
    use DaplosIntrantTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Intervention::class)]
    private ?Intervention $intervention = null;
}
```

**Propriétés disponibles :**

| Propriété | Type | Description |
| --------- | ---- | ----------- |
| `daplosIdentifiantParcelle` | `string(32)` | Référence à la parcelle |
| `daplosAnnee` | `int` | Année de campagne |
| `daplosRefIntervention` | `string(64)` | Référence à l'intervention |
| `daplosCodeTypeIntrant` | `string(10)` | Type d'intrant (ZJC, ZIU...) |
| `daplosDesignation` | `string(255)` | Nom commercial |
| `daplosQuantite` | `decimal(12,4)` | Quantité appliquée |
| `daplosCodeUnite` | `string(10)` | Unité de mesure |
| `daplosCodeAMM` | `string(20)` | N° AMM (phytos) |
| `daplosCodeGNIS` | `string(50)` | Code GNIS (semences) |
| `daplosCodeVariete` | `string(50)` | Code variété |
| `daplosCodeApportOrganique` | `string(20)` | Type d'apport organique |
| `daplosCodeEAU` | `string(20)` | Code eau (irrigation) |
| `daplosCodeAdjuvant` | `string(20)` | Code adjuvant |
| `daplosCodeQualifiantIntrant` | `string(10)` | Qualifiant |

**Méthodes utilitaires :**

```php
$intrant->isDaplosPhytosanitaire(); // Produit phytosanitaire ?
$intrant->isDaplosSemence();        // Semence ou plant ?
$intrant->isDaplosEngrais();        // Engrais minéral ?
$intrant->isDaplosIrrigation();     // Irrigation ?
```

---

## DTOs (Data Transfer Objects)

Les DTOs sont des objets immuables (`readonly`) retournés par le parser. Ils représentent les données brutes du fichier DAPLOS.

### Hiérarchie des DTOs

```
DaplosDocument (racine)
├── InterchangeHeader (EI)
├── DocumentHeader (DE)
├── Intervenant[] (DA)
├── TypeAgriculture[] (DT)
└── ParcelleCulturale[] (DP)
    ├── SurfaceParcelle[] (PS)
    ├── Coordonnee[] (SC)
    ├── ParcelleCadastrale[] (PC)
    ├── Engagement[] (PE)
    ├── Historique[] (PH)
    │   └── Amendement[] (HA)
    ├── Analyse[] (PA)
    └── Evenement[] (PV)
        ├── CibleEvenement[] (VB)
        ├── HistoriqueDecision[] (VH)
        ├── Intrant[] (VI)
        │   ├── CompositionFertilisation[] (IC)
        │   ├── LotFabricant[] (IL)
        │   └── AnalyseEffluent[] (IA)
        └── Recolte[] (VR)
            ├── LotRecolte[] (RL)
            └── CaracterisationProduit[] (LC)
```

### DaplosDocument

DTO racine contenant l'ensemble du fichier parsé.

```php
$document = $parser->parseFile('export.dap');

// Métadonnées
$document->getVersion();        // "0.94"
$document->sourceFile;          // Chemin du fichier

// En-têtes
$document->interchange;         // InterchangeHeader
$document->header;              // DocumentHeader

// Données
$document->intervenants;        // Intervenant[]
$document->typesAgriculture;    // TypeAgriculture[]
$document->parcelles;           // ParcelleCulturale[]

// Raccourcis
$document->getExploitant();     // Premier intervenant de type exploitant
$document->countParcelles();    // Nombre de parcelles
$document->countInterventions();// Total des interventions
```

### Intervenant

Représente un acteur (exploitant, fournisseur, mandataire...).

```php
$exploitant = $document->getExploitant();

$exploitant->typeIntervenant;    // "DA1" (exploitant)
$exploitant->identification;     // SIRET
$exploitant->raisonSociale1;     // Nom
$exploitant->adresse;            // Adresse
$exploitant->codePostal;         // Code postal
$exploitant->ville;              // Ville
$exploitant->pays;               // Pays
```

### ParcelleCulturale

Représente une parcelle agricole avec ses données culturales.

```php
foreach ($document->parcelles as $parcelle) {
    $parcelle->identifiant;           // ID unique
    $parcelle->annee;                 // Année campagne
    $parcelle->nom;                   // Nom de la parcelle
    $parcelle->codeEspeceBotanique;   // Code espèce
    $parcelle->codeVariete;           // Code variété
    $parcelle->surface;               // Surface principale

    // Collections
    $parcelle->getSurfaces();         // SurfaceParcelle[]
    $parcelle->getCoordonnees();      // Coordonnee[]
    $parcelle->getEvenements();       // Evenement[]
    $parcelle->getEngagements();      // Engagement[]
    $parcelle->getHistoriques();      // Historique[]
    $parcelle->getAnalyses();         // Analyse[]
}
```

### Evenement

Représente une intervention culturale.

```php
foreach ($parcelle->getEvenements() as $evt) {
    $evt->codeIntervention;           // "ZG7", "ZF7", etc.
    $evt->codeCategorieIntervention;  // Catégorie
    $evt->libelleIntervention;        // "Semis", "Récolte"...
    $evt->dateDebutIntervention;      // DateTimeImmutable
    $evt->dateFinIntervention;        // DateTimeImmutable
    $evt->surfaceTraitee;             // Surface concernée

    // Collections
    $evt->getIntrants();              // Intrant[]
    $evt->getRecoltes();              // Recolte[]
    $evt->getCibles();                // CibleEvenement[]
}
```

### Intrant

Représente un produit utilisé lors d'une intervention.

```php
foreach ($evenement->getIntrants() as $intrant) {
    $intrant->codeTypeIntrant;   // "ZJC" (engrais), "ZIU" (phyto)...
    $intrant->designation;       // Nom commercial
    $intrant->quantite;          // Dose appliquée
    $intrant->codeUnite;         // Unité
    $intrant->codeAMM;           // N° AMM pour phytos

    // Collections
    $intrant->getCompositions(); // CompositionFertilisation[]
    $intrant->getLots();         // LotFabricant[]
}
```

**Types d'intrants courants :**

| Code | Description |
| ---- | ----------- |
| `ZJC` | Engrais minéral |
| `ZJD` | Apport organique |
| `ZJE` | Irrigation |
| `ZJF` | Semences |
| `ZJT` | Plants |
| `ZIU` | Herbicide |
| `ZIV` | Fongicide |
| `ZIW` | Insecticide |
| `ZIX` | Régulateur |
| `ZIY` | Molluscicide |
| `ZIZ` | Autre phyto |

---

## Exemple complet d'intégration

```php
use YoanBernabeu\DaplosBundle\Parser\Contract\FileParserInterface;

class ImportService
{
    public function __construct(
        private FileParserInterface $parser,
        private EntityManagerInterface $em,
    ) {}

    public function importFile(string $filePath): void
    {
        $document = $this->parser->parseFile($filePath);

        foreach ($document->parcelles as $dtoParc) {
            // Créer ou retrouver la parcelle
            $parcelle = new Parcelle();
            $parcelle->hydrateFromDaplosParcelle($dtoParc);

            foreach ($dtoParc->getEvenements() as $dtoEvt) {
                $intervention = new Intervention();
                $intervention->hydrateFromDaplosEvenement($dtoEvt);
                $intervention->setParcelle($parcelle);

                foreach ($dtoEvt->getIntrants() as $dtoInt) {
                    $intrant = new Intrant();
                    $intrant->hydrateFromDaplosIntrant($dtoInt);
                    $intrant->setIntervention($intervention);

                    $this->em->persist($intrant);
                }

                $this->em->persist($intervention);
            }

            $this->em->persist($parcelle);
        }

        $this->em->flush();
    }
}
```
