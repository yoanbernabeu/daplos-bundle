<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\Reader;

/**
 * Lecteur de chaines de caracteres DAPLOS.
 */
final class StringReader implements ReaderInterface
{
    public function __construct(
        private readonly string $content,
    ) {
    }

    public function readLines(): iterable
    {
        $lines = preg_split('/\r\n|\r|\n/', $this->content);
        if (false === $lines) {
            return;
        }

        $lineNumber = 1;
        foreach ($lines as $line) {
            yield $lineNumber++ => $line;
        }
    }
}
