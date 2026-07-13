<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\DTO\Interchange;

/**
 * DTO pour le FLAG EI (Enveloppe Interchange).
 */
final class InterchangeHeader
{
    public function __construct(
        public readonly ?string $identificationEmetteur = null,
        public readonly ?string $identificationDestinataire = null,
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser */
        public readonly ?\DateTimeImmutable $dateHeurePreparation = null,
        /** @deprecated champ hors guide v0.95, plus jamais rempli par le parser */
        public readonly ?string $referenceInterchange = null,
        public readonly ?string $typeCodificationEmetteur = null,
        public readonly ?string $typeCodificationDestinataire = null,
        public readonly ?int $nombreDocuments = null,
    ) {
    }
}
