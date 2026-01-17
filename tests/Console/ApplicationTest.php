<?php declare(strict_types=1);

namespace Danilovl\SymfonyConsoleInputValidation\Tests\Console;

use Danilovl\SymfonyConsoleInputValidation\Console\Input\ArgvInput;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Tester\CommandTester;

class ApplicationTest extends TestCase
{
    public function testApplication(): void
    {
        $application = new SymfonyApplication;
        $application->addCommand(new TestCommand);
        $command = $application->find(TestCommand::COMMAND_NAME);
        /** @var string $commandName */
        $commandName = $command->getName();

        /** @param array<string>|null $outputParameters */
        $outputParameters = [
            $commandName,
            '--type=encrypt'
        ];
        $status = $command->run(new ArgvInput($outputParameters), new NullOutput);
        $this->assertEquals(Command::SUCCESS, $status);

        /** @param array<string>|null $outputParameters */
        $outputParameters = [
            $commandName,
            '--type=decrypt'
        ];
        $status = $command->run(new ArgvInput($outputParameters), new NullOutput);
        $this->assertEquals(Command::SUCCESS, $status);

        /** @param array<string>|null $outputParameters */
        $outputParameters = [
            $commandName,
            '--type=error'
        ];

        $this->expectException(InvalidOptionException::class);
        $command->run(new ArgvInput($outputParameters), new NullOutput);
    }

    public function testSymfonyApplication(): void
    {
        $application = new SymfonyApplication;
        $application->addCommand(new TestCommand);

        $command = $application->find(TestCommand::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            '--type' => 'no error'
        ]);

        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }
}
