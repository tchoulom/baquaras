<?php

namespace Baquaras\AppliBundle\Tests\Entity;

use Symfony\Bundle\DoctrineBundle\Tests\TestCase;
use Baquaras\AppliBundle\Entity\Agent;

/**
 * classe qui contient les tests de la fixture
 */
class AgentFixtureTest extends TestCase
{
    /**
     * (non-PHPdoc)
     * @see Symfony\Bundle\DoctrineBundle\Tests.TestCase::setUp()
     */
    public function setUp()
    {
        $kernel = new \AppKernel('test', true);
        $kernel->boot();
        $kernel->boot();
        $this->em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
        $this->application->setAutoExit(false);
    }

    /**
     * test de la fixture
     */
    public function testFixture()
    {
        /* On réinitialise la base pour être sur de se qu'il y a dedans */
        $this->application->run(new \Symfony\Component\Console\Input\ArrayInput(array('command' => 'baquaras:drop-tables', '--confirm' => true)));
        $this->application->run(new \Symfony\Component\Console\Input\ArrayInput(array('command' => 'doctrine:generate:entities', '--no-backup' =>  true, 'name' => 'BaquarasAppliBundle')));
        $this->application->run(new \Symfony\Component\Console\Input\ArrayInput(array('command' => 'doctrine:schema:update', '--force' => true)));

        /* On ajoute les objets grâce à la fixture */
        $this->application->run(new \Symfony\Component\Console\Input\ArrayInput(array('command' => 'doctrine:fixtures:load')));

        /* On vérifie le bon fonctionnement de la fixture */
        $this->assertEquals(count($this->em->getRepository('Baquaras\AppliBundle\Entity\Agent')->findAll()), 4);
    }
}