<?php

namespace Baquaras\AppliBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * classe qui contient les tests de DefaultController
 * @author eh712273
 *
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * méthode qui test la page générée par DefaultController
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'http://pc137300.noisy.ratp:8060/hello/toi');
        $this->assertEquals($crawler->filter('html:contains("Hello")')->count(), 1);
    }
}
