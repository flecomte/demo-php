<?php

namespace App;

class ArchiveIterator implements \Iterator
{
    /**
     * @var false|resource
     */
    private $fileHandle;
    private string $line;
    private int $i;
    private string $tmpFilename;

    /**
     * @throws ArchiveIteratorException
     */
    public function __construct(string $date, string $cacheDir)
    {
        $fileName = "$date.json.gz";
        $url = "http://data.gharchive.org/$fileName";
        $this->tmpFilename = "{$cacheDir}/zip/{$fileName}";

        if (!is_dir("{$cacheDir}/zip/")) {
            mkdir("{$cacheDir}/zip/");
        }

        if (copy($url, $this->tmpFilename) === false) {
            throw new ArchiveIteratorException("Unable to Download file $url to $this->tmpFilename");
        }

        $this->fileHandle = gzopen($this->tmpFilename, 'r');
        if ($this->fileHandle === false) {
            throw new ArchiveIteratorException("Cannot open file $this->tmpFilename");
        }
    }

    public function rewind()
    {
        gzseek($this->fileHandle, 0);
        $this->line = gzgets($this->fileHandle);
        $this->i = 0;
    }

    public function valid(): bool
    {
        return false !== $this->line &&  !gzeof($this->fileHandle);
    }

    public function current(): string
    {
        return $this->line;
    }

    public function key()
    {
        return $this->i;
    }

    public function next()
    {
        if (false !== $this->line) {
            $this->line = gzgets($this->fileHandle);
            $this->i++;
        }
    }

    public function __destruct()
    {
        gzclose($this->fileHandle);
        unlink($this->tmpFilename);
    }
}