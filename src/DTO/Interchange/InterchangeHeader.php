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
        public readonly ?\DateTimeImmutable $dateHeurePreparation = null,
        public readonly ?string $referenceInterchange = null,
    ) {
    }
}
