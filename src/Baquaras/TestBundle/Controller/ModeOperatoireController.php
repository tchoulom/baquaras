<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Baquaras\TestBundle\Entity\GestionDroitsPage;
use Baquaras\TestBundle\Entity\Groupe;
use Baquaras\TestBundle\Entity\ModeOperatoire;
use Baquaras\TestBundle\Entity\Package;
use Baquaras\TestBundle\Entity\Utilisateur;

use Baquaras\TestBundle\Form\GroupeType;
use Baquaras\TestBundle\Form\UtilisateurType;
use Baquaras\TestBundle\Form\GestionDroitsPageType;
use Baquaras\TestBundle\Form\ModeOperatoireType;

class ModeOperatoireController extends Controller
{
	/**
	 * @ParamConverter("package", options={"mapping": {"packageId": "id"}})
	 */
	public function genererModeOperatoireAction(Request $request, Package $package) 
	//
	{
		$em = $this->getDoctrine()->getManager();
		$modeOperatoire = new ModeOperatoire();
		$package->setModeOperatoire($modeOperatoire);
		$modeOperatoire->addPackage($package);
		$application = $package->getApplication();
		$applicationId = $application->getid();
		
		$form = $this->createForm(new ModeOperatoireType(), $modeOperatoire);
		$request = $this->get('request');

		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($package);
				$em->persist($modeOperatoire);
				$em->flush();
				
				$this->get('session')->getFlashBag()->add('notice', 'Mode opératoire créé');
				
				return $this->redirect($this->generateUrl('modifierApplication', array('id' => $applicationId)));
			}
		}
		return $this->render('BaquarasTestBundle:Default:generermodeoperatoire.html.twig', array('form' => $form->createView(), 'application' => $application, 'id' => $applicationId, 'modeOperatoire' => $modeOperatoire, 'package' => $package, 'packageId' => $package->getId()));
	}
	
	/**
	 * @ParamConverter("package", options={"mapping": {"packageId": "id"}})
	 */
	public function modifierModeOperatoireAction(Package $package)
	//
	{
		$em = $this->getDoctrine()->getManager();
		$application = $package->getApplication();
		$applicationId = $application->getId();
		$modeOperatoire = $package->getModeOperatoire();
		$applicationId = $application->getid();

		$form = $this->createForm(new ModeOperatoireType(), $modeOperatoire);

		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);

			if ($form->isValid()) {
				$em->persist($modeOperatoire);
				$em->flush();
				
				$this->get('session')->getFlashBag()->add('notice','Les modifications ont été enregistrées');

				return $this->redirect($this->generateUrl('modifierApplication', array('id' => $applicationId)));
			}
		}

		return $this->render('BaquarasTestBundle:ModeOperatoire:modifierModeOperatoire.html.twig', array('form' => $form->createView(), 'application' => $application, 'modeOperatoire' => $modeOperatoire, 'package' => $package));
	}
	
	/**
	 * @ParamConverter("package", options={"mapping": {"packageId": "id"}})
	 */
	public function voirModeOperatoireAction(Package $package)
	/* Page affichant les caractéristiques d'une application  */
	{
		$modeOperatoire = $package->getModeOperatoire();
		
		$application = $package->getApplication();
		$applicationId = $application->getid();
		
		return $this->render('BaquarasTestBundle:ModeOperatoire:voirModeOperatoire.html.twig', array('application' => $application, 'modeOperatoire' => $modeOperatoire, 'package' => $package));
	}  	
}