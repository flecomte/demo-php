<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppCommand extends Command
{
    protected static $defaultName = 'app:run';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Test OK');
        return Command::SUCCESS;
    }
}