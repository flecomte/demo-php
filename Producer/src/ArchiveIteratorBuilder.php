<?php

namespace App;

class ArchiveIteratorBuilder
{
    private string $cacheDir;

    public function __construct(string $cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    public function build(\DateTimeImmutable $begin, \DateTimeImmutable $end)
    {
        return new ArchiveIterator($begin, $end, $this->cacheDir);
    }
}