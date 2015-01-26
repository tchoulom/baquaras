<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Baquaras\TestBundle\Entity\Utilisateur;
use Baquaras\TestBundle\Form\UtilisateurType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Exception\NotValidCurrentPageException;

class UtilisateurController extends Controller
{
	public function rechercherUserHarpeAction(Request $request) 
	{
		$em = $this->getDoctrine()->getManager();
		
		// On charge le fichier xml
		//$xml = simplexml_load_file($this->container->get('kernel')->getRootDir().'/../src/Baquaras/TestBundle/Entity/personnes_Full.xml');
		//$users = $this->getDoctrine()->getRepository('BaquarasTestBundle:Utilisateur')->findUser();
               $users = array('amira','rachid','daniel');
               
                return  json_encode($users);
                /* $resultats = array();
		$cpteMatriculaires = array();
		$count = 0;
		
		$defaultData = array('message' => 'Message');
		$form = $this->createFormBuilder($defaultData)
			->add('champRecherche', 'text', array(
				'label' => 'Recherche à partir du nom'))
			->add('save', 'submit', array(
				'label' => 'Lancer la recherche'))
			->getForm();
			
		$form->handleRequest($request);
		if ($form->isValid()) {
			// Récupération du champ recherche
			$recherche = $form['champRecherche']->getData();
			/*
                        $i = 0;			
                        
			
			foreach($xml->Personnes[0]->children() as $personne) {
				// Parcours du fichier personnes pour trouver une correspondance sur le nom ou le prénom
				// La chaîne de caractères entrées est recherchée en début, milieu et fin de chaîne
				$test = preg_match('#^'.$recherche.'#i', $personne->Generique['prenom'].' ');
				$test2 = preg_match('#^'.$recherche.'#i', $personne->Generique['nom'].' ');
				$test3 = preg_match('#^'.$recherche.'#i', $personne['cpteMatriculaire'].' ');
				
				if ($test == 1 || $test2 == 1 || $test3 == 1) {
					$count++;
					$resultats[$i] = $personne->Generique['prenom'].' '.$personne->Generique['nom'];
					$cpteMatriculaires[$i] = $personne['cpteMatriculaire'];
				}
				$i++;
			}
                        
                        */
		/*}
		return $this->render('BaquarasTestBundle:Default:rechercherUserHarpe.html.twig', array('form' => $form->createView(), 'resultats' => $resultats, 'count' => $count, 'cpteMatriculaires' => $cpteMatriculaires));*/
	}	
	
	public function ajouterUserAction($cpteMatriculaire) 
	/* Affiche le formulaire pour ajouter un utilisateur */
	{
            $utilisateur = new Utilisateur();
            $form = $this->createForm(new UtilisateurType, $utilisateur);

            $request = $this->get('request');	
            if ($request->getMethod() == 'POST') {
                    $form->bind($request);
                    if ($form->isValid()) {
                            $em = $this->getDoctrine()->getManager();
                            $em->persist($utilisateur);
                            $em->flush();
                            $this->get('session')->getFlashBag()->add('notice', 'Utilisateur ajouté');

                            return $this->redirect($this->generateUrl('listerUsers'));
                    }
            }
            return $this->render('BaquarasTestBundle:Default:ajouteruser.html.twig', array('form' => $form->createView(), 'cpteMatriculaire' => $cpteMatriculaire));
	}
        
        public function ajoutUtilisateurAction($term)
        {
            $results = array();
            $user = $this->getDoctrine()->getRepository('BaquarasTestBundle:Utilisateur')->findUser($term);
            foreach ($user as $name) {
                $results[] = $name['nom'].' '.$name['prenom'];
            }
            
            return new Response(json_encode($results));
        }
        
	
	public function modifierUserAction($userId) 
	{
		$user = $this->getDoctrine()->getRepository('BaquarasTestBundle:Utilisateur')->find($userId);

                if(!$user) {
                    throw new \Exception('cet utilisateur n\'existe pas');
                }
		$em = $this->getDoctrine()->getManager();
		$form = $this->createForm(new UtilisateurType(), $user);

		$request = $this->get('request');
		
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			$em->persist($user);
			$em->flush();
			
			$this->get('session')->getFlashBag()->add('notice','Utilisateur mis à jour');

			return $this->redirect($this->generateUrl('listerUsers'));
		}

		return $this->render('BaquarasTestBundle:Default:edituser.html.twig', array('form' => $form->createView(), 'user' => $user));
	}
	
	public function supprimerUserAction($userId) 
	{
		$user = $this->getDoctrine()->getRepository('BaquarasTestBundle:Utilisateur')->find($userId);
		
		$em = $this->getDoctrine()->getManager();
                $user->setProfil1();
		$em->persist($user);
		$em->flush();
		
		$this->get('session')->getFlashBag()->add('notice', 'Profil supprimé');
		
		return $this->redirect($this->generateUrl('listerUsers'));
	}
	
	public function listerUsersAction( Request $request, $sort=null)
	{
		$em = $this->getDoctrine()->getManager();
		set_time_limit(0);
		ini_set("memory_limit", -1);
		$page = $request->get('page')?$request->get('page'):1;
                if(!$sort) {
                    $query = $em->createQuery('select u from BaquarasTestBundle:Utilisateur u where u.profil1 != 1');
                } else {
                    $query = $em->createQuery('select u from BaquarasTestBundle:Utilisateur u where u.profil1 = '.$sort);
                }
		$adapter = new DoctrineORMAdapter($query);
		$pagerfanta = new Pagerfanta($adapter);
		$pagerfanta->setMaxPerPage(50);
		$pagerfanta->setCurrentPage($page);
		$entities = $pagerfanta->getCurrentPageResults();
                if ($this->container->get('request')->isXmlHttpRequest()) {
                    return $this->render('BaquarasTestBundle:Default:listuser.html.twig', array('utilisateurs' => $entities,'pager' => $pagerfanta,));
                }
                
		return $this->render('BaquarasTestBundle:Default:listerUsers.html.twig', array('utilisateurs' => $entities,'pager' => $pagerfanta,));
	}

}