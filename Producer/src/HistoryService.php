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

    public function pushHistory(\DateTimeImmutable $begin, \DateTimeImmutable $end): \Generator
    {
        $i = 0;
        foreach ($this->archiveIteratorBuilder->build($begin, $end) as $lineContent) {
            $this->producer->send($lineContent);
            yield ++$i;
        }
    }
}