# Génération de l'Entité DaplosReferential

La commande `daplos:generate:entity` génère l'entité Doctrine et son repository dans votre application.

## Commandes

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

## Caractéristiques de l'entité générée

- Table unique `daplos_referential`
- Index unique composite `(daplos_id, referential_type)`
- Trait `DaplosReferentialTrait` avec getters/setters
- Enum `DaplosReferentialType` pour typer les référentiels
- Repository avec méthodes `findOneByDaplosIdAndType()` et `findByReferentialType()`

## Personnalisation

Après génération, vous pouvez modifier l'entité dans `src/Entity/DaplosReferential.php` :

```php
use YoanBernabeu\DaplosBundle\Entity\Trait\DaplosReferentialTrait;

class DaplosReferential implements DaplosEntityInterface
{
    use DaplosReferentialTrait;

    // Ajoutez vos propres propriétés et méthodes
    private ?string $monChampCustom = null;
}
```

## Notes

Cette commande est **idempotente** : vous pouvez la relancer sans risque.
