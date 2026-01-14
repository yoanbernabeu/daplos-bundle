# Synchronisation des Référentiels DAPLOS

La commande `daplos:sync` permet de synchroniser les données depuis l'API DAPLOS vers votre base de données.

## Commandes

```bash
# Lister tous les types de référentiels disponibles
php bin/console daplos:sync --list

# Synchroniser un référentiel spécifique par son type
php bin/console daplos:sync --type=AMENDEMENTS_DU_SOL

# Synchroniser TOUS les référentiels d'un coup
php -d memory_limit=1G bin/console daplos:sync --all

# Mode simulation (dry-run)
php bin/console daplos:sync --all --dry-run
```

## Options disponibles

| Option | Alias | Description |
|--------|-------|-------------|
| `--list` | `-l` | Liste tous les types de référentiels disponibles |
| `--type=TYPE` | `-t` | Synchronise un type spécifique (ex: `CULTURES`) |
| `--all` | `-a` | Synchronise tous les référentiels |
| `--dry-run` | `-d` | Mode simulation sans persister les données |

## Fonctionnalités

- **Création automatique** des nouvelles entrées
- **Mise à jour** des entrées existantes (pas de doublons grâce à l'index unique)
- **Validation** des données avec troncature automatique des valeurs trop longues
- **Transactions** avec rollback automatique en cas d'erreur
- **Batch processing** : flush tous les 100 items pour optimiser la mémoire
- **Statistiques détaillées** (créés/mis à jour/erreurs)
- **Idempotente** : rejouable sans risque

## Exemple de résultat

### Type spécifique

```text
Synchronisation des référentiels DAPLOS
========================================

Synchronisation : Amendements du sol
------------------------------------

 Type             AMENDEMENTS_DU_SOL
 ID API           633
 Repository Code  List_SpecifiedSoilSupplement_CodeType

Résultats de la synchronisation
--------------------------------

 Total d'items traités    3
 Créés                    0 (0%)
 Mis à jour               3 (100%)

[OK] Synchronisation terminée avec succès !
```

### Tous les référentiels (--all)

```text
Synchronisation des référentiels DAPLOS
========================================

Synchronisation de tous les référentiels
----------------------------------------
53 types de référentiels à synchroniser

 100/100 [============================] 100%

Résumé de la synchronisation
----------------------------
┌─────────────────────────┬─────────┬──────────────┬───────┐
│ Type                    │ Créés   │ Mis à jour   │ Total │
├─────────────────────────┼─────────┼──────────────┼───────┤
│ Amendements du sol      │ 0       │ 3            │ 3     │
│ Cultures                │ 0       │ 150          │ 150   │
│ ...                     │ ...     │ ...          │ ...   │
└─────────────────────────┴─────────┴──────────────┴───────┘

 Types synchronisés      53
 Total d'items           10000
 Total créés             0
 Total mis à jour        10000
 Erreurs                 0

[OK] Synchronisation globale terminée avec succès !
```

## Gestion mémoire

Pour synchroniser tous les référentiels, augmentez la limite mémoire :

```bash
php -d memory_limit=1G bin/console daplos:sync --all
```

Pour un type individuel, la limite par défaut suffit généralement.
