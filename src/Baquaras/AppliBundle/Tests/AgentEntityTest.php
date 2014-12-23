<?php

namespace Baquaras\AppliBundle\Tests\Entity;

use Symfony\Bundle\DoctrineBundle\Tests\TestCase;
use Baquaras\AppliBundle\Entity\Agent;

/**
 * classe qui contient les tests de l'entité Agent
 *
 */
class AgentEntityTest extends TestCase
{
    /**
     * @var Container $em contient l'entity manager
     */
    private $em;

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
     * méthode qui test L'entité Agent
     */
    public function testNewAgent()
    {
        /* On vide la base pour être sur de ce qu'il y a dedans */
        $this->application->run(new \Symfony\Component\Console\Input\ArrayInput(array('command' => 'baquaras:drop-tables', '--confirm' => true)));
        $this->application->run(new \Symfony\Component\Console\Input\ArrayInput(array('command' => 'doctrine:schema:create')));

        /* On cré un nouvel Agent */
        $user = new \Baquaras\AppliBundle\Entity\Agent;
        $user->setMatricule('eh712273');
        $user->setCivilite('Mlle');
        $user->setNom('Harkou');
        $user->setPrenom('Elodie');
        $user->setStructuremetiernom('SIT/CPS/SNT');
        $user->setMail('elodie.harkou@ratp.fr');
        $user->setTel('0633233198');
        $user->setLocalisationnom('NOISY-LE-GRAND - ESPLANADE DE LA COMMUNE DE PARIS ~ 102 ADMINISTRATIF ~ BATIMENT B ~ 2ème étage  ~ B2028 - B2028');
        $user->setCategorie('Stagière');
        $user->setStatut('Temporaire');
        $this->em->persist($user);
        $this->em->flush();

        /* on vérifie que l'agent a bien été ajouté */
        $this->assertEquals(count($this->em->getRepository('Baquaras\AppliBundle\Entity\Agent')->findAll()), 1);
    }
}