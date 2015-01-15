<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Baquaras\TestBundle\Entity\Acces;
use Baquaras\TestBundle\Entity\Droit;
use Baquaras\TestBundle\Entity\DroitWorkflow;
use Baquaras\TestBundle\Entity\Groupe;
use Baquaras\TestBundle\Entity\Page;
use Baquaras\TestBundle\Entity\Profil;
use Baquaras\TestBundle\Entity\Statut;
use Baquaras\TestBundle\Entity\Utilisateur;

use Baquaras\TestBundle\Form\GroupeType;
use Baquaras\TestBundle\Form\UtilisateurType;
use Baquaras\TestBundle\Form\DroitType;
use Baquaras\TestBundle\Form\DroitWorkflowType;

class DroitController extends Controller
{
	public function modifierDroitsPageAction(Request $request, $type) 
	// Fonction permettant d'éditer les droits utilisateurs relatifs à l'accès aux pages
	{
		$em = $this->getDoctrine()->getManager();
		
		$droit = new Droit();
		$form = $this->createForm(new DroitType(), $droit);
		
		$profils = $this->getDoctrine()->getRepository('BaquarasTestBundle:Profil')->findAll();
		$pages = $this->getDoctrine()->getRepository('BaquarasTestBundle:Page')->findBy(array('type' => $type));
		$droits = $this->getDoctrine()->getRepository('BaquarasTestBundle:Droit')->findAll();

		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				
				$profil = $form["profil"]->getData();
				$page = $form["page"]->getData();
				$acces = $form["acces"]->getData();
				
				foreach($droits as $value) {
					if ($value->getProfil() == $profil) {
						if ($value->getPage() == $page) {
							$em->remove($value);
						}
					}				
				}
				$em->persist($droit);
				$em->flush();
				$this->get('session')->getFlashBag()->add('notice', 'Droits utilisateurs mis à jour');
				
				return $this->redirect($this->generateUrl('droitsPage'));
			}
		}
		return $this->render('BaquarasTestBundle:Default:droitsPage.html.twig', array('form' => $form->createView(), 'profils' => $profils, 'pages' => $pages, 'droits' => $droits, 'type' => $type));	
	}   
	
	
	public function modifierDroitsWorkflowAction(Request $request) 
	//
	{		
		$em = $this->getDoctrine()->getManager();
		$droitWorkflow = new DroitWorkflow();		
		$form = $this->createForm(new DroitWorkflowType(), $droitWorkflow);
		  
		$profils = $this->getDoctrine()->getRepository('BaquarasTestBundle:Profil')->findAll();
		$acces = $this->getDoctrine()->getRepository('BaquarasTestBundle:Acces')->findAll();
		$statuts = $this->getDoctrine()->getRepository('BaquarasTestBundle:Statut')->findAll();//By(array('liste' => 20));
		$droits = $this->getDoctrine()->getRepository('BaquarasTestBundle:DroitWorkflow')->findAll();

		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				
				$profil = $form["profil"]->getData();
				$statut = $form["statut"]->getData();
				$acces = $form["acces"]->getData();
				
				foreach($droits as $value) {
					if ($value->getProfil() == $profil) {
						if ($value->getStatut() == $statut) {
							$em->remove($value);
						}
					}				
				}
				$em->persist($droitWorkflow);
				$em->flush();
				$this->get('session')->getFlashBag()->add('notice', 'Droits utilisateurs mis à jour');
				
				return $this->redirect($this->generateUrl('droitsWorkflow'));
			}
		}
		return $this->render('BaquarasTestBundle:Default:droitsWorkflow.html.twig', array('form' => $form->createView(), 'profils' => $profils, 'statuts' => $statuts, 'droits' => $droits));	
	}
}