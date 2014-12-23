<?php
namespace Baquaras\AppliBundle\Tests\Command;

use Baquaras\AppliBundle\Tests\Entity\AgentEntityTest;
use Symfony\Bundle\DoctrineBundle\Tests\TestCase;

/**
 * classe qui contient les tests de la commande ConfigureTablespaces
 *
 */
class ConfigureTablespacesTest extends TestCase
{
    /**
     * (non-PHPdoc)
     * @see Symfony\Bundle\DoctrineBundle\Tests.TestCase::setUp()
     */
    public function setUp()
    {
        $kernel = new \AppKernel('test', true);
        $kernel->boot();
        $this->em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
        $this->application->setAutoExit(false);
    }

    /**
     * test de la commande ConfigureTablespaces
     */
    public function testConfigureTablespaces()
    {
        $this->application->run(new \Symfony\Component\Console\Input\ArrayInput(array('command' => 'baquaras:configure-tablespaces')));
    }
}