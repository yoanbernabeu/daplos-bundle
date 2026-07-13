<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\LineParser;

use YoanBernabeu\DaplosBundle\DTO\Parcelle\Coordonnee;

/**
 * Parser pour le FLAG VC (Coordonnées géographiques de l'intervention).
 *
 * Positions selon le guide utilisateur DAPLOS fichier à plat v0.95
 * (AgroEDI Europe, octobre 2025), page 34 :
 *
 * Position 3-6   : N° d'ordre de la parcelle (4 n)
 * Position 7-10  : Référence parcelle culturale (4 an)
 * Position 11-14 : Année prévue de récolte (4 n)
 * Position 15-46 : Référence de l'événement, GUID (32 an)
 * Position 47-49 : Qualifiant de la position géographique (3 an)
 *                  — 3 Lambert 2 étendu / 4 WGS84 / 5 Lambert 93
 * Position 50-60 : Longitude (11 an) — 7 entiers « . » 3 décimales
 * Position 61-70 : Latitude (10 an) — 7 entiers « . » 2 décimales
 * Position 71-88 : Altitude (18 n max) — 7 entiers « . » 3 décimales
 *
 * Le champ x reçoit la longitude et le champ y la latitude (noms historiques
 * du DTO Coordonnee, partagé avec les FLAGS SC et CC).
 */
final class VCLineParser extends AbstractLineParser
{
    public function getFlag(): string
    {
        return 'VC';
    }

    protected function doParse(string $line, int $lineNumber): Coordonnee
    {
        return new Coordonnee(
            identifiantParcelle: $this->extractField($line, 3, 8),
            annee: $this->extractInt($line, 11, 4),
            refIntervention: $this->extractField($line, 15, 32),
            systemeCoordonnees: $this->extractField($line, 47, 3),
            x: $this->extractFloat($line, 50, 11),
            y: $this->extractFloat($line, 61, 10),
            altitude: $this->extractFloat($line, 71, 18),
        );
    }
}
