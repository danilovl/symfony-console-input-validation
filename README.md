[![phpunit](https://github.com/danilovl/symfony-console-input-validation/actions/workflows/phpunit.yml/badge.svg)](https://github.com/danilovl/symfony-console-input-validation/actions/workflows/phpunit.yml)
[![downloads](https://img.shields.io/packagist/dt/danilovl/symfony-console-input-validation)](https://packagist.org/packages/danilovl/symfony-console-input-validation)
[![latest Stable Version](https://img.shields.io/packagist/v/danilovl/symfony-console-input-validation)](https://packagist.org/packages/danilovl/symfony-console-input-validation)
[![license](https://img.shields.io/packagist/l/danilovl/symfony-console-input-validation)](https://packagist.org/packages/danilovl/symfony-console-input-validation)

# Symfony console input validation #

## About ##

Provide a simple method for adding input validation to Symfony console commands.

### Requirements

* PHP 8.3 or higher
* Symfony 7.0 or higher

### 1. Installation

Install `danilovl/symfony-console-input-validation` package by Composer:

``` bash
$ composer require danilovl/symfony-console-input-validation
```

### 2. Configuration

Change symfony `Application` in `bin/console`.

```php
return function (array $context): Application {
    $kernel = new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);

    return new \Danilovl\SymfonyConsoleInputValidation\Console\Application($kernel);
};
```

### 2. Usage

Add `InputOption`, `InputArgumnet` using `$this->getDefinition()` in configure function.

When you call `$input->getOption`, `$input->getArgument` will be called validation callback.

```php
<?php declare(strict_types=1);

namespace App\Application\Command;

use App\SymfonyConsoleInputValidation\Console\Input\InputOption as InputOptionValidation;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\{
    InputOption,
    InputInterface
};
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:command-test')]
class TestCommand extends Command
{
    protected function configure(): void
    {
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
```

## License

The symfony console input validation package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
