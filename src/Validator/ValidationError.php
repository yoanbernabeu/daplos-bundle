<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Validator;

use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;

/**
 * Représente une erreur de validation.
 */
final readonly class ValidationError
{
    public function __construct(
        public string $code,
        public DaplosReferentialType $referentialType,
        public string $field,
        public ?string $context = null,
    ) {
    }

    public function getMessage(): string
    {
        $message = sprintf(
            'Code "%s" non trouvé dans le référentiel "%s" pour le champ "%s"',
            $this->code,
            $this->referentialType->getLabel(),
            $this->field,
        );

        if (null !== $this->context) {
            $message .= sprintf(' (%s)', $this->context);
        }

        return $message;
    }
}
