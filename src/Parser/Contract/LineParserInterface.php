<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\Contract;

/**
 * Interface pour les parsers de ligne DAPLOS.
 *
 * Chaque implementation parse un type de FLAG specifique (EI, DE, DA, DP, etc.).
 */
interface LineParserInterface
{
    /**
     * Retourne le FLAG gere par ce parser (2 caracteres).
     */
    public function getFlag(): string;

    /**
     * Parse une ligne et retourne le DTO correspondant.
     *
     * @param string $line       La ligne complete a parser
     * @param int    $lineNumber Le numero de ligne dans le fichier (pour les messages d'erreur)
     *
     * @return object Le DTO correspondant au FLAG
     */
    public function parse(string $line, int $lineNumber = 0): object;

    /**
     * Verifie si ce parser supporte la ligne donnee.
     */
    public function supports(string $line): bool;
}
