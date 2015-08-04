<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($crawler->filter('html:contains("Homepage")')->count() > 0);
    }

    public function testEmailChange()
    {
        $client = static::createClient();
        
        $newEmail = "test" . rand (1,999) . "@example.com";
        $client->request('PUT', '/api/email/change/leonardo', array('user' => array('email' => $newEmail), 'password' => 'SecretPassword'));
        $this->assertEquals(204, $client->getResponse()->getStatusCode(), 'HTTP code is not 204');

        $incorrectEmail = "incorrect.email";
        $client->request('PUT', '/api/email/change/leonardo', array('user' => array('email' => $newEmail), 'password' => 'OtherPassword'));
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'), 'Invalid JSON response');
        $this->assertEquals(400, $client->getResponse()->getStatusCode(), 'HTTP code is not 400');
        
        $incorrectEmail = "incorrect.email";
        $client->request('PUT', '/api/email/change/leonardo', array('user' => array('email' => $incorrectEmail), 'password' => 'SecretPassword'));
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'), 'Invalid JSON response');
        $this->assertEquals(400, $client->getResponse()->getStatusCode(), 'HTTP code is not 400');
        
        $client->request('PUT', '/api/email/change/leonardo', array());
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'), 'Invalid JSON response');
        $this->assertEquals(400, $client->getResponse()->getStatusCode(), 'HTTP code is not 400');

        $client->request('PUT', '/api/email/change/999999', array('user' => array('email' => "test@o2.pl"), 'password' => 'SecretPassword'));
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'), 'Invalid JSON response');
        $this->assertEquals(404, $client->getResponse()->getStatusCode(), 'HTTP code is not 404');
        
        $client->request('POST', '/api/email/change/leonardo', array('user' => array('email' => "test@o2.pl"), 'password' => 'SecretPassword'));
        $this->assertEquals(405, $client->getResponse()->getStatusCode(), 'HTTP code is not 405');
    }
}
