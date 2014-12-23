<?php
/**
 * Controller qui gère les différentes pages de tests de droits d'utilisateurs
 * (liens sur le dashboard)
 *
 * @author dalexandre
 */
namespace Baquaras\AppliBundle\Controller;

use Symfony\Bundle\TwigBundle\Controller\Exception;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;

class AccessTestsController extends Controller
{
    /**
     * affiche la page d'acceuil
     * @Route("/AdminPage", name="_adminPage")
     * @Secure(roles="ROLE_ADMIN")
     * @return Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function adminAction()
    {
       return $this->render('BaquarasAppliBundle:Appli:AdminPage.html.twig');
    }

    /**
     * affiche la page utilisateur
     * @Route("/UserPage", name="_userPage")
     * @Secure(roles="ROLE_USER, ROLE_ADMIN")
     * @return Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function userAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN') && !$this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->render('TwigBundle:Exception:error403.html.twig');
        }
        return $this->render('BaquarasAppliBundle:Appli:UserPage.html.twig');
    }

    /**
     * affiche la page Anonymous
     * @Route("/AnonymousPage", name="_anonymousPage")
     * @return Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function anonymousAction()
    {
        return $this->render('BaquarasAppliBundle:Appli:AnonymousPage.html.twig');
    }
}