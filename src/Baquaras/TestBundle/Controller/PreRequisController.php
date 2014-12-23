<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Baquaras\TestBundle\Entity\Application;
use Baquaras\TestBundle\Entity\ArchitectureApplication;
use Baquaras\TestBundle\Entity\AutrePreRequis;
use Baquaras\TestBundle\Entity\CatalogueSIT;
use Baquaras\TestBundle\Entity\DeveloppementApplication;
use Baquaras\TestBundle\Entity\DroitWorkflow;
use Baquaras\TestBundle\Entity\GestionApplication;
use Baquaras\TestBundle\Entity\InstallationApplication;
use Baquaras\TestBundle\Entity\InstallationPackage;
use Baquaras\TestBundle\Entity\Item;
use Baquaras\TestBundle\Entity\Liste;
use Baquaras\TestBundle\Entity\MiseAJour;
use Baquaras\TestBundle\Entity\ModeOperatoire;
use Baquaras\TestBundle\Entity\NonRequis;
use Baquaras\TestBundle\Entity\PreRequis;
use Baquaras\TestBundle\Entity\Script;
use Baquaras\TestBundle\Entity\Utilisateur;

use Baquaras\TestBundle\Form\PreRequisType;

class PreRequisController extends Controller
{
	/**
	 * @ParamConverter("application", options={"mapping": {"applicationId": "id"}})
	 */
	public function ajouterPreRequisAction(Application $application) {
		$allPreRequis = $application->getPreRequis();
		$preRequis = new PreRequis();
		
		$preRequis->setApplication($application);
		$application->addPreRequi($preRequis);
		
		$form = $this->createForm(new PreRequisType, $preRequis);

		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				// On vérifie qu'il n'y a pas de doublons
				$libelle = $form['libelle']->getData();
				$modeGestion = $form['modeGestion']->getData();
				$oscible = $form['oscible']->getData();
				$nb = 0;
				
				foreach ($allPreRequis as $value) {
					if ($value->getLibelle() == $libelle) {
						if ($value->getModeGestion() == $modeGestion) {
							if ($value->getOscible() == $oscible) 
								$nb++;
						}
					}
				}
				
				if ($nb >= 2) {
					$this->get('session')->getFlashBag()->add('notice','Ce pré-requis existe déjà.');
					
					return $this->redirect($this->generateUrl('ajouterPreRequis', array('applicationId' => $application->getId())));
				} 
				else {
					// On persiste le nouvel objet en base
					$em = $this->getDoctrine()->getManager();
					$em->persist($preRequis);
					$em->flush();
					
					// Message de confirmation de la création
					$this->get('session')->getFlashBag()->add('notice','Pré-requis ajouté');
					
					return $this->redirect($this->generateUrl('modifierApplication', array('id' => $application->getId())));
				}
			}
		}
		return $this->render('BaquarasTestBundle:Default:ajouterPreRequis.html.twig', array('form' => $form->createView(), 'application' => $application, 'preRequis' => $preRequis));
	}
	
	/**
	 * @ParamConverter("preRequis", options={"mapping": {"preRequisId": "id"}})
	 */
	public function modifierPreRequisAction(PreRequis $preRequis)
	// Fonction permettant de modifier un pré-requis donné
	{
		$application = $preRequis->getApplication();
		
		$allPreRequis = $this->getDoctrine()->getRepository('BaquarasTestBundle:PreRequis')->findAll();
		
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm(new PreRequisType(), $preRequis);

		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				// On vérifie qu'il n'y a pas de doublons
				$libelle = $form['libelle']->getData();
				$modeGestion = $form['modeGestion']->getData();
				$oscible = $form['oscible']->getData();
				$nb = 0;
				
				foreach ($allPreRequis as $value) {
					if ($value->getLibelle() == $libelle) {
						if ($value->getModeGestion() == $modeGestion) {
							if ($value->getOscible() == $oscible) 
								$nb++;
						}
					}
				}
				
				if ($nb >= 2) {
					$this->get('session')->getFlashBag()->add('notice','Ce pré-requis existe déjà.');
					
					return $this->redirect($this->generateUrl('modifierPreRequis', array('preRequisId' => $preRequis->getId())));
				} 
				else {
					// On persiste le nouvel objet en base
					$em = $this->getDoctrine()->getManager();
					$em->persist($preRequis);
					$em->flush();
					
					// Message de confirmation de la création
					$this->get('session')->getFlashBag()->add('notice','Pré-requis mis à jour');
					
					return $this->redirect($this->generateUrl('modifierApplication', array('id' => $application->getId())));
				}
			}

		}
		return $this->render('BaquarasTestBundle:Default:modifierPreRequis.html.twig', array('form' => $form->createView(), 'application' => $application, 'preRequis' => $preRequis));
	}
	
	/**
	 * @ParamConverter("preRequis", options={"mapping": {"preRequisId": "id"}})
	 */
	public function supprimerPreRequisAction(PreRequis $preRequis) 
	//
	{
		$application = $preRequis->getApplication();
		
		$em = $this->getDoctrine()->getManager();
		
		$application->removePreRequis($preRequis);
		$em->remove($preRequis);
		$em->flush();
		
		$this->get('session')->getFlashBag()->add('notice','Pré-requis supprimé');

		return $this->redirect($this->generateUrl('modifierApplication', array('id' => $application->getId())));
	}
}