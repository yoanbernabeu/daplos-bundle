<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Validator;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;
use YoanBernabeu\DaplosBundle\Validator\ValidationError;
use YoanBernabeu\DaplosBundle\Validator\ValidationResult;

class ValidationResultTest extends TestCase
{
    public function testEmptyResultIsValid(): void
    {
        $result = new ValidationResult();

        $this->assertTrue($result->isValid());
        $this->assertSame(0, $result->getErrorCount());
        $this->assertEmpty($result->getErrors());
    }

    public function testResultWithErrorsIsInvalid(): void
    {
        $result = new ValidationResult();
        $error = new ValidationError(
            'ZXX',
            DaplosReferentialType::ESPECE_BOTANIQUE_D_UNE_CULTURE,
            'codeEspeceBotanique',
            'Parcelle 1',
        );

        $result->addError($error);

        $this->assertFalse($result->isValid());
        $this->assertSame(1, $result->getErrorCount());
        $this->assertCount(1, $result->getErrors());
    }

    public function testGetErrorMessages(): void
    {
        $result = new ValidationResult();
        $result->addError(new ValidationError(
            'ZXX',
            DaplosReferentialType::ESPECE_BOTANIQUE_D_UNE_CULTURE,
            'codeEspeceBotanique',
            'Parcelle 1',
        ));
        $result->addError(new ValidationError(
            'ZYY',
            DaplosReferentialType::FAMILLE_D_INTRANT,
            'codeTypeIntrant',
            'Intrant 1',
        ));

        $messages = $result->getErrorMessages();

        $this->assertCount(2, $messages);
        $this->assertStringContainsString('ZXX', $messages[0]);
        $this->assertStringContainsString('ZYY', $messages[1]);
    }
}
