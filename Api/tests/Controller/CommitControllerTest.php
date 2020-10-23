<?php

namespace Api\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommitControllerTest extends WebTestCase
{
    public function testGetCommit()
    {
        $client = static::createClient();

        $client->request('GET', '/commits/2015-01-01?tag=love');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
