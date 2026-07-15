<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Exporter;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\Exporter\Exception\DaplosExportException;
use YoanBernabeu\DaplosBundle\Exporter\LineBuffer;

class LineBufferTest extends TestCase
{
    public function testEmptyBufferReturnsFlagOnly(): void
    {
        $buffer = new LineBuffer('EI');

        $this->assertSame('EI', $buffer->toString());
    }

    public function testSetFieldPlacesValueAtPosition(): void
    {
        $buffer = new LineBuffer('EI');
        $buffer->setField(3, 14, '12345678901234');

        $this->assertSame('EI12345678901234', $buffer->toString());
    }

    public function testSetFieldPadsShortValueToLength(): void
    {
        $buffer = new LineBuffer('DA');
        $buffer->setField(3, 3, 'TF');
        $buffer->setField(6, 5, 'X');

        // La valeur courte est complétée à droite par des espaces
        $this->assertSame('DATF X', $buffer->toString());
    }

    public function testSetFieldWithGapFillsWithSpaces(): void
    {
        $buffer = new LineBuffer('DE');
        $buffer->setField(10, 4, 'ABCD');

        $this->assertSame('DE       ABCD', $buffer->toString());
    }

    public function testSetFieldTruncatesTooLongValue(): void
    {
        $buffer = new LineBuffer('DT');
        $buffer->setField(3, 3, 'ABCDEF');

        $this->assertSame('DTABC', $buffer->toString());
    }

    public function testSetFieldNullLeavesSpaces(): void
    {
        $buffer = new LineBuffer('DE');
        $buffer->setField(3, 5, null);
        $buffer->setField(8, 2, 'XX');

        $this->assertSame('DE     XX', $buffer->toString());
    }

    public function testSetFieldConvertsUtf8ToSingleByte(): void
    {
        $buffer = new LineBuffer('DA');
        $buffer->setField(3, 10, 'Blé dur');

        $line = $buffer->toString();

        // Positions en octets : "Blé dur" doit occuper 7 octets (ISO-8859-1)
        $this->assertSame(2 + 7, strlen(rtrim($line)));
        $this->assertSame('Blé dur', mb_convert_encoding(substr($line, 2, 7), 'UTF-8', 'ISO-8859-1'));
    }

    public function testSetIntAlignsRight(): void
    {
        $buffer = new LineBuffer('EI');
        $buffer->setInt(3, 4, 42);

        $this->assertSame('EI  42', $buffer->toString());
    }

    public function testSetIntThrowsWhenValueTooLong(): void
    {
        $buffer = new LineBuffer('EI');

        $this->expectException(DaplosExportException::class);

        $buffer->setInt(3, 2, 12345);
    }

    public function testSetDecimalFormatsWithoutTrailingZeros(): void
    {
        $buffer = new LineBuffer('PS');
        $buffer->setDecimal(18, 9, 12.5);

        $this->assertSame('PS'.str_repeat(' ', 15).'     12.5', $buffer->toString());
    }

    public function testSetDecimalFormatsIntegerValueWithoutDecimalPoint(): void
    {
        $buffer = new LineBuffer('PS');
        $buffer->setDecimal(18, 9, 10.0);

        $this->assertSame('PS'.str_repeat(' ', 15).'       10', $buffer->toString());
    }

    public function testSetDecimalPreservesAllDecimals(): void
    {
        // Coordonnees Lambert 2 etendu reelles : 4 decimales a conserver
        $buffer = new LineBuffer('SC');
        $buffer->setDecimal(18, 11, 704536.7215);

        $this->assertSame('SC'.str_repeat(' ', 15).'704536.7215', $buffer->toString());
    }

    public function testSetDecimalDropsLeadingZeroWhenNeededToFit(): void
    {
        // Valeur reelle de fichier DAPLOS : ".81999999" (9 caracteres, zero initial omis)
        $buffer = new LineBuffer('PS');
        $buffer->setDecimal(18, 9, 0.81999999);

        $this->assertSame('PS'.str_repeat(' ', 15).'.81999999', $buffer->toString());
    }

    public function testSetDecimalThrowsWhenValueTooLong(): void
    {
        $buffer = new LineBuffer('PS');

        $this->expectException(DaplosExportException::class);

        $buffer->setDecimal(3, 4, 123456.789);
    }

    public function testSetDateFormatsDateOnEightChars(): void
    {
        $buffer = new LineBuffer('DE');
        $buffer->setDate(39, 8, new \DateTimeImmutable('2025-10-07'));

        $this->assertSame('DE'.str_repeat(' ', 36).'20251007', $buffer->toString());
    }

    public function testSetDateFormatsDateTimeOnTwelveChars(): void
    {
        $buffer = new LineBuffer('PV');
        $buffer->setDate(89, 12, new \DateTimeImmutable('2025-10-07 14:30'));

        $this->assertSame('PV'.str_repeat(' ', 86).'202510071430', $buffer->toString());
    }

    public function testSetBoolWritesOAndN(): void
    {
        $buffer = new LineBuffer('DP');
        $buffer->setBool(3, true);
        $buffer->setBool(4, false);
        $buffer->setBool(5, null);

        $this->assertSame('DPON', $buffer->toString());
    }
}
