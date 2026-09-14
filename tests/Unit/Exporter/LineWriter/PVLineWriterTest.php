<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Exporter\LineWriter;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\DTO\Intervention\Evenement;
use YoanBernabeu\DaplosBundle\Exporter\LineWriter\PVLineWriter;

class PVLineWriterTest extends TestCase
{
    /**
     * Case 48-50 « Type d'évènement » : nomenclature Catégorie d'intervention.
     * L'intervention agricole va en 165-167 « Type de travail ».
     */
    public function testWritesCategorieInTypeEvenementEvenWhenCodeInterventionDiffers(): void
    {
        $line = (new PVLineWriter())->write(new Evenement(
            codeIntervention: 'SEM',
            codeCategorieIntervention: 'ZG7',
            codeTypeTravail: 'SEM',
        ));

        $this->assertSame('ZG7', substr($line, 47, 3));
        $this->assertSame('SEM', substr($line, 164, 3));
    }

    public function testFallsBackOnCodeInterventionWhenCategorieIsMissing(): void
    {
        $line = (new PVLineWriter())->write(new Evenement(
            codeIntervention: 'ZG7',
        ));

        $this->assertSame('ZG7', substr($line, 47, 3));
    }
}
