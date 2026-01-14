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
        public readonly ?string $libelle = null,
    ) {
    }
}
