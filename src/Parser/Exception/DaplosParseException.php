<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\Exception;

use YoanBernabeu\DaplosBundle\Exception\DaplosApiException;

/**
 * Exception de base pour les erreurs de parsing DAPLOS.
 */
class DaplosParseException extends DaplosApiException
{
    public function __construct(
        string $message,
        private readonly ?int $lineNumber = null,
        private readonly ?string $lineContent = null,
        ?\Throwable $previous = null,
    ) {
        $fullMessage = null !== $lineNumber
            ? sprintf('[Ligne %d] %s', $lineNumber, $message)
            : $message;

        parent::__construct($fullMessage, 0, $previous);
    }

    public function getLineNumber(): ?int
    {
        return $this->lineNumber;
    }

    public function getLineContent(): ?string
    {
        return $this->lineContent;
    }
}
