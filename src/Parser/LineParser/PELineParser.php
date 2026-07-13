<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Engagement;

/**
 * Parser pour le FLAG PE (Engagement).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), page 24 :
 *
 * Position 3-6     : N° d'ordre de la parcelle (4 n)
 * Position 7-10    : Référence parcelle culturale (4 an)
 * Position 11-14   : Année prévue de récolte (4 n)
 * Position 15-17   : Code engagement, en code (3 an) — nomenclature Valeur de la
 *                    caractéristique technique (codes combinés au code TPA)
 * Position 18-52   : Libellé autre contrat (35 an) — obligatoire si code engagement
 *                    non renseigné ; alimente la propriété « libelle » du DTO
 * Position 53-87   : N° de contrat (35 an)
 * Position 88-95   : Date du contrat (8 n) SSAAMMJJ
 * Position 96-109  : Identification du contractant (14 an) — code EAN ou SIRET
 * Position 110-112 : Type d'identification, en code (3 an) — 9 : EAN / 107 : SIRET
 * Position 113-147 : Raison sociale 1 du contractant (35 an)
 * Position 148-182 : Raison sociale 2 du contractant (35 an)
 * Position 183-217 : Adresse rue 1 du contractant (35 an)
 * Position 218-252 : Adresse rue 2 du contractant (35 an)
 * Position 253-287 : Ville du contractant (35 an)
 * Position 288-296 : Code postal du contractant (9 an)
 * Position 297-298 : Pays du contractant, code ISO (2 an)
 */
final class PELineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'PE';
    }

    protected function doParse(string $line, int $lineNumber): Engagement
    {
        return new Engagement(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            libelle: $this->extractField($line, 18, 35),
            codeEngagement: $this->extractField($line, 15, 3),
            numeroContrat: $this->extractField($line, 53, 35),
            dateContrat: $this->extractDateTime($line, 88, 8),
            identificationContractant: $this->extractField($line, 96, 14),
            typeIdentificationContractant: $this->extractField($line, 110, 3),
            contractantRaisonSociale1: $this->extractField($line, 113, 35),
            contractantRaisonSociale2: $this->extractField($line, 148, 35),
            contractantAdresseRue1: $this->extractField($line, 183, 35),
            contractantAdresseRue2: $this->extractField($line, 218, 35),
            contractantVille: $this->extractField($line, 253, 35),
            contractantCodePostal: $this->extractField($line, 288, 9),
            contractantPays: $this->extractField($line, 297, 2),
        );
    }
}
