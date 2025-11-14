<?php

namespace YoanBernabeu\DaplosBundle\Tests\Unit\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use YoanBernabeu\DaplosBundle\Command\ListReferentialsCommand;
use YoanBernabeu\DaplosBundle\Exception\DaplosApiException;
use YoanBernabeu\DaplosBundle\Service\ReferentialSyncServiceInterface;

class ListReferentialsCommandTest extends TestCase
{
    private ReferentialSyncServiceInterface $syncService;
    private ListReferentialsCommand $command;
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $this->syncService = $this->createMock(ReferentialSyncServiceInterface::class);
        $this->command = new ListReferentialsCommand($this->syncService);
        $this->commandTester = new CommandTester($this->command);
    }

    public function testExecuteWithReferentials(): void
    {
        $referentials = [
            [
                'id' => 611,
                'name' => 'Cultures',
                'repository_code' => 'List_BotanicalSpecies_CodeType',
                'count' => 716,
            ],
            [
                'id' => 633,
                'name' => 'Amendements',
                'repository_code' => 'List_SoilSupplement_CodeType',
                'count' => 3,
            ],
        ];

        $this->syncService->expects($this->once())
            ->method('getAvailableReferentials')
            ->willReturn($referentials);

        $exitCode = $this->commandTester->execute([]);

        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Référentiels DAPLOS disponibles', $output);
        $this->assertStringContainsString('Cultures', $output);
        $this->assertStringContainsString('Amendements', $output);
        $this->assertStringContainsString('611', $output);
        $this->assertStringContainsString('633', $output);
        $this->assertStringContainsString('Total: 2 référentiels disponibles', $output);
    }

    public function testExecuteWithNoReferentials(): void
    {
        $this->syncService->expects($this->once())
            ->method('getAvailableReferentials')
            ->willReturn([]);

        $exitCode = $this->commandTester->execute([]);

        $this->assertEquals(Command::SUCCESS, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Aucun référentiel trouvé', $output);
    }

    public function testExecuteWithApiException(): void
    {
        $this->syncService->expects($this->once())
            ->method('getAvailableReferentials')
            ->willThrowException(new DaplosApiException('API Error'));

        $exitCode = $this->commandTester->execute([]);

        $this->assertEquals(Command::FAILURE, $exitCode);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Erreur lors de la récupération des référentiels', $output);
        $this->assertStringContainsString('API Error', $output);
    }

    public function testCommandIsProperlyConfigured(): void
    {
        $this->assertEquals('daplos:referentials:list', $this->command->getName());
        $this->assertStringContainsString('référentiels DAPLOS', $this->command->getDescription());
    }
}
