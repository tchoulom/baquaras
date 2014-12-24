<?php
namespace Baquaras\TestBundle\Command;

use Baquaras\TestBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class createUsersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('create:users')
        ->setDescription('inserer des utilisateur dans la base de données');
    }
    
    /*
     * Command to insert users from xml file
     * 
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $em = $this->getContainer()->get('doctrine')->getManager();
            $users = simplexml_load_file($this->getContainer()->get('kernel')->getRootDir().'/../src/Baquaras/TestBundle/Entity/personnes_Full.xml');
            foreach ($users->Personnes[0]->children() as $user) {
                $person = new Utilisateur();
                $person->setPrenom($user->Generique['prenom']);
                $person->setNom($user->Generique['nom']);
                $person->setCpteMatriculaire($user['cpteMatriculaire']);
                $person->setMatricule($user['matricule']);
                $person->setCivilite($user->Generique['civilite']);
                $person->setTelephone($user->Contact['tel']);
                $person->setMail($user->Contact['mail']);
                $validator = $this->getContainer()->get('validator');
                $errors = $validator->validate($person);
                if (count($errors) > 0) {
                    $output->writeln($errors);
                }
                $em->persist($user);
                $output->writeln($user->Generique['prenom'].' '.$user->Generique['nom'].' a été ajouté');
            }
            $em->flush();
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
        }

    }
}
