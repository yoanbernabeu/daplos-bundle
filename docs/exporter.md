# Exporter de fichiers DAPLOS

L'exporter génère un fichier à plat DAPLOS v0.95 à partir d'un `DaplosDocument`. Il est symétrique du parser : `parse(export($document))` redonne un document équivalent **tant qu'aucune valeur texte n'a été tronquée** (voir [Troncatures](#troncatures)) et aux limites connues près (voir la fin de cette page).

## Utilisation

```php
use YoanBernabeu\DaplosBundle\DTO\DaplosDocument;
use YoanBernabeu\DaplosBundle\Exporter\Contract\FileExporterInterface;

final class MonService
{
    public function __construct(
        private readonly FileExporterInterface $exporter,
    ) {
    }

    public function exporter(DaplosDocument $document): void
    {
        // Vers une chaîne
        $contenu = $this->exporter->exportToString($document);

        // Ou directement vers un fichier
        $this->exporter->exportToFile($document, '/chemin/export.dap');
    }
}
```

Le service est également accessible via l'alias `yoanbernabeu_daplos.file_exporter`.

## Construire un document

L'application consommatrice construit le `DaplosDocument` depuis ses propres données, en réutilisant les DTO du bundle :

```php
use YoanBernabeu\DaplosBundle\DTO\DaplosDocument;
use YoanBernabeu\DaplosBundle\DTO\Document\DocumentHeader;
use YoanBernabeu\DaplosBundle\DTO\Document\Intervenant;
use YoanBernabeu\DaplosBundle\DTO\Interchange\InterchangeHeader;
use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;
use YoanBernabeu\DaplosBundle\DTO\Parcelle\ParcelleCulturale;

$parcelle = new ParcelleCulturale(
    identifiant: '0001A001',
    annee: 2025,
    codeEspeceBotanique: 'ZDH',
    nom: 'Parcelle du haut',
);
$parcelle->addEvenement(new Evenement(
    identifiantParcelle: '0001A001',
    annee: 2025,
    refIntervention: 'ABCD1234567890ABCD1234567890ABCD',
    codeCategorieIntervention: 'ZG7', // case 48-50 : catégorie d'intervention
    codeTypeTravail: 'SET',           // case 165-167 : intervention agricole
    libelleIntervention: 'Semis blé tendre',
));

$document = new DaplosDocument(
    interchange: new InterchangeHeader(
        identificationEmetteur: '12345678901234',
        identificationDestinataire: '98765432109876',
        nombreDocuments: 1,
    ),
    header: new DocumentHeader(
        referenceDocument: 'DOC-2025-001',
        dateHeureDocument: new \DateTimeImmutable('2025-10-07'),
        versionFormat: '0.95',
        codeFonction: '9',
        nombreFichesParcellaires: 1,
    ),
    intervenants: [
        new Intervenant(typeIntervenant: 'TF', identification: '12345678901234'),
    ],
    parcelles: [$parcelle],
);
```

## Ordre des FLAGS générés

L'exporter émet les lignes dans l'ordre du guide v0.95 :

1. `EI` (enveloppe), `DE` (en-tête), `DA` (intervenants), `DT` (types d'agriculture)
2. Pour chaque parcelle : `DP`, puis `PS` + `SC`, `PC` + `CC`, `PE`, `PH` + `HA`, `PA`
3. Pour chaque intervention : `PV`, puis `VB`, `VH`, `VC`, les intrants (`VI` + `IC`, `IL`, `IA`) et les récoltes (`VR` + `RL`, `LC`)

## Encodage

Les positions du guide DAPLOS sont exprimées en **octets** : l'exporter écrit par défaut en **ISO-8859-1** (1 caractère = 1 octet), l'encodage historique des fichiers DAPLOS, ce qui garantit des positions exactes.

```yaml
yoanbernabeu_daplos:
    exporter:
        encoding: 'ISO-8859-1' # défaut
```

Un encodage `UTF-8` est possible, mais les caractères accentués décalent alors les positions en octets : à réserver aux échanges avec des lecteurs qui tolèrent ce décalage (le parser du bundle le tolère).

## Format des nombres

Comme le demande le guide DAPLOS v0.95 (formats des messages), les valeurs numériques sont cadrées à droite et complétées par des `0` à gauche : `2.2` sur 9 caractères s'écrit `0000002.2`, `200` s'écrit `000000200`. Le signe moins reste en tête (`-005`). Le parser relit aussi les fichiers plus anciens complétés par des espaces.

## Troncatures

L'exporter respecte les largeurs du guide v0.95. Une valeur texte plus longue que son champ (en octets, après conversion en ISO-8859-1) est **coupée et signalée**, jamais coupée en silence. Une valeur numérique trop longue lève toujours une `DaplosExportException`.

Par défaut, l'export n'est pas bloqué : la liste des valeurs coupées lors du **dernier** export est disponible avec `getTruncations()` (interface `TruncationAwareInterface`, implémentée par `DaplosFileExporter`), dans l'ordre du fichier :

```php
use YoanBernabeu\DaplosBundle\Exporter\Contract\TruncationAwareInterface;

$contenu = $this->exporter->exportToString($document);

if ($this->exporter instanceof TruncationAwareInterface) {
    foreach ($this->exporter->getTruncations() as $troncature) {
        // $troncature->flag, ->position, ->length, ->lineNumber,
        // ->value (valeur complète), ->writtenValue (valeur écrite)
        $this->logger->warning($troncature->getMessage());
        // DT 26-45 (ligne 4) : "Agriculture de conservation des sols" tronqué en "Agriculture de conse" (20 octets maximum)
    }
}
```

La liste est remise à zéro à chaque export. Pour refuser tout export incomplet, activez le mode strict : l'export lève alors une `DaplosExportException` qui détaille les troncatures (les dix premières), et `exportToFile()` n'écrit pas le fichier.

```yaml
yoanbernabeu_daplos:
    exporter:
        fail_on_truncation: true # défaut : false
```

### Lecture plus large que l'écriture

Pour ne jamais perdre de données, le parser lit deux zones jusqu'à la fin de la ligne, car certains émetteurs dépassent la largeur du guide :

| FLAG | Champ | Lecture | Écriture (guide) |
|------|-------|---------|------------------|
| DT | Autre type d'agriculture (`TypeAgriculture::libelle`) | 26 → fin de ligne | 26-45 (20) |
| PV | Codes stades de cultures v0.95, BBCH (`Evenement::codeStadeCultureBBCH`) | 485 → fin de ligne | 485-494 (10) |

Ré-exporter un tel fichier coupe ces valeurs à la largeur du guide : la troncature est signalée comme toute autre.

## Limites connues

- Le commentaire d'intervention (`Evenement::commentaire`) est réparti sur les deux zones de 70 caractères du FLAG `PV` (coupure sur un espace). Au-delà, la seconde zone est tronquée et la troncature signalée.
- Les champs marqués `@deprecated` dans les DTO (hors guide v0.95) ne sont pas exportés, pas plus que les champs `ParcelleCulturale::codeJustificationCulture`, `codeUniteSurface` et `codeModeProduction`, absents du FLAG DP du guide.
- Les nombres sont réécrits au format du guide (zéros à gauche, sans zéros inutiles en partie décimale) : `00002.200` relu puis ré-exporté devient `0000002.2`. La valeur est identique, les octets diffèrent.
- Les coordonnées des FLAGS `SC`, `CC` et `VC` (longitude, latitude) sont des champs alphanumériques dans le guide (`an`, p. 21, 23 et 34), mais les DTO les portent en `float` : la valeur numérique est conservée, pas sa forme écrite (zéros, séparateur, format degrés-minutes-secondes WGS84).
