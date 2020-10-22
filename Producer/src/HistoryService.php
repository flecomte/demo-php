<?php

namespace App;

class HistoryService
{
    private ArchiveIteratorFactory $archiveIteratorBuilder;
    private Producer $producer;

    public function __construct(ArchiveIteratorFactory $archiveIteratorBuilder, Producer $producer)
    {
        $this->archiveIteratorBuilder = $archiveIteratorBuilder;
        $this->producer = $producer;
    }

    /**
     * @throws ArchiveIteratorException
     */
    public function pushHistory(string $date): \Generator
    {
        $i = 0;
        foreach ($this->archiveIteratorBuilder->build($date) as $lineContent) {
            $this->producer->send($lineContent);
            yield ++$i;
        }
    }
}