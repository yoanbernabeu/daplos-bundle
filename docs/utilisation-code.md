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
