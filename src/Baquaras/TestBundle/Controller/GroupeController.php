<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Baquaras\TestBundle\Entity\Groupe;
use Baquaras\TestBundle\Entity\Application;
use Baquaras\TestBundle\Entity\GroupeApplication;
use Baquaras\TestBundle\Entity\Utilisateur;
use Baquaras\TestBundle\Form\GroupeType;
use Baquaras\TestBundle\Form\UtilisateurType;

class GroupeController extends Controller {

    public function ajouterGroupeUserHarpeAction(Request $request)
    /* Rechercher un groupe d'utilisateurs dans Harpe */ {
        $em = $this->getDoctrine()->getManager();

        $defaultData = array('message' => 'Message');
        $form = $this->createFormBuilder($defaultData)
                ->add('champRecherche', 'text', array(
                    'label' => 'Recherche'))
                ->add('save', 'submit', array(
                    'label' => 'Lancer la recherche'))
                ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            // R�cup�ration du champ recherche
            $recherche = $form['champRecherche']->getData();
        }
        return $this->render('BaquarasTestBundle:Default:ajouterUserHarpe.html.twig', array('form' => $form->createView(), 'resultats' => $resultats, 'ids' => $ids));
    }

    public function ajoutergroupeuserAction(Request $request)
    /* Affiche le formulaire pour ajouter un utilisateur */ {
        $groupeuser = new Groupe();
        $form = $this->createForm(new GroupeType, $groupeuser);

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($groupeuser);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'Technicien ajouté');

                return $this->redirect($this->generateUrl('listerApplications'));
            }
        }

        return $this->render('BaquarasTestBundle:Default:ajoutergroupuser.html.twig', array('form' => $form->createView(),));
    }

    /*
     * 
     */
    public function rechercherGroupeADAction(Request $request, $applicationId) {
        $items = array();
        $em = $this->getDoctrine()->getManager();
        $application = $this->getDoctrine()->getRepository('BaquarasTestBundle:Application')->find($applicationId);
        $rightValues = array();
        $defaultData = array('message' => 'Message');
        $form = $this->createFormBuilder($defaultData)
                ->add('champRecherche', 'text', array(
                    'label' => 'Recherche'))
                ->getForm();

        $form->handleRequest($request);
        $gauche = $request->request->get('leftValues');
        if ($request->get('submitAction') == 'rechercher') {
            $expression = $form['champRecherche']->getData();
            $connect = $this->connectAD();
            //// LDAP
           /* $ldap_host = "ratp.infrawin.ratp";
            $base_dn = "OU=SIT IET,OU=Delegation de groupes,OU=Groupes,DC=ratp,DC=infrawin,DC=ratp";
            //$base_dn_member = "CN=JG90263,OU=CGF,OU=RATP,OU=Utilisateurs Entreprises,DC=ratp,DC=infrawin,DC=ratp";
            $filter = "(sAMAccountName=*$expression*)";
            $filterAll = "(sAMAccountName=*)";
            $ldap_user = "ratp\ServicemaintXP1";
            $ldap_pass = "CL@2pnXP1m@*";
            //// Connexion au LDAP
            $connect = ldap_connect($ldap_host);*/
            $filter = "(sAMAccountName=*$expression*)";
            $ldap_user = "ratp\ServicemaintXP1";
            $ldap_pass = "CL@2pnXP1m@*";
            $base_dn = "OU=SIT IET,OU=Delegation de groupes,OU=Groupes,DC=ratp,DC=infrawin,DC=ratp";
            if ($connect) {
                $bind = ldap_bind($connect, $ldap_user, $ldap_pass);
                //// Recherche sur le nom
                $search = ldap_search($connect, $base_dn, $filter, array(), 0, 0);
                $info = ldap_get_entries($connect, $search);
                for ($i = 0; $i < $info['count']; $i++) {
                    $group = $info[$i]["cn"][0];
                    array_push($items, $group);
                }
                ldap_close($connect);
            } else {
                echo 'Impossible de connecter au serveur LDAP.';
            }
            
        }

        return $this->render('BaquarasTestBundle:Default:rechercherGroupeAD.html.twig', array('form' => $form->createView(), 'application' => $application, 'groupes' => $items, 'rightValues' => $rightValues));
    }

    /*
     * @ParamConverter("applicationId", class="BaquarasTestBundle:Application")
     */
    public function ajouterGroupeADAction(Request $request, Application $applicationId) 
    {
        if ($this->container->get('request')->isXmlHttpRequest()) {
            if($applicationId instanceof Application ) {
               $em = $this->getDoctrine()->getManager(); 
               $groups = $request->request->get('group');
              foreach ($groups as $grp) {
                    $groupe = new Groupe();
                    $groupe->setLibelle($grp);
                    $groupeApplication = new GroupeApplication();
                    $groupeApplication->setGroupe($groupe);
                    $groupeApplication->setApplication($applicationId);
                    $em->persist($groupe);
                    $em->persist($groupeApplication);
                }
                $em->flush();
            }
        }
        return new Response();
    }
    
    /*
     * get list users by groupe application from BD
     * @ParamConverter("groupeId", class="BaquarasTestBundle:Groupe")
     * 
     */
    public function rechercheUtilisateurByGroupAdAction(Groupe $groupeId)
    {
        $users = array();
        $items = array();
        $connect = $this->connectAD();
        $expression = $this->ldap_escape($groupeId->getLibelle());
        $filter = "(sAMAccountName=*$expression*)";
        $filterAll = "(sAMAccountName=*)";
        $ldap_user = "ratp\ServicemaintXP1";
        $ldap_pass = "CL@2pnXP1m@*";
        $base_dn = "OU=SIT IET,OU=Delegation de groupes,OU=Groupes,DC=ratp,DC=infrawin,DC=ratp";
        if ($connect) {
            $bind = ldap_bind($connect, $ldap_user, $ldap_pass);
            //// Recherche sur le nom
            $search = ldap_search($connect, $base_dn, $filter, array(), 0, 0);
            $info = ldap_get_entries($connect, $search);
            $nb_membres = count($info[0]["member"]);
                for ($j = 0; $j < $nb_membres - 1; $j++) {
                    $base_dn_membre = $info[0]["member"][$j];
                    $search_membres = ldap_search($connect, $base_dn_membre, $filterAll, array(), 0, 0);
                    $info_membres = ldap_get_entries($connect, $search_membres);
                    if(array_key_exists('displayname', $info_membres[0])) {
                        array_push($users, array('name' => $info_membres[0]["displayname"][0]));
                    }                   
                }
            ldap_close($connect);
        } else {
            echo 'Impossible de connecter au serveur LDAP.';
        }
        return $this->render('BaquarasTestBundle:Default:listusersAd.html.twig', array('users' => $users));
        
        
    }
    
    private function connectAD()
    {
        $ldap_host = "ratp.infrawin.ratp";
        $connect = ldap_connect($ldap_host);
        
        return $connect;
    }
 

    /**
     * @param string $subject The subject string
     * @param string $ignore Set of characters to leave untouched
     * @param int $flags Any combination of LDAP_ESCAPE_* flags to indicate the
     *                   set(s) of characters to escape.
     * @return string
     */
    function ldap_escape($subject, $ignore = '', $flags = 0)
    {
        define('LDAP_ESCAPE_FILTER', 0x01);
        define('LDAP_ESCAPE_DN',     0x02);
        static $charMaps = array(
            LDAP_ESCAPE_FILTER => array('\\', '*', '(', ')', "\x00"),
            LDAP_ESCAPE_DN     => array('\\', ',', '=', '+', '<', '>', ';', '"', '#'),
        );

        // Pre-process the char maps on first call
        if (!isset($charMaps[0])) {
            $charMaps[0] = array();
            for ($i = 0; $i < 256; $i++) {
                $charMaps[0][chr($i)] = sprintf('\\%02x', $i);;
            }

            for ($i = 0, $l = count($charMaps[LDAP_ESCAPE_FILTER]); $i < $l; $i++) {
                $chr = $charMaps[LDAP_ESCAPE_FILTER][$i];
                unset($charMaps[LDAP_ESCAPE_FILTER][$i]);
                $charMaps[LDAP_ESCAPE_FILTER][$chr] = $charMaps[0][$chr];
            }

            for ($i = 0, $l = count($charMaps[LDAP_ESCAPE_DN]); $i < $l; $i++) {
                $chr = $charMaps[LDAP_ESCAPE_DN][$i];
                unset($charMaps[LDAP_ESCAPE_DN][$i]);
                $charMaps[LDAP_ESCAPE_DN][$chr] = $charMaps[0][$chr];
            }
        }

        // Create the base char map to escape
        $flags = (int)$flags;
        $charMap = array();
        if ($flags & LDAP_ESCAPE_FILTER) {
            $charMap += $charMaps[LDAP_ESCAPE_FILTER];
        }
        if ($flags & LDAP_ESCAPE_DN) {
            $charMap += $charMaps[LDAP_ESCAPE_DN];
        }
        if (!$charMap) {
            $charMap = $charMaps[0];
        }

        // Remove any chars to ignore from the list
        $ignore = (string)$ignore;
        for ($i = 0, $l = strlen($ignore); $i < $l; $i++) {
            unset($charMap[$ignore[$i]]);
        }

        // Do the main replacement
        $result = strtr($subject, $charMap);

        // Encode leading/trailing spaces if LDAP_ESCAPE_DN is passed
        if ($flags & LDAP_ESCAPE_DN) {
            if ($result[0] === ' ') {
                $result = '\\20' . substr($result, 1);
            }
            if ($result[strlen($result) - 1] === ' ') {
                $result = substr($result, 0, -1) . '\\20';
            }
        }

        return $result;
    }

}
