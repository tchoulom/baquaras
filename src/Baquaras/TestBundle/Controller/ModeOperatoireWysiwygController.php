<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Baquaras\TestBundle\Entity\Groupe;
use Baquaras\TestBundle\Entity\Utilisateur;
use Baquaras\TestBundle\Entity\GestionDroitsPage;
use Baquaras\TestBundle\Entity\ModeOperatoireWysiwyg;
use Baquaras\TestBundle\Form\GroupeType;
use Baquaras\TestBundle\Form\UtilisateurType;
use Baquaras\TestBundle\Form\GestionDroitsPageType;
use Baquaras\TestBundle\Form\ModeOperatoireWysiwygType;

class ModeOperatoireWysiwygController extends Controller
{
	/**
	 * @ParamConverter("package", options={"mapping": {"pck": "id"}})
	 */
	public function genererModeOperatoireAction(Request $request, Package $package) {
		$modeOperatoireWysiwyg = new ModeOperatoireWysiwyg();
		$package->setModeOperatoireWysiwyg($modeOperatoireWysiwyg);
		$modeOperatoireWysiwyg->addPackage($package);
		
		$form = $this->createForm(new ModeOperatoireWysiwygType(), $modeOperatoireWysiwyg);
		$request = $this->get('request');

		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($modeOperatoireWysiwyg);
				$em->flush();
				
				$this->get('session')->getFlashBag()->add('notice', 'Mode opératoire mise à jour');
				
				return  $this->redirect($this->generateUrl('lister_appli'));
			}
		}
		return  $this->render('BaquarasTestBundle:Default:modifiermodeoperatoire.html.twig', array('form' => $form->createView(), 'pck' => $pck));
	}  
	/**
	 * @ParamConverter("package", options={"mapping": {"pck": "id"}})
	 */
	public function modifiermodeoperatoireAction(Request $request, Package $package) 
	/* Affiche le formulaire pour ajouter un utilisateur */
	{	
		$em = $this->getDoctrine()->getManager();
		$modeOperatoireW = $package->getModeOperatoireWysiwyg();
		
		$form = $this->createForm(new ModeOperatoireWysiwygType(), $modeOperatoireW);
		
		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);

			if ($form->isValid()) {
				$em->persist($modeOperatoireW);
				$em->flush();
				
				$this->get('session')->getFlashBag()->add('notice','Vos changements ont été sauvegardés.');

				return $this->redirect($this->generateUrl('lister_appli'));
			}
		}

		return  $this->render('BaquarasTestBundle:Default:modifiermodeoperatoire.html.twig', array('form' => $form->createView(), 'pck' => $pck));		
	}  	
}