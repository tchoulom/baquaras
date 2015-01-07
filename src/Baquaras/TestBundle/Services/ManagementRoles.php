<?php

namespace Baquaras\TestBundle\Services;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

 
class ManagementRoles
{
    public function RoleVerified($page)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
        throw new AccessDeniedException();
    }
        
    }
    
    
   
}

