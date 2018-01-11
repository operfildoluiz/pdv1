<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StartTest extends WebTestCase {

    public function testLive() {

        $client = static::createClient(['environment' => 'dev']);
        $client->request('GET', "/echo");

        $this->assertEquals("Live", $client->getResponse()->getContent());

    }

}
