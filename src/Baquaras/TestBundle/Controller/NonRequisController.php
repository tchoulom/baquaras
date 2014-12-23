<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Baquaras\TestBundle\Entity\Application;
use Baquaras\TestBundle\Entity\NonRequis;

use Baquaras\TestBundle\Form\NonRequisType;

class NonRequisController extends Controller
{
	/**
	 * @ParamConverter("application", options={"mapping": {"applicationId": "id"}})
	 */
	public function ajouterNonRequisAction(Application $application)
	//
	{
		$nonRequis = new NonRequis();
		
		$nonRequis->setApplication($application);
		$application->addNonRequi($nonRequis);
		$form = $this->createForm(new NonRequisType, $nonRequis);

		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				// On persiste le nouvel objet en base
				$em = $this->getDoctrine()->getManager();
				$em->persist($nonRequis);
				$em->flush();
				
				// Message de confirmation de la création
				$this->get('session')->getFlashBag()->add('notice','Non-requis ajouté');

				// Retour vers la page de modification de l'application
				return $this->redirect($this->generateUrl('modifierApplication', array('id' => $application->getId())));
			}
		}
		return $this->render('BaquarasTestBundle:Default:ajouterNonRequis.html.twig', array('form' => $form->createView(), 'application' => $application, 'nonRequis' => $nonRequis));
	}
	/**
	 * @ParamConverter("nonRequis", options={"mapping": {"nonRequisId": "id"}})
	 */
	public function modifierNonRequisAction(NonRequis $nonRequis)
	// Modifier un non-requis donné
	{
		$application = $nonRequis->getApplication();
		
		$allNonRequis = $this->getDoctrine()->getRepository('BaquarasTestBundle:NonRequis')->findAll();
		
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm(new NonRequisType(), $nonRequis);

		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				// On vérifie qu'il n'y a pas de doublons
				$libelle = $form['libelle']->getData();
				$modeGestion = $form['modeGestion']->getData();
				$oscible = $form['oscible']->getData();
				$nb = 0;
				
				foreach ($allNonRequis as $value) {
					if ($value->getLibelle() == $libelle) {
						if ($value->getModeGestion() == $modeGestion) {
							if ($value->getOscible() == $oscible) 
								$nb++;
						}
					}
				}
				
				if ($nb >= 2) {
					$this->get('session')->getFlashBag()->add('notice','Ce non-requis existe déjà.');
					
					return $this->redirect($this->generateUrl('modifierNonRequis', array('nonRequisId' => $nonRequis->getId())));
				} 
				else {
					// On persiste le nouvel objet en base
					$em = $this->getDoctrine()->getManager();
					$em->persist($nonRequis);
					$em->flush();
					
					// Message de confirmation de la création
					$this->get('session')->getFlashBag()->add('notice','Non-requis mis à jour');
					
					return $this->redirect($this->generateUrl('modifierApplication', array('id' => $application->getId())));
				}
			}

		}
		return $this->render('BaquarasTestBundle:Default:modifierNonRequis.html.twig', array('form' => $form->createView(), 'application' => $application, 'nonRequis' => $nonRequis));
	
		
		
		
		
		
		
		
		
		
		/*
		
		
		
		
		$application = $nonRequis->getApplication();
		
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm(new NonRequisType(), $nonRequis);

		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);

			if ($form->isValid()) {
				$em->persist($nonRequis);
				$em->flush();
			}
			
			$this->get('session')->getFlashBag()->add('notice','Non-requis mis à jour');

			return $this->redirect($this->generateUrl('modifierApplication', array('id' => $application->getId())));
		}
		return $this->render('BaquarasTestBundle:Default:modifierNonRequis.html.twig', array('form' => $form->createView(), 'application' => $application, 'nonRequis' => $nonRequis));*/
	}
	
	/**
	 * @ParamConverter("nonRequis", options={"mapping": {"nonRequisId": "id"}})
	 */
	public function supprimerNonRequisAction(NonRequis $nonRequis) 
	// Supprimer un non-requis
	{
		$nonRequis = $this->getDoctrine()->getRepository('BaquarasTestBundle:NonRequis')->find($nonRequisId);
		$application = $nonRequis->getApplication();
		
		$em = $this->getDoctrine()->getManager();
		
		$application->removeNonRequis($nonRequis);
		$em->remove($nonRequis);
		$em->flush();
		
		$this->get('session')->getFlashBag()->add('notice','Non-requis supprimé');

		return $this->redirect($this->generateUrl('modifierApplication', array('id' => $application->getId())));
	}
	
}