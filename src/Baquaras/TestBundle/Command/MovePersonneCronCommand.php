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
                //$remoteFile = "ftp://kaltrans:baquaras001@extractionsharpe.intra.ratp/appli/transfert/data/emet/zu5/V2/personnes/XML/Full/personnes_Full.xml";
				$remoteFile='../../../../appli/transfert/data/emet/zu5/V2/personnes/XML/Full/personnes_Full.xml';
				//$localFile="C:\\tmp\\personnes_Full.xml";
				$localFile=".//src//Baquaras//TestBundle//Entity//personnes_Full.xml";
                
                $conn_id = ssh2_connect($serverAddress, 22) or die("Cannot connect to the Harpe server");
                $login_result = ssh2_auth_password($conn_id, $login, $password) or die("Cannot login to the Harpe server");
				//chmod("../../../../appli/transfert/data/emet/zu5/V2/personnes/XML/Full/personnes_Full.xml",0600);
                ssh2_scp_recv($conn_id, $remoteFile, $localFile);
				echo "File successfully transferred \n";
				
				//$kernel->query('TRUNCATE TABLE utilisateur');
				$utilisateur = $kernel->getContainer()->get('doctrine')->getRepository('BaquarasTestBundle:Utilisateur')->truncateTableUtilisateur();
				$em->flush();
				$users = simplexml_load_file($this->getContainer()->get('kernel')->getRootDir().'/../src/Baquaras/TestBundle/Entity/personnes_Full.xml');
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
					$output->writeln($user->Generique['prenom'].' '.$user->Generique['nom'].' a été ajouté');
					$output->writeln($i);
				}
						$i++;
				}
				echo "Table utilisateur successfully updated \n";
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
        }

    }
}
