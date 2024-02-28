<?php declare(strict_types=1);

namespace Danilovl\SymfonyConsoleInputValidation\Console\Input;

use Closure;

class InputOption extends \Symfony\Component\Console\Input\InputOption
{
    public function __construct(
        string $name,
        array|string|null $shortcut = null,
        ?int $mode = null,
        string $description = '',
        float|array|bool|int|string|null $default = null,
        array|Closure $suggestedValues = [],
        private readonly ?Closure $validation = null
    ) {
        parent::__construct($name, $shortcut, $mode, $description, $default, $suggestedValues);
    }

    public function validationValue(mixed $value): void
    {
        if ($this->validation) {
            ($this->validation)($value);
        }
    }
}
