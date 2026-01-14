<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\Exception;

/**
 * Exception levee lorsqu'un champ obligatoire est manquant.
 */
class MissingRequiredFieldException extends DaplosParseException
{
    public function __construct(
        private readonly string $fieldName,
        private readonly string $flag,
        ?int $lineNumber = null,
        ?string $lineContent = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct(
            sprintf('Champ obligatoire "%s" manquant pour le FLAG "%s"', $fieldName, $flag),
            $lineNumber,
            $lineContent,
            $previous,
        );
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    public function getFlag(): string
    {
        return $this->flag;
    }
}
