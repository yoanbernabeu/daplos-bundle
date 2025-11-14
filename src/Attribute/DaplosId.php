<?php

namespace YoanBernabeu\DaplosBundle\Attribute;

/**
 * Attribut pour marquer une propriété comme contenant l'ID DAPLOS.
 *
 * Utilisez cet attribut sur une propriété entière de votre entité pour indiquer
 * qu'elle contient l'ID du référentiel DAPLOS. Le ReferentialSyncService
 * utilisera cette propriété pour rechercher les entités existantes lors de la
 * synchronisation.
 *
 * Exemple :
 * ```php
 * use YoanBernabeu\DaplosBundle\Attribute\DaplosId;
 *
 * class Culture
 * {
 *     #[DaplosId]
 *     private ?int $culturesId = null;
 *
 *     // ... autres propriétés
 * }
 * ```
 *
 * Alternative : Implémenter DaplosEntityInterface si vous préférez une approche
 * par interface.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class DaplosId
{
}
