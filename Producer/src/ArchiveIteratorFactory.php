<?php

namespace Producer;

class ArchiveIteratorFactory
{
    private string $cacheDir;
    private string $baseUrl;

    public function __construct(string $cacheDir, string $baseUrl)
    {
        $this->cacheDir = $cacheDir;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @throws ArchiveIteratorException
     */
    public function build(string $date): ArchiveIterator
    {
        return new ArchiveIterator($date, $this->cacheDir, $this->baseUrl);
    }
}