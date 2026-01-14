<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Parser\Exception;

use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;

/**
 * Exception levee lorsqu'un code referentiel n'existe pas dans les donnees synchronisees.
 */
class InvalidReferentialCodeException extends DaplosParseException
{
    private readonly string $referentialCode;
    private readonly DaplosReferentialType $referentialType;

    public function __construct(
        string $referentialCode,
        DaplosReferentialType $referentialType,
        ?int $lineNumber = null,
        ?string $lineContent = null,
        ?\Throwable $previous = null,
    ) {
        $this->referentialCode = $referentialCode;
        $this->referentialType = $referentialType;

        parent::__construct(
            sprintf(
                'Code "%s" non trouve dans le referentiel "%s"',
                $referentialCode,
                $referentialType->getLabel(),
            ),
            $lineNumber,
            $lineContent,
            $previous,
        );
    }

    public function getReferentialCode(): string
    {
        return $this->referentialCode;
    }

    public function getReferentialType(): DaplosReferentialType
    {
        return $this->referentialType;
    }
}
