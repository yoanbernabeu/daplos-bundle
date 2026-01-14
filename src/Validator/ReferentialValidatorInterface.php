<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Validator;

use YoanBernabeu\DaplosBundle\DTO\DaplosDocument;

/**
 * Interface pour les validateurs de documents DAPLOS.
 */
interface ReferentialValidatorInterface
{
    /**
     * Valide un document DAPLOS contre les référentiels.
     */
    public function validate(DaplosDocument $document): ValidationResult;
}
