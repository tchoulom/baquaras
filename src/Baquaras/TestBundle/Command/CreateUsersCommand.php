<?php
namespace Baquaras\TestBundle\Command;

use Baquaras\TestBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUsersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('create:users')
        ->setDescription('insérer des utilisateurs dans la base de données');
    }
    
    /*
     * Command to insert users from xml file
     * 
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0); 
        ini_set("memory_limit", -1);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $batchSize = 20;
        $i=1;
        try {
            $users = simplexml_load_file($this->getContainer()->get('kernel')->getRootDir().'/../src/Baquaras/TestBundle/Entity/personnes_Full.xml');
            foreach ($users->Personnes[0]->children() as $user) {
                //$profil1 = $em->getRepository('BaquarasTestBundle:Profil')->find(1);
                $person = new Utilisateur();
                $person->setPrenom($user->Generique['prenom']);
                $person->setNom($user->Generique['nom']);
                $person->setCpteMatriculaire($user['cpteMatriculaire']);
                $person->setMatricule($user['matricule']);
                $person->setCivilite($user->Generique['civilite']);
                $person->setTelephone($user->Contact['tel']);
                $person->setMail($user->Contact['mail']);
                $person->setProfil1();
                $validator = $this->getContainer()->get('validator');
                $errors = $validator->validate($person);
                if (count($errors) > 0) {
                    foreach($errors as $error) {
                       $output->writeln($error->getMessage());
                    }
                    } else {
                        $em->persist($person);
                        if (($i % $batchSize) == 0) {
                             $em->flush();
                             $em->clear();
                }
                $output->writeln($user->Generique['prenom'].' '.$user->Generique['nom'].' a été ajouté');
                $output->writeln($i);
            }
                    $i++;
            }
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
        }

    }
}
