<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StartTest extends WebTestCase {

    public function testLive() {

        $client = static::createClient(['environment' => 'dev']);

        $name = "John";
        $client->request('GET', "/live/$name");

        $this->assertEquals("Olá, John! Estamos ao vivo.", $client->getResponse()->getContent());

    }

}
