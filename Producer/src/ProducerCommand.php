<?php

namespace Producer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProducerCommand extends Command
{
    private HistoryService $historyService;

    public function __construct(HistoryService $historyService)
    {
        parent::__construct('app:run');
        $this->historyService = $historyService;
        $this->addArgument('date', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $progress = new ProgressBar($output);
        $date = $input->getArgument('date');
        if (!$this->validInputDate($date)) {
            $output->writeln("<error>Wrong date format</error> <comment>($date)</comment>");
            return Command::FAILURE;
        }
        try {
            foreach ($this->historyService->pushHistory($date) as $i) {
                $progress->setProgress($i);
                $progress->display();
            }
        } catch (ArchiveIteratorException $e) {
            $output->writeln("<error>{$e->getMessage()}</error>");
            return Command::FAILURE;
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