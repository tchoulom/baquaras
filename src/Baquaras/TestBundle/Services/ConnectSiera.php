<?php

namespace Baquaras\TestBundle\Services;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\RedirectResponse;
 
class ConnectSiera
{
    private $container;
    private $connection;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->connection = $this->container->get('doctrine.dbal.siera_connection');
        
    }
    
    /*
     * @param string $siera
     * @return array
     */
    public function getApplicationNameSiera($siera)
    {
        $results = $this->connection->query("select nom_application_siera from vue_baquaras where nom_application_siera LIKE '%$siera%' ")->fetchAll();
        
        return $results;
    }
    
    /*
     * @param string $siera
     * @return array
     */
    public function  getClientNameSiera($siera)
    {
        $results = $this->connection->query("select nom_client_siera from vue_baquaras where nom_application_siera = '$siera'")->fetchAll();
        return $results;
    }
    
    /*
     * @param string $siera
     * @param string $siera
     * @return array
     */
    public function  getAllInfosSiera($siera,$application)
    {
        $results = $this->connection->query("select * from vue_baquaras where nom_client_siera = '$siera' AND nom_application_siera = '$application'")->fetchAll();
        
        return $results;
    }

}
