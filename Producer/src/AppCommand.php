<?php

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppCommand extends Command
{
    private HistoryService $historyController;

    public function __construct(HistoryService $historyController)
    {
        parent::__construct('app:run');
        $this->historyController = $historyController;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $progress = new ProgressBar($output);

        foreach ($this->historyController->pushHistory(new \DateTimeImmutable(), new \DateTimeImmutable()) as $i) {
            $progress->advance();
            $progress->display();
        }
        $progress->finish();
        $progress->clear();
        $output->writeln('<info>Finish</info>');
        return Command::SUCCESS;
    }
}