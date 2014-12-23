<?php
namespace Baquaras\AppliBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Baquaras\AppliBundle\Entity\Agent;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAgentData implements FixtureInterface
{
    /**
     * fonction qui charge des données en base dès sa construction
     * (non-PHPdoc)
     * @see Doctrine\Common\DataFixtures.FixtureInterface::load()
     */
    public function load(ObjectManager $manager)
    {
    	$agent_1 = new Agent();
    	$agent_1->setMatricule('EL207300');
    	$agent_1->setCivilite('MR');
    	$agent_1->setNom('LUCAS');
    	$agent_1->setPrenom('Eric');
    	$agent_1->setStructuremetiernom('SIT/SIE/SNT');
    	$agent_1->setMail('eric.lucas@ratp.fr');
    	$agent_1->setTel('0158779878');
    	$agent_1->setLocalisationnom('NOISY-LE-GRAND ~ 102 ADMINISTRATIF ~ B ~ 2ème étage  ~ B2044');
    	$agent_1->setCategorie('CADRE');
    	$agent_1->setStatut('PERMANENT');
    	
        $agent_2 = new Agent();
        $agent_2->setMatricule('LC236620');
        $agent_2->setCivilite('MR');
        $agent_2->setNom('COTTEREAU');
        $agent_2->setPrenom('Laurent');
        $agent_2->setStructuremetiernom('SIT/SIE/SNT');
        $agent_2->setMail('laurent.cottereau@ratp.fr');
        $agent_2->setTel('0158779618');
        $agent_2->setLocalisationnom('NOISY-LE-GRAND ~ 102 ADMINISTRATIF ~ B ~ 2ème étage  ~ B2044');
        $agent_2->setCategorie('CADRE');
        $agent_2->setStatut('PERMANENT');

        $agent_3 = new Agent();
        $agent_3->setMatricule('LH712825');
        $agent_3->setCivilite('MR');
        $agent_3->setNom('HOANG');
        $agent_3->setPrenom('Lang');
        $agent_3->setStructuremetiernom('SIT/SIE/SNT');
        $agent_3->setMail('lang.hoang@ratp.fr');
        $agent_3->setTel('0158779254');
        $agent_3->setLocalisationnom('NOISY-LE-GRAND ~ 102 ADMINISTRATIF ~ B ~ 2ème étage  ~ B2028');
        $agent_3->setCategorie('CADRE');
        $agent_3->setStatut('PERMANENT');

        $agent_4 = new Agent();
        $agent_4->setMatricule('PV709439');
        $agent_4->setCivilite('MR');
        $agent_4->setNom('VONCKEN');
        $agent_4->setPrenom('Philippe');
        $agent_4->setStructuremetiernom('SIT/SIE/SNT');
        $agent_4->setMail('philippe.voncken@ratp.fr');
        $agent_4->setTel('0158779326');
        $agent_4->setLocalisationnom('NOISY-LE-GRAND ~ 102 ADMINISTRATIF ~ B ~ 2ème étage  ~ B2028');
        $agent_4->setCategorie('CADRE');
        $agent_4->setStatut('PERMANENT');

        $manager->persist($agent_1);
        $manager->persist($agent_2);
        $manager->persist($agent_3);
        $manager->persist($agent_4);
        $manager->flush();
    }
}