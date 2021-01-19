<?php

namespace Medstor\CatalogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/catalog/category/new',
        array(
            'title' => 'Test Title',
            'url_key' => 'Test urlKey',
            'description' => 'Test description',
            )
    
        );

        $response = $client->getResponse();

    
        $this->assertJsonResponse($response, 200);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

    protected function assertJsonResponse($response, $statusCode = 200)
    {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }
}
