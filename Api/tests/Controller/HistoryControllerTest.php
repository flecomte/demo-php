<?php

namespace Api\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HistoryControllerTest extends WebTestCase
{
    public function testGetHistory()
    {
        $client = static::createClient();

        $client->request('GET', '/history/2015-01-01?tag=love');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
