<?php

namespace App;

class HistoryService
{
    private ArchiveIteratorBuilder $archiveIteratorBuilder;

    public function __construct(ArchiveIteratorBuilder $archiveIteratorBuilder)
    {
        $this->archiveIteratorBuilder = $archiveIteratorBuilder;
    }

    public function pushHistory(\DateTimeImmutable $begin, \DateTimeImmutable $end): \Generator
    {
        $i = 0;
        foreach ($this->archiveIteratorBuilder->build($begin, $end) as $item) {
            yield ++$i;
        }
    }
}