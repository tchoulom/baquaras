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
        );
    }
    
    
    
    public function getAuthorisation($route)
    {
        
        return $this->managementRoles->RoleVerified($route);
    }

    public function getName()
    {
        return 'authorisation_extension';
    }
}

