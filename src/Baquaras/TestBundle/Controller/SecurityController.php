<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
	public function loginAction() {
            
            $request = $this->getRequest();
            $session = $request->getSession();
           /* $ldaphost = "ratp.infrawin.ratp";
            $base_dn = "OU=SIT IET,OU=Delegation de groupes,OU=Groupes,DC=ratp,DC=infrawin,DC=ratp";
            //$base_dn_member = "CN=JG90263,OU=CGF,OU=RATP,OU=Utilisateurs Entreprises,DC=ratp,DC=infrawin,DC=ratp";

            //// Connexion au LDAP
            $ldapconn = ldap_connect($ldaphost);
            // Authentification anonyme
            $ldapbind = ldap_bind($ldapconn);

            if ($ldapbind) {
                echo "Connexion LDAP anonmye réussie...";
            } else {
                echo "Connexion LDAP anonmye échouée...";
            }
             var_dump($ldapbind); die('test');*/
            // get the login error if there is one
            if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
                $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
                return $this->render('BaquarasTestBundle:Security:login.html.twig', array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            ));
            } else {
                $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
                $session->remove(SecurityContext::AUTHENTICATION_ERROR);
                //			
			$ldaphost = "ratp.infrawin.ratp";
			$base_dn = "OU=SIT IET,OU=Delegation de groupes,OU=Groupes,DC=ratp,DC=infrawin,DC=ratp";
			//$base_dn_member = "CN=JG90263,OU=CGF,OU=RATP,OU=Utilisateurs Entreprises,DC=ratp,DC=infrawin,DC=ratp";

			//// Connexion au LDAP
			$ldapconn = ldap_connect($ldaphost);
			echo ' Le resultat dela connexion est '.$ldapconn.'<br/>';
			
                //
                //var_dump($ldapconn); die('test');
                return $this->redirect($this->generateUrl('accueil'));
            }
            
           
	}
}
