<?php

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppCommand extends Command
{
    private HistoryService $historyController;

    public function __construct(HistoryService $historyController)
    {
        parent::__construct('app:run');
        $this->historyController = $historyController;
        $this->addArgument('date', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $progress = new ProgressBar($output);
        $date = $input->getArgument('date');
        if (!$this->validInputDate($date)) {
            $output->writeln("<error>Wrong date format</error> <comment>($date)</comment>");
            return Command::FAILURE;
        }
        foreach ($this->historyController->pushHistory($date) as $i) {
            $progress->setProgress($i);
            $progress->display();
        }
        $progress->finish();
        $progress->clear();
        $output->writeln('<info>Finish</info>');
        return Command::SUCCESS;
    }

    private function validInputDate(string $date): bool
    {
        return preg_match('`^[0-9]{4}-[0-1]?[0-9]-([0-3]?[0-9]|\{[0-3]?[0-9]\.\.[0-3]?[0-9]})(-([0-9]{2}|\{[0-3]?[0-9]\.\.[0-3]?[0-9]}))?$`', $date) != false;
    }
}