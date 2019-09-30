<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class BlogControllerTest extends WebTestCase
{

    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/blog');

        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            1,
            $crawler->filter('html h1')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html .article-list article')->count()
        );

        $href = $crawler
            ->filter('html .article-list article:first-child a')->attr('href');

        $link = $crawler
            ->filter('html .article-list article:first-child a')
            ->link();
        $crawler = $client->click($link);
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
        $this->assertTrue(strpos($client->getRequest()->getUri(), $href) !== false);
    }

    public function testCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/blog/create');

        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );

        $form = $crawler->selectButton('save')->form();
        // $form['title'] = 'Lucas';
        // $form['body'] = 'Lorem ipsum';
        // submit the form
        $crawler = $client->submit($form);
    }
}
