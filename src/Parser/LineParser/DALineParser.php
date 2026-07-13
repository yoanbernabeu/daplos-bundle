<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Document\Intervenant;

/**
 * Parser pour le FLAG DA (Adresses intervenants).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), pages 10-11 :
 *
 * Position 3-5     : Qualifiant intervenant (3 an) — TF exploitation / FR émetteur / MR destinataire
 * Position 6-22    : Identification de l'intervenant (17 an) — SIRET si exploitation, sinon GLN ou SIRET
 * Position 23-25   : Type d'identification en code (3 an) — 9 EAN / 107 SIRET
 * Position 26-60   : Raison sociale 1 (35 an)
 * Position 61-95   : Raison sociale 2 (35 an)
 * Position 96-130  : Adresse rue 1 (35 an)
 * Position 131-165 : Adresse rue 2 (35 an)
 * Position 166-200 : Ville (35 an)
 * Position 201-209 : Code postal (9 an)
 * Position 210-211 : Pays (2 an) — code ISO
 * Position 212-231 : 1ère référence complémentaire exploitation (20 an) — si qualifiant TF
 * Position 232-251 : 2ème référence complémentaire exploitation (20 an) — n° Pacage si qualifiant TF,
 *                    rempli dans `numeroPackage` (nom historique conservé pour compatibilité)
 * Position 252-271 : 3ème référence complémentaire exploitation (20 an) — code MSA si qualifiant TF
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
            typeIntervenant: $this->extractField($line, 3, 3),
            identification: $this->extractField($line, 6, 17),
            typeIdentification: $this->extractField($line, 23, 3),
            raisonSociale1: $this->extractField($line, 26, 35),
            raisonSociale2: $this->extractField($line, 61, 35),
            adresseRue1: $this->extractField($line, 96, 35),
            adresseRue2: $this->extractField($line, 131, 35),
            ville: $this->extractField($line, 166, 35),
            codePostal: $this->extractField($line, 201, 9),
            codePays: $this->extractField($line, 210, 2),
            numeroPackage: $this->extractField($line, 232, 20),
            referenceComplementaire1: $this->extractField($line, 212, 20),
            codeMSA: $this->extractField($line, 252, 20),
        );
    }
}
