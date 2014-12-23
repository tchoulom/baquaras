<?php

namespace Baquaras\AppliBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * classe qui contient les tests de AppliController
 * @author eh712273
 *
 */
class AppliControllerTest extends WebTestCase
{
    /**
     * méthode qui test que la page n'est pas vide
     */
    public function testAcceuil()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertNotEmpty($crawler);
    }
}
