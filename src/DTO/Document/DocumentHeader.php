<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Document;

/**
 * DTO pour le FLAG DE (Entete Document).
 */
final class DocumentHeader
{
    public function __construct(
        public readonly ?string $referenceDocument = null,
        public readonly ?\DateTimeImmutable $dateHeureDocument = null,
        public readonly ?string $codeTypeMessage = null,
        public readonly ?string $codeStatutMessage = null,
        public readonly ?string $versionFormat = null,
        public readonly ?\DateTimeImmutable $dateDebutPeriode = null,
        public readonly ?\DateTimeImmutable $dateFinPeriode = null,
    ) {
    }
}
