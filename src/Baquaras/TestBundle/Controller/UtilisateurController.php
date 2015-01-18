<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Baquaras\TestBundle\Entity\Utilisateur;
use Baquaras\TestBundle\Form\UtilisateurType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use	Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use	Pagerfanta\Exception\NotValidCurrentPageException;
use Exporter\Writer\CsvWriter ;
use Exporter\Handler;
use Exporter\Source\DoctrineORMQuerySourceIterator;//   \Writer\Exporter\CsvWriter;
use Exporter\Source\PDOStatementSourceIterator;

class UtilisateurController extends Controller
{
	public function rechercherUserHarpeAction(Request $request) 
	{
		$em = $this->getDoctrine()->getManager();
		
		// On charge le fichier xml
		$xml = simplexml_load_file($this->container->get('kernel')->getRootDir().'/../src/Baquaras/TestBundle/Entity/personnes_Full.xml');
		$resultats = array();
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
		}
		return $this->render('BaquarasTestBundle:Default:rechercherUserHarpe.html.twig', array('form' => $form->createView(), 'resultats' => $resultats, 'count' => $count, 'cpteMatriculaires' => $cpteMatriculaires));
	}	
	
	public function ajouterUserAction($cpteMatriculaire) 
	/* Affiche le formulaire pour ajouter un utilisateur */
	{		
		$xml = simplexml_load_file("/appli/u07/comp/html/Symfony/src/Baquaras/TestBundle/Entity/personnes_Full.xml");
		$utilisateur = new Utilisateur();		
		
		foreach($xml->Personnes[0]->children() as $personne) {
		
			if ($personne['cpteMatriculaire'] == $cpteMatriculaire) {
				$civilite = $personne->Generique['civilite'].' ';
				$nom = $personne->Generique['nom'].' ';
				$prenom = $personne->Generique['prenom'].' ';
				$telephone = $personne->Contact['tel'].' ';
				$mail = $personne->Contact['mail'].' ';

				$utilisateur->setCivilite($civilite);
				$utilisateur->setNom($nom);
				$utilisateur->setPrenom($prenom);
				$utilisateur->setCpteMatriculaire($cpteMatriculaire);
				$utilisateur->setTelephone($telephone);
				$utilisateur->setMail($mail);
			}
		}
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
	
	public function modifierUserAction($userId) 
	{
		$user = $this->getDoctrine()->getRepository('BaquarasTestBundle:Utilisateur')->find($userId);
		$cpteMatriculaire = $user->getCpteMatriculaire();

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

		return $this->render('BaquarasTestBundle:Default:ajouteruser.html.twig', array('form' => $form->createView(), 'cpteMatriculaire' => $cpteMatriculaire));
	}
	
	public function supprimerUserAction($userId) 
	{
		$user = $this->getDoctrine()->getRepository('BaquarasTestBundle:Utilisateur')->find($userId);
		
		$em = $this->getDoctrine()->getManager();
		$em->remove($user);
		$em->flush();
		
		$this->get('session')->getFlashBag()->add('notice', 'Utilisateur supprimé');
		
		return $this->redirect($this->generateUrl('listerUsers'));
		
		//return $this->render('BaquarasTestBundle:Default:listerUsers.html.twig', array('utilisateurs' => $utilisateurs));
	}
	
	public function listerUsersAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		set_time_limit(0);
		ini_set("memory_limit", -1);
		$page = $request->get('page');
		$query = $em->createQuery('select u from BaquarasTestBundle:Utilisateur u');
		$adapter = new DoctrineORMAdapter($query);
		$pagerfanta = new Pagerfanta($adapter);
		$pagerfanta->setMaxPerPage(50);
		$pagerfanta->setCurrentPage($page);
		$entities = $pagerfanta->getCurrentPageResults();


		
		return $this->render('BaquarasTestBundle:Default:listerUsers.html.twig', array('utilisateurs' => $entities,'pager' => $pagerfanta,));
	}

}