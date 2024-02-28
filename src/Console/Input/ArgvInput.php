<?php declare(strict_types=1);

namespace Danilovl\SymfonyConsoleInputValidation\Console\Input;

use Override;

class ArgvInput extends \Symfony\Component\Console\Input\ArgvInput
{
    #[Override]
    public function getOption(string $name): mixed
    {
        $value = parent::getOption($name);

        $option = $this->definition->getOption($name);
        if ($option instanceof InputOption) {
            $option->validationValue($value);
        }

        return $value;
    }

    #[Override]
    public function getArgument(string $name): mixed
    {
        $value = parent::getArgument($name);

        $option = $this->definition->getArgument($name);
        if ($option instanceof InputArgument) {
            $option->validationValue($value);
        }

        return $value;
    }
}
