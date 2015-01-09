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
    public function RoleVerified()
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {

            return new RedirectResponse($this->container->get('router')->generate('accueil'));
        }
        $username = $this->container->get('security.context')->getToken()->getUser()->getUsername();
        $route = $this->container->get('request')->attributes->get('_route');         
        $user = $this->container->get('doctrine')->getRepository('BaquarasTestBundle:Utilisateur')->findOneBy(array('cpteMatriculaire' =>$username));
        $page = $this->container->get('doctrine')->getRepository('BaquarasTestBundle:Page')->getPageByRoute($route);
        $droit = $this->container->get('doctrine')->getRepository('BaquarasTestBundle:Droit')->findOneBy(array('profil' => $user->getProfil1()->getId(),'page' =>$page->getId()));
        
        if($droit && $droit->getAcces() === false) {
            
            return false;
        } elseif($droit && $droit->getAcces() === true ) {
            
            return true;
        }
    }
    
    
   
}

