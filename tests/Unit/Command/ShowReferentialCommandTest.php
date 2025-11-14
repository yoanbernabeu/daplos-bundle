<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use YoanBernabeu\DaplosBundle\Command\ShowReferentialCommand;
use YoanBernabeu\DaplosBundle\Exception\DaplosApiException;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncServiceInterface;

class ShowReferentialCommandTest extends TestCase
{
    private ReferentialSyncServiceInterface $syncService;
    private ShowReferentialCommand $command;
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $this->syncService = $this->createMock(ReferentialSyncServiceInterface::class);
        $this->command = new ShowReferentialCommand($this->syncService);
        $this->commandTester = new CommandTester($this->command);
    }

    public function testExecuteWithValidReferential(): void
    {
        $referentialData = [
            'referential' => [
                'id' => 611,
                'name' => 'Cultures',
                'repository_code' => 'List_BotanicalSpecies_CodeType',
            ],
            'references' => [
                ['id' => 1, 'title' => 'Blé', 'reference_code' => 'BLE'],
                ['id' => 2, 'title' => 'Maïs', 'reference_code' => 'MAI'],
                ['id' => 3, 'title' => 'Orge', 'reference_code' => 'ORG'],
            ],
        ];

        $this->syncService->expects($this->once())
            ->method('getReferentialDetails')
            ->with(611)
            ->willReturn($referentialData);

        $exitCode = $this->commandTester->execute(['id' => '611']);

        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Référentiel: Cultures', $output);
        $this->assertStringContainsString('611', $output);
        $this->assertStringContainsString('Blé', $output);
        $this->assertStringContainsString('Maïs', $output);
        $this->assertStringContainsString('Orge', $output);
    }

    public function testExecuteWithLimitOption(): void
    {
        $references = [];
        for ($i = 1; $i <= 50; ++$i) {
            $references[] = ['id' => $i, 'title' => "Item $i", 'reference_code' => "CODE$i"];
        }

        $referentialData = [
            'referential' => [
                'id' => 611,
                'name' => 'Cultures',
                'repository_code' => 'List_BotanicalSpecies_CodeType',
            ],
            'references' => $references,
        ];

        $this->syncService->expects($this->once())
            ->method('getReferentialDetails')
            ->with(611)
            ->willReturn($referentialData);

        $exitCode = $this->commandTester->execute([
            'id' => '611',
            '--limit' => '10',
        ]);

        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('affichage des 10 premiers', $output);
        $this->assertStringContainsString('40 items supplémentaires', $output);
    }

    public function testExecuteWithEmptyReferences(): void
    {
        $referentialData = [
            'referential' => [
                'id' => 611,
                'name' => 'Cultures',
                'repository_code' => 'List_BotanicalSpecies_CodeType',
            ],
            'references' => [],
        ];

        $this->syncService->expects($this->once())
            ->method('getReferentialDetails')
            ->with(611)
            ->willReturn($referentialData);

        $exitCode = $this->commandTester->execute(['id' => '611']);

        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Ce référentiel ne contient aucun item', $output);
    }

    public function testExecuteWithApiException(): void
    {
        $this->syncService->expects($this->once())
            ->method('getReferentialDetails')
            ->with(611)
            ->willThrowException(new DaplosApiException('Référentiel non trouvé'));

        $exitCode = $this->commandTester->execute(['id' => '611']);

        $this->assertEquals(Command::FAILURE, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Erreur lors de la récupération du référentiel', $output);
        $this->assertStringContainsString('Référentiel non trouvé', $output);
    }

    public function testCommandIsProperlyConfigured(): void
    {
        $this->assertEquals('daplos:referentials:show', $this->command->getName());
        $this->assertStringContainsString('référentiel DAPLOS', $this->command->getDescription());

        $definition = $this->command->getDefinition();
        $this->assertTrue($definition->hasArgument('id'));
        $this->assertTrue($definition->hasOption('limit'));
    }

    public function testDefaultLimitIsUsedWhenNotSpecified(): void
    {
        $references = [];
        for ($i = 1; $i <= 30; ++$i) {
            $references[] = ['id' => $i, 'title' => "Item $i", 'reference_code' => "CODE$i"];
        }

        $referentialData = [
            'referential' => [
                'id' => 611,
                'name' => 'Cultures',
                'repository_code' => 'List_BotanicalSpecies_CodeType',
            ],
            'references' => $references,
        ];

        $this->syncService->expects($this->once())
            ->method('getReferentialDetails')
            ->willReturn($referentialData);

        $exitCode = $this->commandTester->execute(['id' => '611']);

        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        // La limite par défaut est 20
        $this->assertStringContainsString('affichage des 20 premiers', $output);
        $this->assertStringContainsString('10 items supplémentaires', $output);
    }
}
