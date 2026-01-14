<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\Registry;

use YoanBernabeu\DaplosBundle\Parser\Contract\LineParserInterface;
use YoanBernabeu\DaplosBundle\Parser\Exception\InvalidFlagException;

/**
 * Registre des parsers de ligne.
 *
 * Permet d'enregistrer et de recuperer les parsers par FLAG.
 * Respecte le principe Open/Closed : extensible via enregistrement sans modification.
 */
final class LineParserRegistry
{
    /** @var array<string, LineParserInterface> */
    private array $parsers = [];

    /**
     * @param iterable<LineParserInterface> $lineParsers
     */
    public function __construct(iterable $lineParsers = [])
    {
        foreach ($lineParsers as $parser) {
            $this->register($parser);
        }
    }

    /**
     * Enregistre un parser dans le registre.
     */
    public function register(LineParserInterface $parser): void
    {
        $this->parsers[$parser->getFlag()] = $parser;
    }

    /**
     * Verifie si un parser existe pour le FLAG donne.
     */
    public function has(string $flag): bool
    {
        return isset($this->parsers[$flag]);
    }

    /**
     * Recupere le parser pour le FLAG donne.
     *
     * @throws InvalidFlagException Si aucun parser n'existe pour ce FLAG
     */
    public function get(string $flag): LineParserInterface
    {
        if (!$this->has($flag)) {
            throw new InvalidFlagException($flag);
        }

        return $this->parsers[$flag];
    }

    /**
     * Retourne la liste des FLAGS supportes.
     *
     * @return array<string>
     */
    public function getSupportedFlags(): array
    {
        return array_keys($this->parsers);
    }

    /**
     * Trouve le parser qui supporte la ligne donnee.
     */
    public function findParserForLine(string $line): ?LineParserInterface
    {
        $flag = substr($line, 0, 2);

        return $this->parsers[$flag] ?? null;
    }
}
