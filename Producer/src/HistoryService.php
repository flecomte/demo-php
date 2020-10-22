<?php

namespace App;

class HistoryService
{
    private ArchiveIteratorBuilder $archiveIteratorBuilder;
    private Producer $producer;

    public function __construct(ArchiveIteratorBuilder $archiveIteratorBuilder, Producer $producer)
    {
        $this->archiveIteratorBuilder = $archiveIteratorBuilder;
        $this->producer = $producer;
    }

    public function pushHistory(string $date): \Generator
    {
        $i = 0;
        foreach ($this->archiveIteratorBuilder->build($date) as $lineContent) {
            $this->producer->send($lineContent);
            yield ++$i;
        }
    }
}