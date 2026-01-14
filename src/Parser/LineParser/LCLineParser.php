<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Recolte\CaracterisationProduit;

/**
 * Parser pour le FLAG LC (Caracterisation Produit).
 */
final class LCLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'LC';
    }

    protected function doParse(string $line, int $lineNumber): CaracterisationProduit
    {
        return new CaracterisationProduit(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            refIntervention: $this->extractField($line, 15, 32),
            codeCaracteristique: $this->extractField($line, 47, 3),
            valeur: $this->extractField($line, 50, 20),
            codeUnite: $this->extractField($line, 70, 3),
        );
    }
}
