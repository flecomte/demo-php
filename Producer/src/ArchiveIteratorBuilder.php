<?php

namespace App;

class ArchiveIteratorBuilder
{
    private string $cacheDir;

    public function __construct(string $cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    public function build(string $date)
    {
        return new ArchiveIterator($date, $this->cacheDir);
    }
}