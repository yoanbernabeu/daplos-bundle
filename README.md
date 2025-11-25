# DaplosBundle

Bundle Symfony pour l'intégration des référentiels DAPLOS (données agricoles) dans vos applications.

> 🇫🇷 **Note Francophone** : Le code, les commentaires et les entités de ce bundle sont volontairement en **Français**. Ce choix a été fait pour rester strictement aligné avec la terminologie métier utilisée dans les référentiels officiels AgroEDI (DAPLOS) et éviter toute ambiguïté de traduction.
>
> 🇬🇧 **English Note**: The code, comments, and entities in this bundle are intentionally in **French**. This choice was made to strictly align with the business terminology used in the official AgroEDI (DAPLOS) referentials and to avoid any translation ambiguity.

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%208.1-blue)](https://php.net)
[![Symfony Version](https://img.shields.io/badge/Symfony-6.4%20%7C%207.x-green)](https://symfony.com)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

## ✨ Caractéristiques

- 🚀 **Une seule entité** `DaplosReferential` pour tous les référentiels
- 📦 **Enum type-safe** `DaplosReferentialType` pour discriminer les référentiels
- 🔄 **Synchronisation bidirectionnelle** avec l'API DAPLOS (création + mise à jour)
- 🎯 **Requêtes simplifiées** : `findBy(['referentialType' => DaplosReferentialType::CULTURES])`
- 💾 **Gestion mémoire optimisée** : batch processing avec flush périodique
- 🛡️ **Validation automatique** des données avec troncature des valeurs trop longues
- 🏷️ **Table unique** `daplos_referential` avec index composites
- 📊 **Statistiques détaillées** : créations, mises à jour, erreurs
- 🔒 **Transactions** : rollback automatique en cas d'erreur
- ⚡ **Cache intelligent** avec support des tags pour invalidation rapide

## 🚀 Démarrage Rapide (5 minutes)

Intégrez les référentiels DAPLOS (10 000+ items) dans votre application Symfony en 5 commandes :

```bash
# 1. Installation
composer require yoanbernabeu/daplos-bundle

# 2. Configuration (créer config/packages/yoanbernabeu_daplos.yaml)
# Voir section Configuration ci-dessous

# 3. Générer l'entité DaplosReferential
php bin/console daplos:generate:entity

# 4. Créer et appliquer les migrations
php bin/console make:migration
php bin/console doctrine:migrations:migrate

# 5. Synchroniser TOUTES les données depuis l'API DAPLOS 🎉
php -d memory_limit=1G bin/console daplos:sync --all
```

**C'est fait !** Vous avez maintenant accès à 53 référentiels agricoles (10 000+ items) dans une seule table. 🎊

> 💡 **Note** : L'option `-d memory_limit=1G` est recommandée pour la synchronisation de tous les référentiels d'un coup.

---

## ⚠️ Pré-requis d'Accès

> **Important** : L'accès aux référentiels DAPLOS est restreint. Vous devez être membre de l'association **AgroEDI Europe** pour obtenir vos identifiants d'accès (Login + Clé API).
> [Voir la liste des adhérents](https://agroedieurope.fr/les-adherents/)

## 📦 Installation

```bash
composer require yoanbernabeu/daplos-bundle
```

## ⚙️ Configuration

Créez le fichier `config/packages/yoanbernabeu_daplos.yaml` :

```yaml
yoanbernabeu_daplos:
    api:
        login: 'votre_login_daplos'      # 👈 Votre login API
        apikey: 'votre_cle_api_daplos'   # 👈 Votre clé API
    cache:
        enabled: true  # Cache activé (recommandé)
        ttl: 3600      # Durée : 1 heure
    database:          # Optionnel
        schema: null   # Nom du schéma (ex: 'referentiels' pour PostgreSQL)
```

> 💡 **Astuce** : Utilisez des variables d'environnement pour sécuriser vos credentials :
> ```yaml
> api:
>     login: '%env(DAPLOS_LOGIN)%'
>     apikey: '%env(DAPLOS_APIKEY)%'
> ```

---

## 🎯 Utilisation

### Workflow Recommandé

```bash
┌─────────────────────────────────────────────────────────────┐
│ 1️⃣  php bin/console daplos:generate:entity                  │
│    👉 Génère l'entité DaplosReferential et son repository   │
│                                                             │
│ 2️⃣  php bin/console make:migration                          │
│    👉 Crée la migration de base de données                  │
│                                                             │
│ 3️⃣  php bin/console doctrine:migrations:migrate             │
│    👉 Applique la migration                                 │
│                                                             │
│ 4️⃣  php bin/console daplos:sync --all                       │
│    👉 Synchronise tous les référentiels (10 000+ items)     │
└─────────────────────────────────────────────────────────────┘
```

### Génération de l'entité

```bash
# Vérifier le statut de l'entité
php bin/console daplos:generate:entity --check

# Générer l'entité et le repository
php bin/console daplos:generate:entity

# Mode simulation (dry-run)
php bin/console daplos:generate:entity --dry-run

# Générer dans un namespace personnalisé
php bin/console daplos:generate:entity --namespace="App\Domain\Agriculture"

# Générer sans le repository
php bin/console daplos:generate:entity --no-repository

# Forcer la recréation
php bin/console daplos:generate:entity --force
```

**Caractéristiques de l'entité générée :**
- ✅ Table unique `daplos_referential`
- ✅ Index unique composite `(daplos_id, referential_type)`
- ✅ Trait `DaplosReferentialTrait` avec getters/setters
- ✅ Enum `DaplosReferentialType` pour typer les référentiels
- ✅ Repository avec méthodes `findOneByDaplosIdAndType()` et `findByReferentialType()`

**💡 Note** : Cette commande est idempotente. Vous pouvez la relancer sans risque !

---

### 🔄 Synchronisation des Données

**La commande la plus importante** : Synchronisez les données depuis l'API DAPLOS vers votre base

```bash
# Lister tous les types de référentiels disponibles
php bin/console daplos:sync --list

# Synchroniser un référentiel spécifique par son type
php bin/console daplos:sync --type=AMENDEMENTS_DU_SOL

# Synchroniser TOUS les référentiels d'un coup 🚀
php -d memory_limit=1G bin/console daplos:sync --all

# Mode simulation
php bin/console daplos:sync --all --dry-run
```

Cette commande :
- ✅ **Crée** automatiquement les nouvelles entrées du référentiel
- ✅ **Met à jour** les entrées existantes (pas de doublons grâce à l'index unique)
- ✅ **Valide** les données et tronque automatiquement les valeurs trop longues
- ✅ Utilise des **transactions** (rollback automatique en cas d'erreur)
- ✅ **Batch processing** : flush tous les 100 items pour optimiser la mémoire
- ✅ Affiche des **statistiques détaillées** (créés/mis à jour/erreurs)
- ✅ Est **idempotente** (rejouable sans risque)

> ⚠️ **Important** : Pour synchroniser tous les référentiels d'un coup, utilisez l'option `-d memory_limit=1G`.

**Options disponibles :**

- `--list` ou `-l` : Liste tous les types de référentiels disponibles
- `--type=TYPE` ou `-t TYPE` : Synchronise un type spécifique (ex: `AMENDEMENTS_DU_SOL`)
- `--all` ou `-a` : Synchronise tous les référentiels
- `--dry-run` ou `-d` : Mode simulation sans persister les données

**Exemples :**

```bash
# Lister les types disponibles
php bin/console daplos:sync --list

# Synchroniser un type spécifique
php bin/console daplos:sync --type=CULTURES

# Synchroniser tous les types (simulation)
php bin/console daplos:sync --all --dry-run

# Synchroniser tous les types (réel)
php -d memory_limit=1G bin/console daplos:sync --all

# Utiliser une entité personnalisée
php bin/console daplos:sync "App\Domain\DaplosReferential" --type=CULTURES
```

**Résultat (type spécifique) :**

```
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

**Résultat (--all) :**

```
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
│ Caractéristique tech... │ 0       │ 10           │ 10    │
│ ...                     │ ...     │ ...          │ ...   │
└─────────────────────────┴─────────┴──────────────┴───────┘

 Types synchronisés      53
 Total d'items           10000
 Total créés             0
 Total mis à jour        10000
 Erreurs                 0

[OK] Synchronisation globale terminée avec succès !
```

---

## 🔧 Utilisation dans votre code

### L'Enum DaplosReferentialType

Le bundle fournit un Enum PHP `DaplosReferentialType` avec les 53 référentiels :

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

### Requêtes avec le Repository

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

---

## 📚 Commandes Disponibles

### Exploration des référentiels

```bash
# Lister tous les référentiels disponibles (depuis l'API)
php bin/console daplos:referentials:list

# Voir les détails d'un référentiel
php bin/console daplos:referentials:show 611
```

### Génération d'entité

```bash
# Vérifier si l'entité existe
php bin/console daplos:generate:entity --check

# Générer l'entité
php bin/console daplos:generate:entity

# Générer en mode simulation
php bin/console daplos:generate:entity --dry-run

# Forcer la recréation
php bin/console daplos:generate:entity --force
```

### Synchronisation des données

```bash
# Lister les types disponibles
php bin/console daplos:sync --list

# Synchroniser un type spécifique
php bin/console daplos:sync --type=CULTURES

# Synchroniser TOUT
php -d memory_limit=1G bin/console daplos:sync --all

# Mode simulation
php bin/console daplos:sync --all --dry-run
```

---

## ❓ FAQ

### Pourquoi une seule entité au lieu de 53 ?

La v2.0 du bundle adopte une architecture simplifiée :
- **Avant** : 53 traits, 53 entités, 53 tables
- **Maintenant** : 1 trait, 1 entité, 1 table avec un discriminant `referentialType`

**Avantages :**
- Maintenance simplifiée
- Requêtes cross-référentiels possibles
- Enum type-safe pour le typage
- Moins de migrations à gérer

### Pourquoi utiliser `-d memory_limit=1G` ?

Certains référentiels contiennent beaucoup d'items avec des descriptions longues. Pour synchroniser tous les référentiels d'un coup (`--all`), il est recommandé d'augmenter la limite mémoire.

```bash
# ✅ Recommandé pour --all
php -d memory_limit=1G bin/console daplos:sync --all

# ✅ OK pour un type individuel
php bin/console daplos:sync --type=CULTURES
```

### Comment éviter les doublons ?

L'entité utilise un **index unique composite** sur `(daplos_id, referential_type)`. La synchronisation vérifie si cette combinaison existe déjà avant de créer ou mettre à jour.

### Que se passe-t-il si les données API changent ?

Le bundle gère intelligemment les mises à jour :
1. **Nouveaux items** : Créés automatiquement
2. **Items existants** : Mis à jour avec les nouvelles données
3. **Items supprimés** : Restent en base (pas de suppression automatique)

Vous pouvez relancer la synchronisation à tout moment :
```bash
php -d memory_limit=1G bin/console daplos:sync --all
```

### Puis-je personnaliser l'entité générée ?

Oui ! Après génération, vous pouvez modifier l'entité dans `src/Entity/DaplosReferential.php` :

```php
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosReferentialTrait;

class DaplosReferential implements DaplosEntityInterface
{
    use DaplosReferentialTrait;
    
    // Ajoutez vos propres propriétés et méthodes
    private ?string $monChampCustom = null;
}
```

---

## ⚙️ Options Avancées

### Gestion du Cache

Le bundle utilise le système de cache de Symfony avec support des **tags de cache**. Par défaut, les données sont mises en cache pendant 1 heure (3600 secondes).

### Vider le cache manuellement

```php
// Vider le cache d'un référentiel spécifique
$apiClient->clearReferentialCache(611);

// Vider tout le cache (utilise les tags si disponible)
$apiClient->clearAllCache();
```

## 🧪 Tests

Le bundle dispose d'une couverture de tests complète pour les composants critiques :
- ✅ `DaplosApiClient` - Gestion des appels API et du cache
- ✅ `ReferentialSyncService` - Service de synchronisation
- ✅ `EntityGeneratorService` - Service de génération d'entité
- ✅ `ListReferentialsCommand` - Commande de listage des référentiels
- ✅ `ShowReferentialCommand` - Commande d'affichage d'un référentiel
- ✅ `GenerateEntityCommand` - Commande de génération d'entité
- ✅ `SyncReferentialCommand` - Commande de synchronisation des données

```bash
composer test
```

## 🔒 Sécurité

**Note importante** : L'API DAPLOS impose le passage des credentials (login/apikey) en query string dans l'URL. Bien que ce ne soit pas la pratique recommandée, c'est une contrainte imposée par l'API externe qui est hors de notre contrôle.

## 🛠️ Développement du Bundle

### Régénérer l'Enum (mainteneurs uniquement)

Si l'API DAPLOS évolue (nouveaux référentiels), les mainteneurs peuvent régénérer l'Enum :

```bash
# Définir les credentials
export DAPLOS_API_LOGIN="votre_login"
export DAPLOS_API_KEY="votre_cle"

# Régénérer l'Enum
php bin/generate-enum

# Ou en dry-run
php bin/generate-enum --dry-run
```

**Note** : Ce script est un outil de maintenance réservé aux mainteneurs du bundle. Les utilisateurs finaux n'ont pas besoin de l'utiliser car l'Enum est déjà fourni avec le bundle.

#### Exclure des référentiels abandonnés

Pour exclure certains référentiels abandonnés de la génération, créez un fichier `.excluded-referentials.json` à la racine du projet :

```json
{
    "description": "Liste des référentiels à exclure de la génération",
    "ids": [123, 456],
    "names": ["Nom du référentiel abandonné"]
}
```

Vous pouvez également utiliser les options en ligne de commande :

```bash
# Exclure par IDs
php bin/generate-enum --exclude-ids=123,456

# Utiliser un fichier d'exclusion personnalisé
php bin/generate-enum --exclude-file=/path/to/excluded-referentials.json
```

## Dépendances

- PHP >= 8.1
- Symfony 6.4+ ou 7.0+
- Doctrine ORM

## 📝 Licence

[MIT](LICENSE)

## 👤 Auteur

**Yoan Bernabeu** pour SeineYonne


## Support

Pour toute question ou problème, ouvrez une issue sur le dépôt GitHub du projet
