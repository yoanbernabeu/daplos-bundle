# DaplosBundle

Bundle Symfony pour l'intégration des référentiels DAPLOS (données agricoles) dans vos applications.

## 📦 Installation

```bash
composer require yoanbernabeu/daplos-bundle
```

## ⚙️ Configuration

Créez le fichier de configuration `config/packages/yoanbernabeu_daplos.yaml` :

```yaml
yoanbernabeu_daplos:
    api:
        login: 'votre_login_daplos'
        apikey: 'votre_cle_api_daplos'
        # base_url: 'https://agroedieurope.fr/wp-json/hwc/v1' # Optionnel
    cache:
        enabled: true  # Activer le cache (recommandé)
        ttl: 3600      # Durée de vie du cache en secondes (1 heure par défaut)
```

## 💉 Injection de dépendances et Interfaces

Le bundle expose **des interfaces pour tous ses services** afin de respecter les meilleures pratiques Symfony et faciliter les tests.

### Services disponibles

| Interface | Implémentation | Alias nommé | Description |
|-----------|----------------|-------------|-------------|
| `DaplosApiClientInterface` | `DaplosApiClient` | `yoanbernabeu_daplos.api_client` | Client HTTP pour l'API DAPLOS |
| `ReferentialSyncServiceInterface` | `ReferentialSyncService` | `yoanbernabeu_daplos.sync_service` | Service de synchronisation des référentiels |
| `EntityGeneratorServiceInterface` | `EntityGeneratorService` | `yoanbernabeu_daplos.entity_generator` | Service de génération d'entités |

### Utilisation avec l'autowiring (recommandé)

**Injectez toujours les interfaces, jamais les implémentations concrètes** :

```php
<?php

namespace App\Service;

use YoanBernabeu\DaplosBundle\Client\DaplosApiClientInterface;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncServiceInterface;

class MonService
{
    public function __construct(
        private readonly DaplosApiClientInterface $apiClient,
        private readonly ReferentialSyncServiceInterface $syncService
    ) {
    }

    public function synchroniserCultures(): void
    {
        // Récupérer les référentiels disponibles
        $referentials = $this->syncService->getAvailableReferentials();
        
        // Synchroniser un référentiel spécifique
        $stats = $this->syncService->syncReferential(
            entityClass: Culture::class,
            referentialId: 611 // ID du référentiel "Cultures"
        );
    }
}
```

### Utilisation avec les alias nommés

Vous pouvez également injecter les services via leurs alias nommés :

```yaml
# config/services.yaml
services:
    App\Service\MonService:
        arguments:
            $apiClient: '@yoanbernabeu_daplos.api_client'
            $syncService: '@yoanbernabeu_daplos.sync_service'
```

### Avantages de cette approche

✅ **Testabilité** : Facilite le mocking dans les tests unitaires  
✅ **Découplage** : Votre code dépend des contrats (interfaces), pas des implémentations  
✅ **Flexibilité** : Permet de remplacer facilement les implémentations  
✅ **Bonnes pratiques Symfony** : Respecte le principe de dépendance par inversion (SOLID)

## 🚀 Utilisation

### 1. Utiliser les Traits dans vos Entités

Le bundle fournit **57 traits** correspondant aux différents référentiels DAPLOS. Chaque trait ajoute 3 propriétés à votre entité :
- `{nom}Id` : L'ID du référentiel DAPLOS
- `{nom}Title` : Le titre/libellé
- `{nom}ReferenceCode` : Le code de référence

Les noms de traits incluent les qualificatifs pour éviter les conflits (ex: `CultureDestinationTrait`, `CultureJustificationTrait`).

**⚠️ Important pour le mapping automatique** : Pour que le service de synchronisation puisse mapper automatiquement les données, vous devez soit :
- Implémenter l'interface `DaplosEntityInterface`
- OU ajouter l'attribut `#[DaplosId]` sur la propriété contenant l'ID DAPLOS

#### Exemple avec le référentiel "Cultures" (méthode 1 : Interface)

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Contract\DaplosEntityInterface;

