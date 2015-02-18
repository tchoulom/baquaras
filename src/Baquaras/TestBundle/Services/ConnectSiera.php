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
    
    /*
     * @param string $siera
     * @param string $siera
     * @return array
     */
    public function  getSieraView()
    {
        $results = $this->connection->query("select * from vue_baquaras")->fetchAll();
        
        return $results;
    }
    
    /*
     * @param string $siera
     * @param string $siera
     * @return array
     */
    public function  createAppliInSiera($idBaquaras, $nomAppliBaquaras)
    {
         //$sql = "CREATE RULE vue_baquaras_insert AS ON INSERT TO vue_baquaras DO INSTEAD INSERT INTO vue_baquaras (id_baquaras, nom_application_siera) VALUES ($idBaquaras, '".$nomAppliBaquaras."')";
         //$sql1 = "CREATE OR REPLACE RULE vue_baquaras_insert ON vue_baquaras";
        //$sql1 = "CREATE OR REPLACE RULE vue_baquaras_insert AS ON INSERT TO vue_baquaras DO INSTEAD  NOTIFY vue_baquaras";
        //$sql = "CREATE OR REPLACE RULE vue_baquaras_insert AS ON INSERT TO vue_baquaras DO INSTEAD INSERT INTO vue_baquaras (id_baquaras, nom_application_siera) VALUES ($idBaquaras, '".$nomAppliBaquaras."')";
          $sql = "CREATE OR REPLACE RULE vue_baquaras_insert AS ON INSERT TO vue_baquaras DO ALSO INSERT INTO vue_baquaras (id_baquaras, nom_application_siera) VALUES ($idBaquaras, '".$nomAppliBaquaras."')";      
// $stmt = $this->connection->query($sql1);
        $stmt = $this->connection->query($sql);
        //$stmt->bindValue(':invoice', $invoiceId);
       $result = $stmt->execute();
        
        //$this->connection->insert('vue_baquaras', array('id_baquaras' => $idBaquaras), array('nom_application_siera' => $nomAppliBaquaras));
        //$conn->update('user', array('username' => 'jwage'), array('id' => 1));
        // INSERT INTO vue_baquaras (id_baquaras) VALUES (?) ($idBaquaras)
    }
   
}
