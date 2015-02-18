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

class BaquarasCronCommand extends ContainerAwareCommand
{
     /*private $container;
     private $connection;

     public function __construct(Container $container)
     {
        $this->container = $container;
        $this->connection = $this->container->get('doctrine.dbal.siera_connection');
     }*/
        
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
            //$userLogService = $this->container->get('eco_user.userLogs');  //Appel du service "userLogs"
            foreach($results as $result) {
                //Insertion depuis la vue Siera dans Baquaras
                /*
                 $oneApplication = $kernel->getContainer()->get('doctrine')->getRepository('BaquarasTestBundle:Application')->findOneBy(array('id'=>$result['id_baquaras']));
                if($oneApplication == null)
                    $application = $kernel->getContainer()->get('doctrine')->getRepository('BaquarasTestBundle:Application')->createAppliInBaquaras($result['id_baquaras'], $result['id_client_siera'], $result['nom_application_siera'], $result['dept_moa'], $result['dept_utilisateurs'], $result['moa']);
                 */
                if($result['id_application_siera'] == 1018)
                {
                    $oneApplication = $kernel->getContainer()->get('doctrine')->getRepository('BaquarasTestBundle:Application')->findOneBy(array('id'=>$result['id_application_siera'])); //id'=>$result['id_baquaras']
                    if($oneApplication == null){
                        //$application = $kernel->getContainer()->get('doctrine')->getRepository('BaquarasTestBundle:Application')->createAppliInBaquaras($result['id_application_siera'], $result['id_client_siera'], $result['nom_application_siera'], $result['dept_moa'], $result['dept_utilisateurs'], $result['moa']);
                        $application = new Application();
                        $application->setIdClientSIERA($result['id_client_siera']);
                        $application->setNomApplicationSIERA($result['nom_application_siera']);
                        $application->setDeptMoa($result['dept_moa']);
                        $application->setDeptUsers($result['dept_utilisateurs']);
                        $application->setCodeMoa($result['moa']);
                        $em->persist($application);
                        $em->flush();
                        $application = $kernel->getContainer()->get('doctrine')->getRepository('BaquarasTestBundle:Application')->updateLastInsertedAppli($application->getId(), $result['id_application_siera']); //Modifer apres $result['id_application_siera'] par $result['id_baquaras']
                        $em->flush();
                    }
                }
                //Mise à jour depuis la vue Siera dans Baquaras
                foreach($allApplications as $application) {
                    //if($result['id_baquaras'] == $application->getId()) {
                    if(($result['id_client_siera'] == 43) && ($application->getId() == 2)) { //Pour Tester la mise à jour
                      $application->setIdClientSIERA($result['id_client_siera']);
                      $application->setNomApplicationSIERA($result['nom_application_siera']);
                      $application->setDeptMoa($result['dept_moa']);
                      $application->setDeptUsers($result['dept_utilisateurs']);
                      $application->setCodeMoa($result['moa']);
                      $em->persist($application);
                      foreach($application->getUtilisateur() as $user) {
                          $user->setCpteMatriculaire($result['moe']);
                          $em->persist($user);
                      }              
                    }
                }
            }
            $em->flush();
            //$application = $kernel->getContainer()->get('doctrine')->getRepository('BaquarasTestBundle:Application')->updateLastInsertedAppli($application->getId(), $result['id_client_siera']); //Modifer apres $result['id_client_siera'] par $result['id_baquaras']
            //$em->flush();
            
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
        }

    }
}
