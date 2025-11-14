<?php

namespace YoanBernabeu\DaplosBundle\Contract;

/**
 * Interface pour les entités qui utilisent les référentiels DAPLOS.
 *
 * Les entités implémentant cette interface peuvent être synchronisées
 * automatiquement avec les données DAPLOS via le ReferentialSyncService.
 *
 * Alternative : Utiliser l'attribut #[DaplosId] sur une propriété de l'entité
 * si vous ne souhaitez pas implémenter cette interface.
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
    public function setDaplosId(?int $id): self;

    /**
     * Récupère le titre/libellé DAPLOS de l'entité.
     */
    public function getDaplosTitle(): ?string;

    /**
     * Définit le titre/libellé DAPLOS de l'entité.
     */
    public function setDaplosTitle(?string $title): self;

    /**
     * Récupère le code de référence DAPLOS de l'entité.
     */
    public function getDaplosReferenceCode(): ?string;

    /**
     * Définit le code de référence DAPLOS de l'entité.
     */
    public function setDaplosReferenceCode(?string $referenceCode): self;
}
