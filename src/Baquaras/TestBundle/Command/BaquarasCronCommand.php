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
//use Symfony\Bundle\FrameworkBundle\Command\Command;

//class BaquarasCronCommand extends ContainerAwareCommand
class BaquarasCronCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('baquaras:cron')
        ->setDescription('Cron job functionality update Baquaras from Siera ');
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
            $repository = $em->getRepository('BaquarasTestBundle:Application');
            $allApplications = $repository->findAll();
            $results = $kernel->getContainer()->get('baquaras.connect_siera')->getSieraView();
            $routeName="http://d-u07.info.ratp/app_dev.php/application/";
            //Insertion de nouvelles enregistrements depuis la vue_baquas dans Application(Baquaras) 
            foreach($results as $result) {
                if($result['id_baquaras'] != null)
                {
                //if($result['id_application_siera'] == 979)
                //{
                    $oneApplication = $kernel->getContainer()->get('doctrine')->getRepository('BaquarasTestBundle:Application')->findOneBy(array('id'=>$result['id_baquaras'])); //id'=>$result['id_baquaras']
                    if($oneApplication == null)
                    {
                        //$item = $kernel->getContainer()->get('doctrine')->getRepository('BaquarasTestBundle:Application')->findOneBy(array('id'=>$result['systeme_id'])); //id'=>$result['id_baquaras']
                        //$lastAppli = $kernel->getContainer()->get('doctrine')->getRepository('BaquarasTestBundle:Application')->getLastApplication(1);
                        $application = new Application();
                        $application->setIdApplicationSiera($result['id_baquaras']);
                        //$application->setLienBaquaras($routeName.$application->getId());
                        $application->setIdClientSIERA($result['id_client_siera']);
                        $application->setNomApplicationSIERA($result['nom_application_siera']);
                        $application->setNomClientSIERA($result['nom_client_siera']);
                        $application->setDeptMoa($result['dept_moa']);
                        $application->setDeptUsers($result['dept_utilisateurs']);
                        $application->setCodeMoa($result['moa']);
                        $item = $kernel->getContainer()->get('doctrine')->getRepository('BaquarasTestBundle:Item')->findOneBy(array('id'=>$result['systeme_id'])); //id'=>$result['id_baquaras']
                        $application->setOscible($item);
                        
                        
                        echo "\n".date('d-m-Y H:i:s').":: Inserting application into Baquaras server from Siera server... \n";
                        
                        $em->persist($application);
                        $em->flush();//L application est enregistré
                        // Refresh my entity (populate the identifier)
                        //$em->refresh($application);
                        $lastAppli = $kernel->getContainer()->get('doctrine')->getRepository('BaquarasTestBundle:Application')->getLastApplication(1);
                        //$application->setLienBaquaras($routeName.$application->getId());
                        
                        echo "\t".date('d-m-Y H:i:s').":: Updating table utilisateur(cptematriculaire) into Baquaras server... \n";
                        
                        foreach ($lastAppli[0]->getUtilisateur() as $userAppli)
                        {
                            if(($userAppli != null) && is_object($userAppli))
                            {
                                $userAppli->setCpteMatriculaire($result['moe']);
                                $em->persist($userAppli);
                            }
                        }
                        $architectureAppli = $lastAppli[0]->getArchitecture();
                        
                        echo "\t".date('d-m-Y H:i:s').":: Updating table architectureapplication(url_intranet, url_extranet) into Baquaras server... \n";
                        
                        if(($architectureAppli != null) && is_object($architectureAppli))
                        {
                            $architectureAppli->setUrlIntranet($result['url_intranet']);
                            $architectureAppli->setUrlExtranet($result['url_extranet']);
                            $em->persist($architectureAppli);
                        }
                        
                        $insertResult = $kernel->getContainer()->get('doctrine')->getRepository('BaquarasTestBundle:Application')->updateLastInsertedAppli($lastAppli[0]->getId(), $result['id_baquaras']); //Modifer apres $result['id_application_siera'] par $result['id_baquaras']
                        $insertResult = $kernel->getContainer()->get('doctrine')->getRepository('BaquarasTestBundle:Application')->updateLienBaquarasLastInsertedAppli($result['id_baquaras'], $routeName.$result['id_baquaras']); //Modifer apres $result['id_application_siera'] par $result['id_baquaras']
                        $em->flush();
                        
                        echo "\t".date('d-m-Y H:i:s').":: Application ID: ".$result['id_baquaras']." is successfully inserted into Baquaras server \n";
                        echo "\t".date('d-m-Y H:i:s').":: Table utilisateur(cptematriculaire) is successfully updated into Baquaras server \n";
                        echo "\t".date('d-m-Y H:i:s').":: Table architectureapplication(url_intranet, url_extranet) is successfully updated into Baquaras server \n";
                    }
                //}
                //Mise à jour depuis la vue Siera dans Baquaras
                foreach($allApplications as $application) {
                    if($result['id_baquaras'] == $application->getId()) {
                    //if(($result['id_client_siera'] == 429) && ($application->getId() == 3)) { //Pour Tester la mise à jour
                        $application->setIdApplicationSiera($result['id_baquaras']);//id_application_siera
                        $application->setLienBaquaras($routeName.$application->getId());
                        $application->setIdClientSIERA($result['id_client_siera']);
                        $application->setNomApplicationSIERA($result['nom_application_siera']);
                        $application->setNomClientSIERA($result['nom_client_siera']);
                        $application->setDeptMoa($result['dept_moa']);
                        $application->setDeptUsers($result['dept_utilisateurs']);
                        $application->setCodeMoa($result['moa']);
                        $item = $kernel->getContainer()->get('doctrine')->getRepository('BaquarasTestBundle:Item')->findOneBy(array('id'=>$result['systeme_id'])); //id'=>$result['id_baquaras']
                        $application->setOscible($item);
                        
                        echo "\n".date('d-m-Y H:i:s').":: Updating application into Baquaras server from Siera server... \n";
                        
                        $em->persist($application);
                        
                        echo "\t".date('d-m-Y H:i:s').":: Updating table utilisateur(cptematriculaire) into Baquaras server... \n";
                        
                        foreach($application->getUtilisateur() as $user) {
                            if(($user != null) && is_object($user))
                            {
                                $user->setCpteMatriculaire($result['moe']);
                                $em->persist($user);
                            }
                        }
                        $architectureAppli = $application->getArchitecture();
                        
                        echo "\t".date('d-m-Y H:i:s').":: Updating table architectureapplication(url_intranet, url_extranet) into Baquaras server... \n";
                        
                        if(($architectureAppli != null) && is_object($architectureAppli))
                        {
                            $architectureAppli->setUrlIntranet($result['url_intranet']);
                            $architectureAppli->setUrlExtranet($result['url_extranet']);
                            $em->persist($architectureAppli);
                        }
                        
                    }
                }
                }
            }//End Foreach 1
            $em->flush();
            
            if($result['id_baquaras'] != null)
            {
                echo "\t\n".date('d-m-Y H:i:s').":: Applications are successfully inserted into Baquaras server from Siera server. \n";
                echo "\t\n".date('d-m-Y H:i:s').":: Table utilisateur(cptematriculaire) is successfully updated on Baquaras server. \n";
                echo "\t\n".date('d-m-Y H:i:s').":: Table architectureapplication(url_intranet, url_extranet) is successfully updated on Baquaras server. \n";
            }
            else
                echo "\n".date('d-m-Y H:i:s').":: No modification has been done. \n";
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
        }

    }
}
