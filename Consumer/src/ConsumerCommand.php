<?php

namespace Consumer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumerCommand extends Command
{
    private HistoryService $historyService;

    public function __construct(HistoryService $historyService)
    {
        parent::__construct('app:run');
        $this->historyService = $historyService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("press CTRL+C to cancel");
        $this->historyService->saveHistoryFromQueue();
        $output->writeln('<info>Finish</info>');
        return Command::SUCCESS;
    }
}