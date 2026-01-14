# Parser de Fichiers DAPLOS (.dap)

Le bundle inclut un parser complet pour les fichiers d'export DAPLOS au format `.dap`. Ce format propriétaire d'AgroEDI Europe permet d'exporter les données de parcellaire cultural (parcelles, interventions, intrants, récoltes).

## Commande de parsing

```bash
# Parser un fichier et afficher le résumé
php bin/console daplos:parse /chemin/vers/fichier.dap

# Afficher les parcelles en détail
php bin/console daplos:parse fichier.dap --parcelles

# Afficher les interventions
php bin/console daplos:parse fichier.dap --interventions

# Export JSON
php bin/console daplos:parse fichier.dap --format=json

# Résumé uniquement
php bin/console daplos:parse fichier.dap --summary
```

## Options

| Option | Alias | Description |
|--------|-------|-------------|
| `--format` | `-f` | Format de sortie : `table` (défaut) ou `json` |
| `--summary` | `-s` | Afficher uniquement le résumé |
| `--parcelles` | `-p` | Afficher les détails des parcelles |
| `--interventions` | `-i` | Afficher les détails des interventions |

## Exemple de sortie

```text
Parsing du fichier DAPLOS
=========================

 Fichier : /chemin/vers/export.dap

Résumé
------

 ------------------------ ----------------------------
  Propriété                Valeur
 ------------------------ ----------------------------
  Version DAPLOS           0.94
  Nombre de parcelles      12
  Nombre d'interventions   45
  Exploitant               EARL LA FERME DE FOOBAR
  SIRET                    12345678900012
  Commune                  12345 EXEMPLE-VILLE
 ------------------------ ----------------------------

Parcelles
---------

 -------- --------------------- -------- ------- ----------- ---------------
  ID       Nom                   Espèce   Année   Surface     Interventions
 -------- --------------------- -------- ------- ----------- ---------------
  000001   Les Grands Champs     ZBE      2025    5.58 A17    4
  000002   La Prairie Nord       ZAR      2025    2.40 A17    3
  ...
 -------- --------------------- -------- ------- ----------- ---------------
```

## Utilisation programmatique

### Injection du service

```php
use YoanBernabeu\DaplosBundle\Parser\Contract\FileParserInterface;

class MonService
{
    public function __construct(
        private FileParserInterface $parser
    ) {}

    public function traiterFichier(string $filePath): void
    {
        $document = $this->parser->parseFile($filePath);

        // Accès aux données
        echo $document->getVersion();           // "0.94"
        echo $document->countParcelles();       // 12
        echo $document->countInterventions();   // 45

        // Exploitant
        $exploitant = $document->getExploitant();
        echo $exploitant->raisonSociale1;       // "EARL LA FERME DE FOOBAR"
        echo $exploitant->identification;       // "12345678900012"

        // Parcelles
        foreach ($document->parcelles as $parcelle) {
            echo $parcelle->identifiant;
            echo $parcelle->nom;
            echo $parcelle->codeEspeceBotanique;
            echo $parcelle->annee;

            // Surfaces
            foreach ($parcelle->getSurfaces() as $surface) {
                echo $surface->typeSurface;     // "A17"
                echo $surface->surface;         // 5.58
            }

            // Interventions
            foreach ($parcelle->getEvenements() as $evenement) {
                echo $evenement->codeIntervention;
                echo $evenement->libelleIntervention;
                echo $evenement->dateDebutIntervention?->format('d/m/Y');

                // Intrants
                foreach ($evenement->getIntrants() as $intrant) {
                    echo $intrant->codeIntrant;
                    echo $intrant->libelleIntrant;
                    echo $intrant->dose;
                }
            }
        }
    }
}
```

### Parser une chaîne de caractères

```php
$content = file_get_contents('fichier.dap');
$document = $this->parser->parseString($content);
```

## Structure des données

### DaplosDocument (racine)

```php
$document->interchange;      // En-tête interchange (EI)
$document->header;           // En-tête document (DE)
$document->intervenants;     // Liste des intervenants (DA)
$document->typesAgriculture; // Types d'agriculture (DT)
$document->parcelles;        // Liste des parcelles (DP)
$document->sourceFile;       // Chemin du fichier source
```

### ParcelleCulturale

```php
$parcelle->identifiant;
$parcelle->annee;
$parcelle->nom;
$parcelle->codeEspeceBotanique;
$parcelle->codeVariete;
$parcelle->getSurfaces();           // Surfaces (PS)
$parcelle->getCoordonnees();        // Coordonnées (SC)
$parcelle->getParcellesCadastrales(); // Parcelles cadastrales (PC)
$parcelle->getEngagements();        // Engagements (PE)
$parcelle->getHistoriques();        // Historique (PH)
$parcelle->getAnalyses();           // Analyses (PA)
$parcelle->getEvenements();         // Interventions (PV)
```

### Evenement (Intervention)

```php
$evenement->codeIntervention;
$evenement->codeCategorieIntervention;
$evenement->libelleIntervention;
$evenement->dateDebutIntervention;
$evenement->dateFinIntervention;
$evenement->surfaceTraitee;
$evenement->getIntrants();          // Intrants (VI)
$evenement->getRecoltes();          // Récoltes (VR)
$evenement->getCibles();            // Cibles (VB)
```

## FLAGS supportés

Le parser gère 24 types de lignes (FLAGS) :

| FLAG | Description |
|------|-------------|
| EI | Enveloppe Interchange |
| DE | En-tête Document |
| DA | Intervenant (exploitant, fournisseur) |
| DT | Type d'Agriculture |
| DP | Parcelle Culturale |
| PS | Surface Parcelle |
| SC | Coordonnées Surface |
| PC | Parcelle Cadastrale |
| CC | Coordonnées Cadastrales |
| PE | Engagement |
| PH | Historique Parcelle |
| PA | Analyse Parcelle |
| HA | Amendement/Résidus |
| PV | Événement/Intervention |
| VB | Cible d'Événement |
| VH | Historique Décision |
| VC | Coordonnées Intervention |
| VI | Intrant |
| IC | Composition Fertilisation |
| IL | Lot Fabricant |
| IA | Analyse Effluent |
| VR | Récolte |
| RL | Lot Récolte |
| LC | Caractérisation Produit |

## Gestion de l'encodage

Les fichiers DAPLOS sont généralement encodés en **ISO-8859-1** (Latin-1). Le parser gère automatiquement :

- Détection de l'encodage (UTF-8, ISO-8859-1, ISO-8859-15, Windows-1252)
- Préservation des positions fixes (les fichiers DAPLOS utilisent des colonnes fixes en octets)
- Conversion UTF-8 des valeurs extraites uniquement

## Configuration

```yaml
yoanbernabeu_daplos:
    parser:
        encoding: auto           # auto (défaut), UTF-8, ISO-8859-1
        ignore_unknown_flags: false  # Ignorer les FLAGS inconnus
```

## Gestion des erreurs

```php
use YoanBernabeu\DaplosBundle\Parser\Exception\DaplosParseException;
use YoanBernabeu\DaplosBundle\Parser\Exception\InvalidFlagException;

try {
    $document = $this->parser->parseFile($filePath);
} catch (InvalidFlagException $e) {
    // FLAG inconnu dans le fichier
    echo "FLAG invalide: " . $e->getMessage();
    echo "Ligne " . $e->getLineNumber() . ": " . $e->getLineContent();
} catch (DaplosParseException $e) {
    // Autre erreur de parsing
    echo "Erreur: " . $e->getMessage();
}
```
