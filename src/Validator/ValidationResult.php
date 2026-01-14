<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Validator;

/**
 * Résultat de la validation d'un document DAPLOS.
 */
final class ValidationResult
{
    /** @var array<ValidationError> */
    private array $errors = [];

    public function addError(ValidationError $error): void
    {
        $this->errors[] = $error;
    }

    public function isValid(): bool
    {
        return 0 === count($this->errors);
    }

    /**
     * @return array<ValidationError>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getErrorCount(): int
    {
        return count($this->errors);
    }

    /**
     * @return array<string>
     */
    public function getErrorMessages(): array
    {
        return array_map(
            static fn (ValidationError $error): string => $error->getMessage(),
            $this->errors,
        );
    }
}
