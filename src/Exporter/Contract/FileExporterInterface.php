<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\Contract;

use YoanBernabeu\DaplosBundle\DTO\DaplosDocument;

/**
 * Interface pour l'exporter de fichiers DAPLOS.
 */
interface FileExporterInterface
{
    /**
     * Exporte un document DAPLOS sous forme de chaine au format fichier a plat.
     *
     * @param DaplosDocument $document Le document a exporter
     *
     * @return string Le contenu DAPLOS
     */
    public function exportToString(DaplosDocument $document): string;

    /**
     * Exporte un document DAPLOS dans un fichier.
     *
     * @param DaplosDocument $document Le document a exporter
     * @param string         $filePath Chemin du fichier de destination
     */
    public function exportToFile(DaplosDocument $document, string $filePath): void;
}
