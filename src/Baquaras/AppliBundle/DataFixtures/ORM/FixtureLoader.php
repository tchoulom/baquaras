<?php
/**
 * Fixture qui charge des utilisateurs de l'appli en base
 */
namespace Baquaras\AppliBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Baquaras\AppliBundle\Entity\AppliUser;
use Baquaras\AppliBundle\Entity\Role;
use Doctrine\Common\Persistence\ObjectManager;

class FixtureLoader implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // création des roles utilisateur
        $roleAdmin = new Role();
        $roleAdmin->setName('ROLE_ADMIN');
        $roleUser = new Role();
        $roleUser->setName('ROLE_USER');

        $manager->persist($roleAdmin);
        $manager->persist($roleUser);

        // on cré des utilisateurs
        $user1 = new AppliUser();
        $user1->setUsername('EL207300');
        $user1->getUserRoles()->add($roleAdmin);

        $user2 = new AppliUser();
        $user2->setUsername('LC236620');
        $user2->getUserRoles()->add($roleAdmin);

        $user3 = new AppliUser();
        $user3->setUsername('LH712825');
        $user3->getUserRoles()->add($roleAdmin);

        $user4 = new AppliUser();
        $user4->setUsername('PV709439');
        $user4->getUserRoles()->add($roleUser);

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);
        $manager->flush();
    }
}