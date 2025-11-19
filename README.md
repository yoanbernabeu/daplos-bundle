# DaplosBundle

Bundle Symfony pour l'intégration des référentiels DAPLOS (données agricoles) dans vos applications.

> 🇫🇷 **Note Francophone** : Le code, les commentaires et les entités de ce bundle sont volontairement en **Français**. Ce choix a été fait pour rester strictement aligné avec la terminologie métier utilisée dans les référentiels officiels AgroEDI (DAPLOS) et éviter toute ambiguïté de traduction.
>
> 🇬🇧 **English Note**: The code, comments, and entities in this bundle are intentionally in **French**. This choice was made to strictly align with the business terminology used in the official AgroEDI (DAPLOS) referentials and to avoid any translation ambiguity.

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%208.1-blue)](https://php.net)
[![Symfony Version](https://img.shields.io/badge/Symfony-6.4%20%7C%207.x-green)](https://symfony.com)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

## ✨ Caractéristiques

- 🚀 **Génération automatique** de 57 entités Doctrine prêtes à l'emploi
- 📦 **Synchronisation bidirectionnelle** avec l'API DAPLOS (création + mise à jour)
- 🔄 **Idempotence** : rejouez les synchronisations sans risque de doublons
- 🎯 **Détection intelligente** des mises à jour via attribut `#[DaplosId]`
- 💾 **Gestion mémoire optimisée** : batch processing avec flush périodique
- 🛡️ **Validation automatique** des données avec troncature des valeurs trop longues
- 🏷️ **Préfixe `daplos_`** appliqué automatiquement aux tables
- 📊 **Statistiques détaillées** : créations, mises à jour, erreurs
- 🔒 **Transactions** : rollback automatique en cas d'erreur
- ⚡ **Cache intelligent** avec support des tags pour invalidation rapide

## 🚀 Démarrage Rapide (5 minutes)

Intégrez 57 référentiels agricoles DAPLOS (10 000+ items) dans votre application Symfony en 5 commandes :

```bash
# 1. Installation
composer require yoanbernabeu/daplos-bundle

# 2. Configuration (créer config/packages/yoanbernabeu_daplos.yaml)
# Voir section Configuration ci-dessous

# 3. Générer TOUTES les entités automatiquement
php bin/console daplos:generate:entity --all

# 4. Créer et appliquer les migrations
php bin/console make:migration
php bin/console doctrine:migrations:migrate

# 5. Synchroniser TOUTES les données depuis l'API DAPLOS 🎉
php -d memory_limit=1G bin/console daplos:sync --all
```

**C'est fait !** Vous avez maintenant accès à 57 référentiels agricoles (10 000+ items) dans votre base de données. 🎊

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
│ 1️⃣  php bin/console daplos:generate:entity --all            │
│    👉 Génère 57 entités Doctrine automatiquement            │
│                                                             │
│ 2️⃣  php bin/console make:migration                          │
│    👉 Crée les migrations de base de données                │
│                                                             │
│ 3️⃣  php bin/console doctrine:migrations:migrate             │
│    👉 Applique les migrations                               │
│                                                             │
│ 4️⃣  php bin/console daplos:sync --all                       │
│    👉 Synchronise toutes les données (15 000+ items)        │
└─────────────────────────────────────────────────────────────┘
```

### Option A : Génération Automatique (recommandé ⭐)

La méthode la plus rapide et simple !

```bash
php bin/console daplos:generate:entity --check
```

Vérifie le statut des entités DAPLOS dans votre projet (quelles entités existent, lesquelles manquent).

```bash
php bin/console daplos:generate:entity --all
```

Génère automatiquement toutes les entités et leurs repositories pour tous les référentiels DAPLOS.

**Caractéristiques des entités générées :**
- ✅ Tables préfixées automatiquement avec `daplos_` (ex: `daplos_cultures`)
- ✅ Attribut `#[DaplosId]` pour la détection des doublons
- ✅ Traits réutilisables avec getters/setters
- ✅ Documentation PHPDoc complète
- ✅ Repositories avec méthode `findOneByDaplosId()`

Options :
- `--check` : Vérifier le statut des entités sans les générer
- `--all` : Générer toutes les entités pour tous les référentiels
- `--namespace=NAMESPACE` : Namespace personnalisé (défaut: `App\Entity\Daplos`)
- `--no-repository` : Ne pas générer les repositories
- `--dry-run` : Simule la génération sans créer les fichiers
- `--force` : Force la recréation des entités existantes (⚠️ écrase les fichiers)

Exemples :
```bash
# Vérifier le statut
php bin/console daplos:generate:entity --check

# Générer toutes les entités (dry-run)
php bin/console daplos:generate:entity --all --dry-run

# Générer dans un namespace personnalisé
php bin/console daplos:generate:entity --all --namespace="App\Domain\Agriculture"

# Générer sans les repositories
php bin/console daplos:generate:entity --all --no-repository

# Forcer la recréation
php bin/console daplos:generate:entity --all --force
```

**💡 Note** : Cette commande est idempotente. Vous pouvez la relancer sans risque !

### Option B : Personnalisation avec les Traits (avancé)

Si vous avez besoin de **personnaliser vos entités**, le bundle fournit **57 traits** prêts à l'emploi dans `src/Entity/Trait/`.

Consultez la commande `php bin/console daplos:referentials:list` pour voir tous les traits disponibles.

---

### 🔄 Synchronisation des Données

**La commande la plus importante** : Synchronisez les données depuis l'API DAPLOS vers votre base

```bash
# Synchroniser un référentiel spécifique
php bin/console daplos:sync "App\Entity\Daplos\Cultures" 611

# Synchroniser TOUTES les entités générées d'un coup 🚀
php -d memory_limit=1G bin/console daplos:sync --all
```

Cette commande :
- ✅ **Crée** automatiquement les nouvelles entrées du référentiel
- ✅ **Met à jour** les entrées existantes (pas de doublons grâce à `#[DaplosId]`)
- ✅ **Valide** les données et tronque automatiquement les valeurs trop longues
- ✅ Utilise des **transactions** (rollback automatique en cas d'erreur)
- ✅ **Batch processing** : flush tous les 100 items pour optimiser la mémoire
- ✅ Affiche des **statistiques détaillées** (créés/mis à jour/erreurs)
- ✅ Est **idempotente** (rejouable sans risque)
- ✅ Peut synchroniser **toutes les entités d'un coup** avec `--all`

> ⚠️ **Important** : Pour synchroniser tous les référentiels d'un coup, utilisez l'option `-d memory_limit=1G` pour éviter les erreurs de mémoire (référentiel `StadedelacultureBBCH` contient ~3800 items).

Options disponibles :

- `--all` ou `-a` : Synchronise toutes les entités générées disponibles
- `--namespace` : Namespace des entités à synchroniser (utilisé avec --all, défaut: `App\Entity\Daplos`)
- `--dry-run` ou `-d` : Mode simulation sans persister les données
- `--show-details` ou `-s` : Affiche des détails supplémentaires sur le référentiel

**Exemples :**

```bash
# Synchronisation d'un référentiel spécifique
php bin/console daplos:sync "App\Entity\Daplos\Cultures" 611

# Synchroniser TOUTES les entités générées (recommandé !)
php -d memory_limit=1G bin/console daplos:sync --all

# Synchroniser toutes les entités en mode simulation
php bin/console daplos:sync --all --dry-run

# Synchroniser toutes les entités avec détails
php -d memory_limit=1G bin/console daplos:sync --all --show-details

# Mode simulation pour un référentiel spécifique
php bin/console daplos:sync "App\Entity\Daplos\Cultures" 611 --dry-run

# Avec détails supplémentaires
php bin/console daplos:sync "App\Entity\Daplos\Cultures" 611 --show-details

# Synchroniser dans un namespace personnalisé
php -d memory_limit=1G bin/console daplos:sync --all --namespace="App\Domain\Agriculture"
```

**Résultat (référentiel unique) :**

```
Synchronisation des référentiels DAPLOS
========================================

Configuration de la synchronisation
------------------------------------

 Entité             App\Entity\Daplos\Culture
 Référentiel ID     611
 Mode               Synchronisation réelle

Synchronisation en cours...
 100/100 [============================] 100%

Résultats de la synchronisation
--------------------------------

 Total d'items traités    100
 Créées                   30 (30%)
 Mises à jour             70 (70%)

  Créées       : ███████████████ 30%
  Mises à jour : ████████████████████████████████████ 70%

[OK] Synchronisation terminée avec succès !
```

**Résultat (--all) :**

```
Synchronisation des référentiels DAPLOS
========================================

Recherche des entités à synchroniser...
------------------------------------
Trouvé 57 entité(s) à synchroniser dans App\Entity\Daplos

Voulez-vous continuer avec la synchronisation ? (yes/no) [yes]:
> yes

Synchronisation : Cultures (ID: 611)
------------------------------------
[OK] Cultures : 200 créées, 516 mises à jour sur 716 items

Synchronisation : Amendements (ID: 633)
------------------------------------
[OK] Amendements : 0 créées, 3 mises à jour sur 3 items

[... autres entités ...]

Résumé de la synchronisation
----------------------------
┌───────────────┬───────────────┬─────────┬──────────────┬───────┐
│ Entité        │ Référentiel   │ Créées  │ Mises à jour │ Total │
├───────────────┼───────────────┼─────────┼──────────────┼───────┤
│ Cultures      │ Cultures      │ 200     │ 516          │ 716   │
│ Amendements   │ Amendements   │ 0       │ 3            │ 3     │
[... autres lignes ...]
└───────────────┴───────────────┴─────────┴──────────────┴───────┘

 Total d'entités synchronisées    57
 Total d'items traités             15000
 Total créées                      5000
 Total mises à jour                10000
 Erreurs                           0

[OK] Synchronisation globale terminée avec succès !
```

**Prérequis :**

1. L'entité doit exister et être correctement configurée
2. L'entité doit implémenter `DaplosEntityInterface` OU utiliser l'attribut `#[DaplosId]` (automatique avec la génération)
3. La table de l'entité doit exister en base de données (migrations appliquées)

**Comment ça marche ?**

1. **Détection des doublons** : Le système utilise l'attribut `#[DaplosId]` pour identifier les entités existantes
2. **Création intelligente** : Si l'ID DAPLOS n'existe pas en base → création d'une nouvelle entrée
3. **Mise à jour automatique** : Si l'ID DAPLOS existe déjà → mise à jour de l'entrée existante
4. **Validation des données** : Les valeurs trop longues sont automatiquement tronquées selon la définition Doctrine
5. **Transactions sécurisées** : En cas d'erreur, toutes les modifications sont annulées (rollback)

**Workflow complet recommandé :**

```bash
# 1. Lister les référentiels disponibles
php bin/console daplos:referentials:list

# 2. Générer toutes les entités
php bin/console daplos:generate:entity --all

# 3. Créer les migrations
php bin/console make:migration

# 4. Appliquer les migrations
php bin/console doctrine:migrations:migrate

# 5. Synchroniser TOUTES les données (simulation)
php bin/console daplos:sync --all --dry-run

# 6. Synchroniser TOUTES les données (réel) 🚀
php bin/console daplos:sync --all
```

---

## 📚 Commandes Disponibles

### Exploration des référentiels

```bash
# Lister tous les référentiels disponibles
php bin/console daplos:referentials:list

# Voir les détails d'un référentiel
php bin/console daplos:referentials:show 611
```

### Génération d'entités

```bash
# Vérifier quelles entités existent
php bin/console daplos:generate:entity --check

# Générer toutes les entités
php bin/console daplos:generate:entity --all

# Générer en mode simulation
php bin/console daplos:generate:entity --all --dry-run
```

### Synchronisation des données

```bash
# Synchroniser TOUT
php bin/console daplos:sync --all

# Synchroniser un référentiel spécifique
php bin/console daplos:sync "App\Entity\Daplos\Cultures" 611

# Modes utiles
php bin/console daplos:sync --all --dry-run        # Simulation
php -d memory_limit=1G bin/console daplos:sync --all --show-details   # Avec détails
```

---

## ❓ FAQ

### Pourquoi utiliser `-d memory_limit=1G` ?

Le référentiel `StadedelacultureBBCH` contient ~3800 items avec des descriptions longues. Pour synchroniser tous les référentiels d'un coup (`--all`), il est recommandé d'augmenter la limite mémoire.

```bash
# ✅ Recommandé pour --all
php -d memory_limit=1G bin/console daplos:sync --all

# ✅ OK pour un référentiel individuel
php bin/console daplos:sync "App\Entity\Daplos\Cultures" 611
```

### Comment éviter les doublons ?

Le système utilise l'attribut `#[DaplosId]` pour identifier les entités existantes. Chaque entité a :
- Un `id` auto-incrémenté (clé primaire Doctrine)
- Un `xxxId` (ID DAPLOS) marqué avec `#[DaplosId]` pour éviter les doublons

Exemple :
```php
#[DaplosId]
private ?int $culturesId = null;  // ID DAPLOS (ex: 21766)
```

La synchronisation vérifie si cet ID DAPLOS existe déjà avant de créer ou mettre à jour.

### Que se passe-t-il si les données API changent ?

Le bundle gère intelligemment les mises à jour :
1. **Nouveaux items** : Créés automatiquement
2. **Items existants** : Mis à jour avec les nouvelles données
3. **Items supprimés** : Restent en base (pas de suppression automatique)

Vous pouvez relancer la synchronisation à tout moment :
```bash
php -d memory_limit=1G bin/console daplos:sync --all
```

### Pourquoi certains champs sont-ils tronqués ?

Le bundle valide automatiquement les données et tronque les valeurs qui dépassent la longueur maximale définie dans Doctrine. Par exemple, un titre de 300 caractères sera tronqué à 255 si le champ est défini comme `VARCHAR(255)`.

**Exception** : Le référentiel `StadedelacultureBBCH` utilise `VARCHAR(1000)` pour le champ `title` car certaines descriptions DAPLOS dépassent 255 caractères.

### Puis-je personnaliser les entités générées ?

Oui ! Vous avez deux options :

**Option 1 : Modifier après génération**
```bash
php bin/console daplos:generate:entity --all
# Puis modifiez les entités générées dans src/Entity/Daplos/
```

**Option 2 : Utiliser les traits directement**
```php
use YoanBernabeu\DaplosBundle\Entity\Trait\CulturesTrait;

class MaCulturePersonnalisée
{
    use CulturesTrait;
    
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

**Note** : Si vous utilisez un cache qui supporte les tags (comme `cache.adapter.redis` ou `cache.adapter.memcached`), la méthode `clearAllCache()` invalidera tous les éléments du cache DAPLOS en une seule opération grâce aux tags.

## 🧪 Tests

Le bundle dispose d'une couverture de tests complète pour les composants critiques :
- ✅ `DaplosApiClient` - Gestion des appels API et du cache
- ✅ `ReferentialSyncService` - Service de synchronisation
- ✅ `EntityGeneratorService` - Service de génération d'entités
- ✅ `ListReferentialsCommand` - Commande de listage des référentiels
- ✅ `ShowReferentialCommand` - Commande d'affichage d'un référentiel
- ✅ `GenerateEntityCommand` - Commande de génération d'entités
- ✅ `SyncReferentialCommand` - Commande de synchronisation des données

```bash
composer test
```

## 🔒 Sécurité

**Note importante** : L'API DAPLOS impose le passage des credentials (login/apikey) en query string dans l'URL. Bien que ce ne soit pas la pratique recommandée, c'est une contrainte imposée par l'API externe qui est hors de notre contrôle.

## 🛠️ Développement du Bundle

### Régénérer les traits (mainteneurs uniquement)

Si l'API DAPLOS a changé et que vous devez régénérer les traits :

```bash
# Définir les credentials
export DAPLOS_API_LOGIN="votre_login"
export DAPLOS_API_KEY="votre_cle"

# Régénérer les traits
php bin/generate-traits

# Ou en dry-run
php bin/generate-traits --dry-run
```

**Note** : Ce script est un outil de maintenance réservé aux mainteneurs du bundle. Les utilisateurs finaux n'ont pas besoin de l'utiliser car les traits sont déjà fournis avec le bundle.

#### Exclure des référentiels abandonnés

Pour exclure certains référentiels abandonnés de la génération, créez un fichier `.excluded-referentials.json` à la racine du projet :

```json
{
    "description": "Liste des référentiels à exclure de la génération des traits",
    "ids": [123, 456],
    "names": ["Nom du référentiel abandonné"]
}
```

Vous pouvez également utiliser les options en ligne de commande :

```bash
# Exclure par IDs
php bin/generate-traits --exclude-ids=123,456

# Utiliser un fichier d'exclusion personnalisé
php bin/generate-traits --exclude-file=/path/to/excluded-referentials.json
```

Les référentiels exclus seront automatiquement filtrés lors de la génération. Le fichier `.excluded-referentials.json` est automatiquement détecté s'il existe à la racine du projet.

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

