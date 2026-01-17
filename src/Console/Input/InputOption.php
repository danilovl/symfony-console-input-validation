<?php declare(strict_types=1);

namespace Danilovl\SymfonyConsoleInputValidation\Console\Input;

use Closure;
use Symfony\Component\Console\Completion\{
    Suggestion,
    CompletionInput,
    CompletionSuggestions
};

class InputOption extends \Symfony\Component\Console\Input\InputOption
{
    /**
     * @param string|array<mixed>|null $shortcut
     * @param string|bool|int|float|array<mixed>|null $default
     * @param array<mixed>|Closure(CompletionInput,CompletionSuggestions):list<string|Suggestion> $suggestedValues
     */
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
