<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Document;

/**
 * DTO pour le FLAG DT (Type d'Agriculture).
 */
final class TypeAgriculture
{
    public function __construct(
        public readonly ?string $codeTypeAgriculture = null,
        /**
         * Contient la valeur « Autre type d'agriculture » du guide v0.95
         * (positions 26 à fin de ligne). Nom conservé pour compatibilité.
         */
        public readonly ?string $libelle = null,
        public readonly ?string $numeroCertificat = null,
    ) {
    }
}
