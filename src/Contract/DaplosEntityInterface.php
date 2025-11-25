<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Contract;

use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;

/**
 * Interface pour les entités qui utilisent les référentiels DAPLOS.
 *
 * Les entités implémentant cette interface peuvent être synchronisées
 * automatiquement avec les données DAPLOS via le ReferentialSyncService.
 *
 * Alternative : Utiliser le trait DaplosReferentialTrait qui implémente
 * automatiquement toutes ces méthodes.
 */
interface DaplosEntityInterface
{
    /**
     * Récupère l'ID DAPLOS de l'entité.
     */
    public function getDaplosId(): ?int;

    /**
     * Définit l'ID DAPLOS de l'entité.
     */
    public function setDaplosId(?int $id): static;

    /**
     * Récupère le titre/libellé DAPLOS de l'entité.
     */
    public function getDaplosTitle(): ?string;

    /**
     * Définit le titre/libellé DAPLOS de l'entité.
     */
    public function setDaplosTitle(?string $title): static;

    /**
     * Récupère le code de référence DAPLOS de l'entité.
     */
    public function getDaplosReferenceCode(): ?string;

    /**
     * Définit le code de référence DAPLOS de l'entité.
     */
    public function setDaplosReferenceCode(?string $referenceCode): static;

    /**
     * Récupère le type de référentiel DAPLOS.
     */
    public function getReferentialType(): ?DaplosReferentialType;

    /**
     * Définit le type de référentiel DAPLOS.
     */
    public function setReferentialType(?DaplosReferentialType $type): static;
}
