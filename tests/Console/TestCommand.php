<?php declare(strict_types=1);

namespace Danilovl\SymfonyConsoleInputValidation\Tests\Console;

use Danilovl\SymfonyConsoleInputValidation\Console\Input\InputOption as InputOptionValidation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\{
    InputOption,
    InputInterface
};
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    public const string COMMAND_NAME = 'app:command-test';

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);

        $this->getDefinition()->addOption(
            new InputOptionValidation(
                'type',
                null,
                InputOption::VALUE_REQUIRED,
                'Encryption type.',
                null,
                ['encrypt', 'decrypt'],
                static function (mixed $value): void {
                    if (empty($value)) {
                        return;
                    }

                    if (!in_array($value, ['encrypt', 'decrypt'])) {
                        throw new InvalidOptionException(sprintf('"%s" is not a valid type.', $value));
                    }
                }
            )
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $input->getOption('type');

        return Command::SUCCESS;
    }
}
