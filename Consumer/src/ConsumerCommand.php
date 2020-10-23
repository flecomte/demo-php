<?php

namespace Consumer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumerCommand extends Command
{
    private CommitService $commitService;

    public function __construct(CommitService $commitService)
    {
        parent::__construct('app:run');
        $this->commitService = $commitService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("press CTRL+C to cancel");
        $this->commitService->saveCommitsFromQueue();
        $output->writeln('<info>Finish</info>');
        return Command::SUCCESS;
    }
}