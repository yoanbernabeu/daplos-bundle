<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Validator;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\Enum\DaplosReferentialType;
use YoanBernabeu\DaplosBundle\Validator\ValidationError;

class ValidationErrorTest extends TestCase
{
    public function testGetMessage(): void
    {
        $error = new ValidationError(
            'ZXX',
            DaplosReferentialType::ESPECE_BOTANIQUE_D_UNE_CULTURE,
            'codeEspeceBotanique',
        );

        $message = $error->getMessage();

        $this->assertStringContainsString('ZXX', $message);
        $this->assertStringContainsString('Espèce botanique', $message);
        $this->assertStringContainsString('codeEspeceBotanique', $message);
    }

    public function testGetMessageWithContext(): void
    {
        $error = new ValidationError(
            'ZXX',
            DaplosReferentialType::ESPECE_BOTANIQUE_D_UNE_CULTURE,
            'codeEspeceBotanique',
            'Parcelle 00001',
        );

        $message = $error->getMessage();

        $this->assertStringContainsString('Parcelle 00001', $message);
    }

    public function testProperties(): void
    {
        $error = new ValidationError(
            'ZXX',
            DaplosReferentialType::FAMILLE_D_INTRANT,
            'codeTypeIntrant',
            'Test context',
        );

        $this->assertSame('ZXX', $error->code);
        $this->assertSame(DaplosReferentialType::FAMILLE_D_INTRANT, $error->referentialType);
        $this->assertSame('codeTypeIntrant', $error->field);
        $this->assertSame('Test context', $error->context);
    }
}
