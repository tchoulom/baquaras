<?php
namespace Baquaras\TestBundle\Command;

use Baquaras\TestBundle\Entity\Utilisateur;
use Baquaras\TestBundle\Entity\Application;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MovePersonneCronCommand extends ContainerAwareCommand
{
 
    protected function configure()
    {
        $this
        ->setName('movepersonne:cron')
        ->setDescription('Cron job functionality update Personne file from another server ');
        //->addArgument('days', InputArgument::OPTIONAL, 'The email', 90);
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
        global $kernel;
        try {
                $serverAddress = "extractionsharpe.intra.ratp";
                $login = "kaltrans";
                $password = "baquaras001";
                $remoteFile='../../../../appli/transfert/data/emet/zu5/V2/personnes/XML/Full/personnes_Full.xml'; //Get From Harpe Server
                $remoteFileStructureMetier='../../../../appli/transfert/data/emet/zu5/V2/structuresMetier/XML/Full/structuresMetier_Full.xml'; //Get From Harpe Server
                $localFile="/appli/u07/data/recep/personnes_Full.xml";//to Baquaras Server
                $localFileStructureMetier="/appli/u07/data/recep/structuresMetier_Full.xml";//to Baquaras Server
                
                echo "\n".date('d-m-Y H:i:s').":: Connection to the Harpe server... \n";
                $conn_id = ssh2_connect($serverAddress, 22) or die("Cannot connect to the Harpe server");
                $login_result = ssh2_auth_password($conn_id, $login, $password) or die("Cannot login to the Harpe server");
                echo date('d-m-Y H:i:s').":: Connection to the Harpe server: OK \n";
				//chmod("/appli/u07/comp/html/Symfony/app/cache/dev",0777);
                echo "\n".date('d-m-Y H:i:s')."::  Transferring file personnes_Full.xml... \n";
                ssh2_scp_recv($conn_id, $remoteFile, $localFile);
                echo date('d-m-Y H:i:s').":: File personnes_Full.xml is successfully transferred \n";
                
                echo "\n".date('d-m-Y H:i:s')."::  Transferring file structuresMetier_Full.xml... \n";
                ssh2_scp_recv($conn_id, $remoteFileStructureMetier, $localFileStructureMetier);
                echo date('d-m-Y H:i:s').":: File structuresMetier_Full.xml is successfully transferred \n";
                
                echo "\n".date('d-m-Y H:i:s').":: Cleaning table utilisateur... \n";
                $utilisateur = $kernel->getContainer()->get('doctrine')->getRepository('BaquarasTestBundle:Utilisateur')->truncateTableUtilisateur();
                $em->flush();
                echo date('d-m-Y H:i:s').":: Table utilisateur is successfully cleaned \n";
                echo "\n".date('d-m-Y H:i:s').":: Updating  table utilisateur with file personnes_Full.xml... \n\n";
                //$users = simplexml_load_file($this->getContainer()->get('kernel')->getRootDir().'/../src/Baquaras/TestBundle/Entity/personnes_Full.xml');
                $users = simplexml_load_file($this->getContainer()->get('kernel')->getRootDir().'/../../../../../../appli/u07/data/recep/personnes_Full.xml');
                foreach ($users->Personnes[0]->children() as $user) {
                        $profil1 = $em->getRepository('BaquarasTestBundle:Profil')->find(1);
                        $person = new Utilisateur();
                        $person->setPrenom($user->Generique['prenom']);
                        $person->setNom($user->Generique['nom']);
                        $person->setCpteMatriculaire($user['cpteMatriculaire']);
                        $person->setMatricule($user['matricule']);
                        $person->setCivilite($user->Generique['civilite']);
                        $person->setTelephone($user->Contact['tel']);
                        $person->setMail($user->Contact['mail']);
                        $person->setProfil1($profil1);
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
                        echo date('d-m-Y H:i:s').":: ";
                        $output->writeln($user->Generique['prenom'].' '.$user->Generique['nom'].' a été ajouté');
                        $output->writeln($i);
                }
                                $i++;
                }
                echo "\n".date('d-m-Y H:i:s').":: Table utilisateur is successfully updated \n";
            } catch (Exception $e) {
                $output->writeln($e->getMessage());
            }

    }
}
