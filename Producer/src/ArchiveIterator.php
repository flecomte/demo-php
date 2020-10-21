<?php

namespace App;

class ArchiveIterator implements \Iterator
{
    private \DateTimeImmutable $begin;
    private \DateTimeImmutable $end;
    /**
     * @var false|resource
     */
    private $fileHandle;
    private string $line;
    private int $i;
    private string $tmpFilename;

    public function __construct(\DateTimeImmutable $begin, \DateTimeImmutable $end, string $cacheDir)
    {
        $this->begin = $begin;
        $this->end = $end;

        // TODO: change date
        $fileName = '2015-01-01-12.json.gz';
        $url = "http://data.gharchive.org/$fileName";
        $this->tmpFilename = "{$cacheDir}/zip/{$fileName}";

        if (!is_dir("{$cacheDir}/zip/")) {
            mkdir("{$cacheDir}/zip/");
        }

        if (copy($url, $this->tmpFilename) === false) {
            throw new \Exception("Unable to Download file $url to $this->tmpFilename");
        }

        $this->fileHandle = gzopen($this->tmpFilename, 'r');
        if ($this->fileHandle === false) {
            throw new \Exception("Cannot open file $this->tmpFilename");
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