<?php

namespace Baquaras\TestBundle\Services;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\RedirectResponse;
 
class ManagementRoles
{
    private $container;
    
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
    
    /*
     * pour valider le role de l'utilisateur
     * @return boolean
     */
    public function RoleVerified($route)
    {
        $username = '';
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            $username = $this->container->get('security.context')->getToken()->getUser()->getUsername();
        }
        $page = $this->container->get('doctrine')->getRepository('BaquarasTestBundle:Page')->getPageByRoute($route);
        if($page) {
            return $this->verifeAccess($page, $username);
        } 
        return false;
    }
    
    /*
     * verify acces for user and page
     */
    private function verifeAccess($page, $username)
    {
        $profil = 1;
        // if autoriser pour un profile non connecte donc autorisé pour tout les autres profiles.
        $droitNotAuthentificated = $this->container->get('doctrine')->getRepository('BaquarasTestBundle:Droit')->findOneBy(array('profil' => 1,'page' =>$page));
        if($droitNotAuthentificated && $droitNotAuthentificated->getAcces() === true) {
            
            return true;
        }
        if($username) {
            $user = $this->container->get('doctrine')->getRepository('BaquarasTestBundle:Utilisateur')->findOneBy(array('cpteMatriculaire' =>$username)); 
            if($user && $user->getProfil1()->getId() == 8) {
                return true;
            } else if($user) {
                $profil = $user->getProfil1()->getId();
            }
        }
        
        $droit = $this->container->get('doctrine')->getRepository('BaquarasTestBundle:Droit')->findOneBy(array('profil' => $profil,'page' =>$page));
        if($droit && $droit->getAcces() === false) {
            
            return false;
        } elseif($droit && $droit->getAcces() === true ) {

            return true;
        }
        // if non indiqué return false
        else {
            return false;
        } 
        
        return false;
        
    }

}