#[ORM\Entity]
class Culture implements DaplosEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $daplosId = null;

    #[ORM\Column(length: 255)]
    private ?string $daplosTitle = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $daplosReferenceCode = null;

    // Implémentation de l'interface
    public function getDaplosId(): ?int { return $this->daplosId; }
    public function setDaplosId(?int $id): self { $this->daplosId = $id; return $this; }
    public function getDaplosTitle(): ?string { return $this->daplosTitle; }
    public function setDaplosTitle(?string $title): self { $this->daplosTitle = $title; return $this; }
    public function getDaplosReferenceCode(): ?string { return $this->daplosReferenceCode; }
    public function setDaplosReferenceCode(?string $code): self { $this->daplosReferenceCode = $code; return $this; }
}
```

#### Exemple avec le référentiel "Cultures" (méthode 2 : Trait + Attribut)

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
use YoanBernabeu\DaplosBundle\Entity\Trait\CulturesTrait;

#[ORM\Entity]
class Culture
{
    use CulturesTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Ajouter l'attribut #[DaplosId] pour le mapping automatique
    #[DaplosId]
    private ?int $culturesId = null;

    // Les getters/setters pour culturesId, culturesTitle, culturesReferenceCode
    // sont fournis par le trait CulturesTrait
}
```

#### Exemple avec plusieurs traits (Culture + Destination)

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use YoanBernabeu\DaplosBundle\Entity\Trait\CulturesTrait;
use YoanBernabeu\DaplosBundle\Entity\Trait\CultureDestinationTrait;

#[ORM\Entity]
class Culture
{
    use CulturesTrait;          // Ajoute culturesId, culturesTitle, culturesReferenceCode
    use CultureDestinationTrait; // Ajoute cultureDestinationId, cultureDestinationTitle, cultureDestinationReferenceCode

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Vous pouvez combiner plusieurs traits sans conflit de noms
}
```

#### Liste des Traits disponibles

Consultez le fichier [TRAITS_INDEX.md](TRAITS_INDEX.md) pour la liste complète des 57 traits disponibles.

Quelques exemples :
- `CulturesTrait` - Référentiel des cultures (716 items)
- `CultureDestinationTrait` - Destination de la culture (50 items)
- `CultureJustificationTrait` - Justification de la culture (19 items)
- `StadedelacultureBBCHTrait` - Stades BBCH (3769 items)
- `NuisiblesdesculturesCiblesMaladiesravageursTrait` - Ravageurs et maladies (2424 items)
- `MaterielAgricoleTypeTrait` - Type de matériel agricole (222 items)
- `MaterielAgricoleCategorieTrait` - Catégorie de matériel agricole (21 items)
- `InterventionculturaleTypeTrait` - Type d'intervention culturale (6 items)
- `IntrantTypeTrait` - Type d'intrant (35 items)
- `TypedesolTrait` - Types de sol (21 items)
- etc.

### 2. Commandes Console

#### Lister tous les référentiels disponibles

```bash
php bin/console daplos:referentials:list
```

Affiche un tableau avec tous les référentiels DAPLOS disponibles (ID, nom, repository code, nombre d'items).

#### Afficher les détails d'un référentiel

```bash
php bin/console daplos:referentials:show 633
```

Affiche les détails d'un référentiel spécifique avec ses items.

Options :
- `--limit=N` : Limite le nombre d'items affichés (défaut: 20)

Exemple :
```bash
php bin/console daplos:referentials:show 611 --limit=50
```

#### Générer automatiquement les entités

```bash
php bin/console daplos:generate:entity --check
```

Vérifie le statut des entités DAPLOS dans votre projet (quelles entités existent, lesquelles manquent).

```bash
php bin/console daplos:generate:entity --all
```

Génère automatiquement toutes les entités et leurs repositories pour tous les référentiels DAPLOS.

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

**Note** : Cette commande est **idempotente** par défaut. Elle ne recrée pas les entités existantes sauf si vous utilisez `--force`.

### 3. Utiliser le Service de Synchronisation

Vous pouvez utiliser le service `ReferentialSyncService` pour synchroniser automatiquement les données DAPLOS avec vos entités.

#### Exemple dans un Controller ou un Service

```php
<?php

namespace App\Controller;

