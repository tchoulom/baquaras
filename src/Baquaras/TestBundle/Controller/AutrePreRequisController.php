<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Baquaras\TestBundle\Entity\Application;
use Baquaras\TestBundle\Entity\AutrePreRequis;

use Baquaras\TestBundle\Form\AutrePreRequisType;

class AutrePreRequisController extends Controller
{
	/**
	 * @ParamConverter("application", options={"mapping": {"applicationId": "id"}})
	 */
	public function ajouterAutrePreRequisAction(Application $application) {
		$autrePreRequis = new AutrePreRequis();
		$applicationId = $application->getId();
		
		$autrePreRequis->setApplication($application);
		$application->addAutresPreRequi($autrePreRequis);
		
		$form = $this->createForm(new AutrePreRequisType, $autrePreRequis);

		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				// On persiste le nouvel objet en base
				$em = $this->getDoctrine()->getManager();
				$em->persist($autrePreRequis);
				$em->flush();
				// Message de confirmation de la création
				$this->get('session')->getFlashBag()->add('notice','Autre pré-requis ajouté');

				// Retour vers la page de modification de l'application
				return $this->redirect($this->generateUrl('modifierApplication', array('id' => $applicationId)));
			}
		}
		return $this->render('BaquarasTestBundle:Default:ajouterAutrePreRequis.html.twig', array('form' => $form->createView(), 'application' => $application, 'autrePreRequis' => $autrePreRequis));
	}
	
	public function modifierAutrePreRequisAction($autrePreRequisId)
	// Fonction permettant de modifier un pré-requis donné
	{
		$autrePreRequis = $this->getDoctrine()->getRepository('BaquarasTestBundle:AutrePreRequis')->find($autrePreRequisId);
		$application = $autrePreRequis->getApplication();
		
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm(new AutrePreRequisType(), $autrePreRequis);

		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				$em->persist($autrePreRequis);
				$em->flush();
			}
			$this->get('session')->getFlashBag()->add('notice','Autre pré-requis mis à jour');

			return $this->redirect($this->generateUrl('modifierApplication', array('id' => $application->getId())));
		}
		return $this->render('BaquarasTestBundle:Default:modifierAutrePreRequis.html.twig', array('form' => $form->createView(), 'application' => $application, 'autrePreRequis' => $autrePreRequis, ));
	}
	
	public function supprimerAutrePreRequisAction($autrePreRequisId) 
	{
		$autrePreRequis = $this->getDoctrine()->getRepository('BaquarasTestBundle:AutrePreRequis')->find($autrePreRequisId);
		$application = $autrePreRequis->getApplication();
		
		$em = $this->getDoctrine()->getManager();
		
		$application->removeAutresPreRequis($autrePreRequis);
		$em->remove($autrePreRequis);
		$em->flush();
		
		$this->get('session')->getFlashBag()->add('notice','Autre pré-requis supprimé');

		return $this->redirect($this->generateUrl('modifierApplication', array('id' => $application->getId())));
	}
	
}