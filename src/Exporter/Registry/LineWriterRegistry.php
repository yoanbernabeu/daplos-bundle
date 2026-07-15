<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Exporter\Registry;

use YoanBernabeu\DaplosBundle\Exporter\Contract\LineWriterInterface;
use YoanBernabeu\DaplosBundle\Exporter\Exception\DaplosExportException;

/**
 * Registre des writers de ligne.
 *
 * Permet d'enregistrer et de recuperer les writers par FLAG.
 * Symetrique du LineParserRegistry.
 */
final class LineWriterRegistry
{
    /** @var array<string, LineWriterInterface> */
    private array $writers = [];

    /**
     * @param iterable<LineWriterInterface> $lineWriters
     */
    public function __construct(iterable $lineWriters = [])
    {
        foreach ($lineWriters as $writer) {
            $this->register($writer);
        }
    }

    /**
     * Enregistre un writer dans le registre.
     */
    public function register(LineWriterInterface $writer): void
    {
        $this->writers[$writer->getFlag()] = $writer;
    }

    /**
     * Verifie si un writer existe pour le FLAG donne.
     */
    public function has(string $flag): bool
    {
        return isset($this->writers[$flag]);
    }

    /**
     * Recupere le writer pour le FLAG donne.
     *
     * @throws DaplosExportException Si aucun writer n'existe pour ce FLAG
     */
    public function get(string $flag): LineWriterInterface
    {
        if (!$this->has($flag)) {
            throw new DaplosExportException(sprintf('Aucun writer enregistre pour le FLAG "%s"', $flag));
        }

        return $this->writers[$flag];
    }

    /**
     * Retourne la liste des FLAGS supportes.
     *
     * @return array<string>
     */
    public function getSupportedFlags(): array
    {
        return array_keys($this->writers);
    }
}
