<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\Contract;

use YoanBernabeu\DaplosBundle\Exporter\ExportTruncation;

/**
 * Writer ou exporter qui signale les valeurs texte coupées lors de la
 * dernière écriture.
 */
interface TruncationAwareInterface
{
    /**
     * Valeurs coupées lors de la dernière écriture (ligne pour un writer,
     * document pour l'exporter) ; vide si tout a tenu dans les champs.
     *
     * @return list<ExportTruncation>
     */
    public function getTruncations(): array;
}
