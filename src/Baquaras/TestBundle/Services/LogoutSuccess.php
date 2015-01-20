<?php

namespace Baquaras\TestBundle\Services;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerAware;
 
class LogoutSuccess  extends ContainerAware implements LogoutSuccessHandlerInterface
{
    
   public function onLogoutSuccess(Request $request)
    {
      
        return new RedirectResponse('https://t-sahara.info.ratp/websso/logout');
    }  
    
}