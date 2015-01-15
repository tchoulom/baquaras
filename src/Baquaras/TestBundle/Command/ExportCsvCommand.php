<?php
namespace Baquaras\TestBundle\Command;

use Baquaras\TestBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ExportCsvCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('export:applications')
        ->setDescription('exporter les applications dans un fichier csv');
    }
    
    /*
     * Command to insert users from xml file
     * 
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
       
        $iterableResult = $em->getRepository('BaquarasTestBundle:Application')->createQueryBuilder('a')->getQuery()->iterate();
        
        $handle = fopen('applications.csv', 'a+');
        $header = array();

        while (false !== ($row = $iterableResult->next())) {
            foreach($row[0] as $r) {
                var_dump($r); exit;
               fputcsv($handle, $r); 
            }
           // var_dump($row[0]); exit;
            
            $em->detach($row[0]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);
    //    header('Content-type: application/csv');
      //  header('Content-Disposition: attachment; filename="applications.csv"');
        //readfile('applications.csv');
      /*  return new Response($content, 200, array(
            'Content-Type' => 'application/force-download',
            'Content-Disposition' => 'attachment; filename="applications.csv"'
        ));*/

    }
}
