<?php

namespace Baquaras\TestBundle\Twig;

class AuthorisationExtension extends \Twig_Extension
{

    private $managementRoles;
    
    public function setManagementRoles($managementRoles)
    {
        $this->managementRoles = $managementRoles;
    }
    
    public function getFunctions()
    {
        return array(
                'getAuthorisation' => new \Twig_Function_Method($this, 'getAuthorisation'),
                'getAuthorisationChefProject' => new \Twig_Function_Method($this, 'getAuthorisationChefProject')
        );
    }
    
    
    
    public function getAuthorisation($route)
    {
        
        return $this->managementRoles->RoleVerified($route);
    }

    public function getAuthorisationChefProject($userId, $application)
    {
        foreach($application->getUtilisateur() as $utilisateur) {
            if($utilisateur->getId() == $userId) {
                return true;
            }
        }

        return false;
    }

    public function getName()
    {
        return 'authorisation_extension';
    }
}

