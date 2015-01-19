<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityController extends Controller
{
    public function loginAction(Request $request) 
    {
        $session = $request->getSession();
        // On vérifie s'il y a des erreurs d'une précédente soumission du formulaire
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            if($this->getUser()) {
                $token = new UsernamePasswordToken($this->getUser(), null, '', $this->getUser()->getRoles());
                $this->get('security.context')->setToken($token);
                
            }
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return $this->render('BaquarasTestBundle:Security:login.html.twig', array(
          // Valeur du précédent nom d'utilisateur entré par l'internaute
          'last_username' => $session->get(SecurityContext::LAST_USERNAME),
          'error'         => $error,
        ));
     }
    
    public function authentificateAction(Request $request)
    {
        $session = $request->getSession();
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            $username = $this->container->get('security.context')->getToken()->getUser()->getUsername();
            $user = $this->container->get('doctrine')->getRepository('BaquarasTestBundle:Utilisateur')->findOneBy(array('cpteMatriculaire' =>$username));
            $session->set('nom', $user->getNom());
            $session->set('prenom', $user->getPrenom());
            $session->set('iduser', $user->getId());
            $session->set('role', $user->getProfil1()->getLibelle());
        }
        
        return $this->redirect($this->generateUrl('accueil'));
        
    }
     
   public function checkAction(Request $request) {
        //do whatever you want here 
        $this->get('security.context')->setToken(null);
       // $this->get('request')->getSession()->invalidate();
        return $this->redirect($this->generateUrl('accueil'));
     }
     
}