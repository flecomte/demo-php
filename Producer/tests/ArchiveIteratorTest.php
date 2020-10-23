<?php

namespace Tests\Producer;

use PHPUnit\Framework\TestCase;
use Producer\ArchiveIterator;
use Producer\ArchiveIteratorFactory;

class ArchiveIteratorTest extends TestCase
{
    public function test__construct()
    {
        $archIt = new ArchiveIterator('2015-01-01', __DIR__.'/../var/cache', __DIR__);
        $archIt->rewind();
        $this->assertEquals('{"id": "123"}', trim($archIt->current()));
        $archIt->next();
        $this->assertEquals('{"id": "4"}', trim($archIt->current()));
    }

    public function test_factory()
    {
        $archIt = (new ArchiveIteratorFactory(__DIR__.'/../var/cache', __DIR__))
            ->build('2015-01-01');
        $archIt->rewind();
        $this->assertEquals('{"id": "123"}', trim($archIt->current()));
        $archIt->next();
        $this->assertEquals('{"id": "4"}', trim($archIt->current()));
    }
}
