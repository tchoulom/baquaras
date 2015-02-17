<?php
namespace Baquaras\TestBundle\Command;

use Baquaras\TestBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;

class BaquarasCronCommand extends ContainerAwareCommand
{
    
     private $container;
     private $connection;

     public function __construct(Container $container)
     {
        $this->container = $container;
        $this->connection = $this->container->get('doctrine.dbal.siera_connection');
     }
        
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
        try {
            $repository = $this->getDoctrine()->getManager()->getRepository('BaquarasTestBundle:Application');
            $allApplications = $repository->findAll();
            $results = $container->get('baquaras.connect_siera')->getSieraView();
            foreach($results as $result) {
                /*if($result['moe'] ) {
                   $moe = $container->get('doctrine')->getRepository('BaquarasTestBundle:Utilisateur')->findOneBy(array('cpteMatriculaire'=>$result['moe']));
                  $application->addUtilisateur($moe);
                }*/
                foreach($allApplications as $application) {
                    if($result['id_baquaras'] == $application['id']) {
                      $application->setCodeMoa($result['moa']);
                      $em->persist($application);
                      foreach($user as $application->getUtilisateur) {
                          $user->setCpteMatriculaire($result['moe']);
                          $em->persist($user);
                      }
                      //$em->persist($application);
                    }
                }
            }
            $em->flush();
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
        }

    }
}
