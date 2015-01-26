<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Baquaras\TestBundle\Entity\Groupe;
use Baquaras\TestBundle\Entity\GroupeApplication;
use Baquaras\TestBundle\Entity\Utilisateur;
use Baquaras\TestBundle\Form\GroupeType;
use Baquaras\TestBundle\Form\UtilisateurType;

class GroupeController extends Controller {

    public function ajouterGroupeUserHarpeAction(Request $request)
    /* Rechercher un groupe d'utilisateurs dans Harpe */ {
        $em = $this->getDoctrine()->getManager();

        // On charge le fichier xml
        /* $xml = simplexml_load_file("C:/wamp/www/Symfony/src/Baquaras/TestBundle/Entity/structuresMetier_Full.xml");
          $resultats = array();
          $ids = array(); */

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
            /* $i = 0;

              foreach($xml->Groupe[0]->children() as $personne) {
              // Parcours du fichier personnes pour trouver une correspondance sur le nom ou le pr�nom
              // La cha�ne de caract�res entr�es est recherch�e en d�but, milieu et fin de cha�ne
              $test = preg_match('#'.$recherche.'#', $personne->Generique['prenom'].' ');
              $test2 = preg_match('#'.$recherche.'#', $personne->Generique['nom'].' ');

              if ($test == 1 || $test2 == 1) {
              $resultats[$i] = $personne->Generique['prenom'].' '.$personne->Generique['nom'];
              $matricules[$i] = $personne['matricule'];
              }
              $i++;
              } */
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

    public function rechercherGroupeADAction(Request $request, $applicationId)
    {
        $items = array();
        $em = $this->getDoctrine()->getManager();
        $application = $this->getDoctrine()->getRepository('BaquarasTestBundle:Application')->find($applicationId);
        $resultats = array();
        $resultats_membres = array();
        $rightValues = array();

        $defaultData = array('message' => 'Message');
        $form = $this->createFormBuilder($defaultData)
                ->add('champRecherche', 'text', array(
                    'label' => 'Recherche'))
                /* ->add('save', 'submit', array(
                  'label' => 'Lancer la recherche')) */
                ->getForm();

        $form->handleRequest($request);
        $gauche = $request->request->get('leftValues');
        if ($request->get('submitAction') == 'rechercher') {
            $expression = $form['champRecherche']->getData();

            //// LDAP
            $ldap_host = "ratp.infrawin.ratp";
            $base_dn = "OU=SIT IET,OU=Delegation de groupes,OU=Groupes,DC=ratp,DC=infrawin,DC=ratp";
            //$base_dn_member = "CN=JG90263,OU=CGF,OU=RATP,OU=Utilisateurs Entreprises,DC=ratp,DC=infrawin,DC=ratp";
            $filter = "(sAMAccountName=*$expression*)";
            $filterAll = "(sAMAccountName=*)";
            $ldap_user = "ratp\ServicemaintXP1";
            $ldap_pass = "CL@2pnXP1m@*";
            //// Connexion au LDAP
            $connect = ldap_connect($ldap_host);
            if ($connect) {
                $bind = ldap_bind($connect, $ldap_user, $ldap_pass);
                //// Recherche sur le nom
                $search = ldap_search($connect, $base_dn, $filter, array(), 0, 0);
                $info = ldap_get_entries($connect, $search);
                for($i=0; $i<$info['count']; $i++) {
                    $group = $info[$i]["cn"][0];
                    array_push ($items, $group);
                }
                ldap_close($connect);
            } else {
                echo 'Impossible de connecter au serveur LDAP.';
            }
        }
        
        if ($request->get('submitAction') == 'enregistrer') {
           
            $values =  $request->request->get('test');
            var_dump($values); die('test');
            var_dump($values); exit;
         //   $formulaire = $request->request->get('lgb_bourselivresbundle_eleverechercheid');
            // Reccuperation du contenu de l'array ayant comme champ ideleve //
           // $ideleve = $formulaire['ideleve'];
       // }
            // on récupère le select des départements sélectionnés
            // le select ne contient que les id des départements
            $tab_form = $request->request->get('form_rightValues');
           // $tab_form['form_rightValues'];
          //  $grpes = $request->request->get('form_rightValues');
            var_dump($tab_form); exit;
           // var_dump($grpes); exit;
            foreach ($grpes as $grpe) {
                $groupe = new Groupe();
                $groupe->setLibelle($rightVal);
                $groupeApplication = new GroupeApplication();
                $groupeApplication->setGroupe($groupe);
                $groupeApplication->setApplication($application);
                $em->persist($groupe);
                $em->persist($groupeApplication);
            }
            $em->flush();
        }

        return $this->render('BaquarasTestBundle:Default:rechercherGroupeAD.html.twig', array('form' => $form->createView(), 'application' => $application, 'groupes' => $items, 'rightValues' => $rightValues));
    }

    public function ajouterGroupeADAction(Request $request, $applicationId)
    /*  */ {
           if ($this->container->get('request')->isXmlHttpRequest()) {
               die('ici1'); exit;
           }
           else die('non'); exit;
           /*
        $em = $this->getDoctrine()->getManager();
        $application = $this->getDoctrine()->getRepository('BaquarasTestBundle:Application')->find($applicationId);
        $resultats = array();
        $resultats_membres = array();

        $form = $this->createFormBuilder($defaultData)
                ->add('leftValues', 'choice', array(
                    'label' => 'champ gauche',
                    'choices' => $resultats,
                    'multiple' => true))
                ->add('rightValues', 'choice', array(
                    'label' => 'champ droite',
                    'choices' => array(),
                    'multiple' => true))
                ->add('save', 'submit', array(
                    'label' => 'Enregistrer'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            
        }

        return $this->render('BaquarasTestBundle:Default:ajouterGroupeAD.html.twig', array('form' => $form->createView(), 'application' => $application, 'resultats' => $resultats, 'resultatsMembres' => $resultats_membres));
    
            */ }
            

}
