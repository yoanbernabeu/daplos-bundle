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
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser */
        public readonly ?string $codeTypeMessage = null,
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser (voir codeFonction) */
        public readonly ?string $codeStatutMessage = null,
        public readonly ?string $versionFormat = null,
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser */
        public readonly ?\DateTimeImmutable $dateDebutPeriode = null,
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser */
        public readonly ?\DateTimeImmutable $dateFinPeriode = null,
        public readonly ?string $codeFonction = null,
        public readonly ?int $nombreFichesParcellaires = null,
    ) {
    }
}
