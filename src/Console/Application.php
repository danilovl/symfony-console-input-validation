<?php declare(strict_types=1);

namespace Danilovl\SymfonyConsoleInputValidation\Console;

use Danilovl\SymfonyConsoleInputValidation\Console\Input\ArgvInput;
use Override;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends \Symfony\Bundle\FrameworkBundle\Console\Application
{
    #[Override]
    public function doRun(InputInterface $input, OutputInterface $output): int
    {
        return parent::doRun(new ArgvInput, $output);
    }
}
