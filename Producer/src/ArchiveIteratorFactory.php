<?php

namespace Producer;

class ArchiveIteratorFactory
{
    private string $cacheDir;

    public function __construct(string $cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    /**
     * @throws ArchiveIteratorException
     */
    public function build(string $date): ArchiveIterator
    {
        return new ArchiveIterator($date, $this->cacheDir);
    }
}