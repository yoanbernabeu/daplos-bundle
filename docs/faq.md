# FAQ

## Pourquoi utiliser `-d memory_limit=1G` ?

Certains référentiels contiennent beaucoup d'items avec des descriptions longues. Pour synchroniser tous les référentiels d'un coup (`--all`), il est recommandé d'augmenter la limite mémoire.

```bash
# Recommandé pour --all
php -d memory_limit=1G bin/console daplos:sync --all

# OK pour un type individuel
php bin/console daplos:sync --type=CULTURES
```

## Comment éviter les doublons ?

L'entité utilise un **index unique composite** sur `(daplos_id, referential_type)`. La synchronisation vérifie si cette combinaison existe déjà avant de créer ou mettre à jour.

## Que se passe-t-il si les données API changent ?

Le bundle gère intelligemment les mises à jour :
1. **Nouveaux items** : Créés automatiquement
2. **Items existants** : Mis à jour avec les nouvelles données
3. **Items supprimés** : Restent en base (pas de suppression automatique)

Vous pouvez relancer la synchronisation à tout moment :
```bash
php -d memory_limit=1G bin/console daplos:sync --all
```

## Puis-je personnaliser l'entité générée ?

Oui ! Voir [Génération d'entité](generation-entite.md#personnalisation).

## Notes de sécurité

L'API DAPLOS impose le passage des credentials (login/apikey) en query string dans l'URL. C'est une contrainte de l'API externe.

## Régénérer l'Enum (mainteneurs uniquement)

Si l'API DAPLOS évolue (nouveaux référentiels), les mainteneurs peuvent régénérer l'Enum :

```bash
export DAPLOS_API_LOGIN="votre_login"
export DAPLOS_API_KEY="votre_cle"
php bin/generate-enum
```

### Exclure des référentiels

Créez un fichier `.excluded-referentials.json` à la racine :

```json
{
    "description": "Liste des référentiels à exclure",
    "ids": [123, 456],
    "names": ["Nom du référentiel abandonné"]
}
```

Ou via ligne de commande :
```bash
php bin/generate-enum --exclude-ids=123,456
```
