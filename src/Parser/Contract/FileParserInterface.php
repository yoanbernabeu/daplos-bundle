<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\Contract;

use YoanBernabeu\DaplosBundle\DTO\DaplosDocument;

/**
 * Interface pour le parser de fichiers DAPLOS.
 */
interface FileParserInterface
{
    /**
     * Parse un fichier DAPLOS et retourne le document complet.
     *
     * @param string $filePath Chemin vers le fichier .dap
     *
     * @return DaplosDocument Le document parse
     */
    public function parseFile(string $filePath): DaplosDocument;

    /**
     * Parse une chaine de caracteres contenant des donnees DAPLOS.
     *
     * @param string $content Le contenu DAPLOS
     *
     * @return DaplosDocument Le document parse
     */
    public function parseString(string $content): DaplosDocument;
}
