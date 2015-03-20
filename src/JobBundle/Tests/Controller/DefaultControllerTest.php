<?php

namespace JobBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DefaultControllerTest extends WebTestCase
{
    public function testEsIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/es/');
        var_dump($crawler->filter('a.bntLink')->text());
        $this->assertGreaterThan(0, $crawler->filter("h2")->count());
        $this->assertTrue($crawler->filter('a.bntLink')->text() == "Ver en detalle »");
    }
    public function testEnIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/en/');
        var_dump($crawler->filter('a.bntLink')->text());
        $this->assertTrue($crawler->filter('a.bntLink')->text() == "View details »");
    }
}