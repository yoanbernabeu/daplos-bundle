<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\Contract;

/**
 * Interface pour les writers de ligne DAPLOS.
 *
 * Chaque implementation ecrit un type de FLAG specifique (EI, DE, DA, DP, etc.),
 * symetrique du LineParserInterface correspondant.
 */
interface LineWriterInterface
{
    /**
     * Retourne le FLAG gere par ce writer (2 caracteres).
     */
    public function getFlag(): string;

    /**
     * Ecrit la ligne DAPLOS correspondant au DTO.
     *
     * @param object $dto Le DTO du FLAG
     *
     * @return string La ligne au format fichier a plat (encodee en ISO-8859-1)
     */
    public function write(object $dto): string;
}
