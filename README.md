# DaplosBundle

Bundle Symfony pour l'intégration des référentiels DAPLOS (données agricoles) et le parsing des fichiers d'export `.dap`.

> **Note Francophone** : Le code et les entités sont en Français pour rester alignés avec la terminologie métier AgroEDI (DAPLOS).

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%208.1-blue)](https://php.net)
[![Symfony Version](https://img.shields.io/badge/Symfony-6.4%20%7C%207.x%20%7C%208.x-green)](https://symfony.com)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

## Fonctionnalités

- **Référentiels API** : Synchronisation des 53 référentiels DAPLOS (10 000+ items) via l'API
- **Parser de fichiers** : Lecture des exports `.dap` (parcelles, interventions, intrants, récoltes)
- **Entité unique** : Architecture simplifiée avec `DaplosReferential` et enum type-safe
- **Cache intelligent** : Support des tags pour invalidation rapide

## Pré-requis

> **Important** : L'accès aux référentiels DAPLOS nécessite d'être membre d'**AgroEDI Europe**.
> [Liste des adhérents](https://agroedieurope.fr/les-adherents/)

## Démarrage rapide

```bash
# Installation
composer require yoanbernabeu/daplos-bundle

# Générer l'entité
php bin/console daplos:generate:entity

# Migrations
php bin/console make:migration
php bin/console doctrine:migrations:migrate

# Synchroniser les référentiels
php -d memory_limit=1G bin/console daplos:sync --all
```

## Configuration

Créez `config/packages/yoanbernabeu_daplos.yaml` :

```yaml
yoanbernabeu_daplos:
    api:
        login: '%env(DAPLOS_LOGIN)%'
        apikey: '%env(DAPLOS_APIKEY)%'
    cache:
        enabled: true
        ttl: 3600
```

## Commandes disponibles

### Référentiels API

```bash
# Lister les référentiels
php bin/console daplos:referentials:list

# Voir les détails d'un référentiel
php bin/console daplos:referentials:show 611

# Synchroniser un type
php bin/console daplos:sync --type=CULTURES

# Synchroniser tout
php -d memory_limit=1G bin/console daplos:sync --all
```

### Parser de fichiers .dap

```bash
# Parser un fichier
php bin/console daplos:parse fichier.dap

# Avec détails des interventions
php bin/console daplos:parse fichier.dap --interventions

# Export JSON
php bin/console daplos:parse fichier.dap --format=json
```

## Utilisation dans le code

```php
use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;
use YoanBernabeu\DaplosBundle\Parser\Contract\FileParserInterface;

// Référentiels
$cultures = $repository->findByReferentialType(DaplosReferentialType::CULTURES);

// Parser
$document = $parser->parseFile('fichier.dap');
foreach ($document->parcelles as $parcelle) {
    echo $parcelle->nom;
    foreach ($parcelle->getEvenements() as $intervention) {
        echo $intervention->libelleIntervention;
    }
}
```

## Documentation

- [Synchronisation des référentiels](docs/synchronisation.md)
- [Génération d'entité](docs/generation-entite.md)
- [Parser de fichiers .dap](docs/parser.md)
- [Traits et DTOs](docs/traits-dto.md)
- [Utilisation dans le code](docs/utilisation-code.md)
- [FAQ](docs/faq.md)

## Tests

```bash
composer test      # Tests unitaires
composer phpstan   # Analyse statique
composer cs-check  # Code style
composer qa        # Tout
```

## Dépendances

- PHP >= 8.1
- Symfony 6.4+ / 7.x / 8.x
- Doctrine ORM

## Licence

[MIT](LICENSE)

## Auteur

**Yoan Bernabeu** pour SeineYonne
