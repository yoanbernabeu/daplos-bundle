# Exporter de fichiers DAPLOS

L'exporter génère un fichier à plat DAPLOS v0.95 à partir d'un `DaplosDocument`. Il est symétrique du parser : `parse(export($document))` redonne un document équivalent.

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
    codeIntervention: 'ZG7',
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

## Limites connues

- Le commentaire d'intervention (`Evenement::commentaire`) est réparti sur les deux zones de 70 caractères du FLAG `PV` (coupure sur un espace). Au-delà de 141 caractères, il est tronqué.
- Les champs marqués `@deprecated` dans les DTO (hors guide v0.95) ne sont pas exportés.
- Les valeurs texte trop longues pour leur champ sont tronquées ; les valeurs numériques trop longues lèvent une `DaplosExportException`.
