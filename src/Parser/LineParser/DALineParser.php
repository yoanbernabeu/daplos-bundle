<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Document\Intervenant;

/**
 * Parser pour le FLAG DA (Adresses Intervenants).
 *
 * Format de la ligne :
 * Position 1-2   : FLAG "DA"
 * Position 3-4   : Type intervenant (2 an) - TF, FR, MR, BY, SE, SU
 * Position 5     : Espace
 * Position 6-22  : Identification SIRET/Code (17 an)
 * Position 23-25 : Type identification (3 an) - 107=SIRET, ZZZ=Autre
 * Position 26-60 : Raison sociale 1 (35 an)
 * Position 61-95 : Raison sociale 2 (35 an)
 * Position 96-130: Adresse rue 1 (35 an)
 * Position 131-165: Adresse rue 2 (35 an)
 * Position 166-200: Ville (35 an)
 * Position 201-209: Code postal (9 an)
 * Position 210-211: Code pays ISO (2 an)
 * Position 212-220: Code commune (9 an)
 * Position 221-235: Numero package (15 an)
 */
final class DALineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'DA';
    }

    protected function doParse(string $line, int $lineNumber): Intervenant
    {
        return new Intervenant(
            typeIntervenant: $this->extractField($line, 3, 2),
            identification: $this->extractField($line, 6, 17),
            typeIdentification: $this->extractField($line, 23, 3),
            raisonSociale1: $this->extractField($line, 26, 35),
            raisonSociale2: $this->extractField($line, 61, 35),
            adresseRue1: $this->extractField($line, 96, 35),
            adresseRue2: $this->extractField($line, 131, 35),
            ville: $this->extractField($line, 166, 35),
            codePostal: $this->extractField($line, 201, 9),
            codePays: $this->extractField($line, 210, 2),
            codeCommune: $this->extractField($line, 212, 9),
            numeroPackage: $this->extractField($line, 221, 15),
        );
    }
}
