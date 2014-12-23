<?php

namespace Baquaras\AppliBundle\Tests\Command;

use Baquaras\AppliBundle\Tests\Entity\AgentEntityTest;
use Symfony\Bundle\DoctrineBundle\Tests\TestCase;

/**
 * classe qui contient les tests de la commande DropTables
 *
 */
class DropTablesCommandTest extends TestCase
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
     * méthode qui test DropTables
     */
    public function testDropTables()
    {
        /* On vide lance la commande drop-tables en confirmant */
        $this->application->run(new \Symfony\Component\Console\Input\ArrayInput(array('command' => 'baquaras:drop-tables', '--confirm' => true)));
        $this->application->run(new \Symfony\Component\Console\Input\ArrayInput(array('command' => 'doctrine:generate:entities', '--no-backup' =>  true, 'name' => 'RatpAppliBundle')));
        $this->application->run(new \Symfony\Component\Console\Input\ArrayInput(array('command' => 'doctrine:schema:update', '--force' => true)));

        /* On vérifie que la base est bien vide */
        $this->assertEmpty($this->em->getRepository('Baquaras\AppliBundle\Entity\Agent')->findAll());

        /* On ajoute un objet en base */
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

        /* On lance la commande drop-tables en ne confirmant pas */
        $this->application->run(new \Symfony\Component\Console\Input\ArrayInput(array('command' => 'baquaras:drop-tables', '--notConfirm' => true)));

        /* On vérifie qu'il y a bien 1 objet en base */
        $this->assertTrue(count($this->em->getRepository('Baquaras\AppliBundle\Entity\Agent')->findAll()) == 1);
    }
}