use App\Entity\Culture;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SyncController extends AbstractController
{
    #[Route('/sync/cultures', name: 'app_sync_cultures')]
    public function syncCultures(ReferentialSyncService $syncService): Response
    {
        // Synchroniser le référentiel "Cultures" (ID: 611) avec l'entité Culture
        $stats = $syncService->syncReferential(
            entityClass: Culture::class,
            referentialId: 611
        );

        return $this->json([
            'message' => 'Synchronisation terminée',
            'created' => $stats['created'],
            'updated' => $stats['updated'],
            'total' => $stats['total']
        ]);
    }
}
```

#### Synchronisation avec Mapper personnalisé

Si vous avez besoin de mapper des champs supplémentaires ou de personnaliser le mapping :

```php
$stats = $syncService->syncReferential(
    entityClass: Culture::class,
    referentialId: 611,
    mapper: function(Culture $entity, array $reference) {
        // Si vous utilisez DaplosEntityInterface
        $entity
            ->setDaplosId($reference['id'])
            ->setDaplosTitle($reference['title'])
            ->setDaplosReferenceCode($reference['reference_code']);

        // Mapping personnalisé de champs additionnels
        $entity->setName($reference['title']); // Votre propre champ métier
        $entity->setActive(true);

        return $entity;
    }
);
```

**Note** : Le service de synchronisation utilise maintenant des **transactions Doctrine avec batch processing** (flush tous les 100 items) pour garantir l'intégrité des données et éviter les problèmes de mémoire sur les gros référentiels.

### 4. Utiliser directement le Client API

Vous pouvez aussi utiliser directement le client API DAPLOS :

```php
<?php

use YoanBernabeu\DaplosBundle\Client\DaplosApiClientInterface;

class MyService
{
    public function __construct(
        private readonly DaplosApiClientInterface $apiClient
    ) {}

    public function getAllReferentials(): array
    {
        return $this->apiClient->getReferentials();
    }

    public function getReferential(int $id): array
    {
        $data = $this->apiClient->getReferential($id);

        // $data contient :
        // - 'referential' : métadonnées du référentiel
        // - 'references' : tableau des items

        return $data;
    }

    public function clearCache(int $referentialId): void
    {
        $this->apiClient->clearReferentialCache($referentialId);
    }
}
```

## Exemples d'Utilisation Avancée

### Créer une Commande de Synchronisation Personnalisée

```php
<?php

namespace App\Command;

use App\Entity\Culture;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:sync:cultures',
    description: 'Synchronise les cultures depuis DAPLOS'
)]
class SyncCulturesCommand extends Command
{
    public function __construct(
        private readonly ReferentialSyncService $syncService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Synchronisation des cultures DAPLOS');

        try {
            $stats = $this->syncService->syncReferential(
                Culture::class,
                611 // ID du référentiel Cultures
            );

            $io->success(sprintf(
                'Synchronisation terminée : %d créées, %d mises à jour',
                $stats['created'],
                $stats['updated']
            ));

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('Erreur : ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
```

## Référentiels Disponibles (Exemples)

| ID  | Nom | Repository Code | Items |
|-----|-----|-----------------|-------|
| 611 | Cultures | List_BotanicalSpecies_CodeType | 716 |
| 597 | Stade de la culture (BBCH) | List_CropStage_CodeType | 3769 |
| 615 | Nuisibles des cultures | List_PestName_CodeType | 2424 |
| 693 | Matériel Agricole (Type) | List_AgriculturalEquipment_CodeType | 222 |
| 643 | Type de sol | List_SoilType_CodeType | 21 |

Voir [TRAITS_INDEX.md](TRAITS_INDEX.md) pour la liste complète.

## Gestion du Cache

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
- ✅ `ListReferentialsCommand` - Commande de listage
- ✅ `ShowReferentialCommand` - Commande d'affichage

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

## Dépendances

- PHP >= 8.1
- Symfony 6.4+ ou 7.0+
- Doctrine ORM

## 📝 Licence

MIT

## 👤 Auteur

**Yoan Bernabeu** pour SeineYonne


## Support

Pour toute question ou problème, ouvrez une issue sur le dépôt GitHub du projet

