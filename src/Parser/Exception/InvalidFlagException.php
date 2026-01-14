<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\Exception;

/**
 * Exception levée lorsqu'un FLAG inconnu est rencontré.
 */
class InvalidFlagException extends DaplosParseException
{
    public function __construct(
        private readonly string $flag,
        ?int $lineNumber = null,
        ?string $lineContent = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct(
            sprintf('FLAG inconnu : "%s"', $flag),
            $lineNumber,
            $lineContent,
            $previous,
        );
    }

    public function getFlag(): string
    {
        return $this->flag;
    }
}
