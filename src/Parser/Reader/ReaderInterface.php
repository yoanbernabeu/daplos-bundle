<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\Reader;

/**
 * Interface pour la lecture de fichiers DAPLOS.
 */
interface ReaderInterface
{
    /**
     * Lit les lignes du fichier.
     *
     * @return iterable<int, string> Les lignes indexees par leur numero (1-based)
     */
    public function readLines(): iterable;
}
