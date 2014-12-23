<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Baquaras\TestBundle\Entity\Application;
use Baquaras\TestBundle\Entity\Package;
use Baquaras\TestBundle\Entity\Script;

use Baquaras\TestBundle\Form\ScriptType;


class ScriptController extends Controller
{
	/**
	 * @ParamConverter("package", options={"mapping": {"packageId": "id"}})
	 */
	public function ajouterScriptAction(Package $package)
	// fonction permettant d'ajouter un script à un package
	{
		$em = $this->getDoctrine()->getManager();
		
		$allScripts = $this->getDoctrine()->getRepository('BaquarasTestBundle:Script')->findAll();
		$application = $package->getapplication();
		
		// Création d'un nouveau script 
		$script = new Script();		
		$package->addScript($script);
		$script->setPackage($package);

		$form = $this->createForm(new ScriptType, $script);
		$request = $this->get('request');		
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				$nom = $form['nom']->getData();
				$nb = 0;
				
				foreach ($allScripts as $value) {
					if ($value->getNom() == $nom) {
						$nb++;
					}
				}
				
				if ($nb >= 2) {
					$this->get('session')->getFlashBag()->add('notice','Un script du même nom existe déjà.');
					return $this->redirect($this->generateUrl('ajouterScript', array('packageId' => $package->getId())));
				} else {
					// On persiste le nouvel objet en base
					$em = $this->getDoctrine()->getManager();
					$em->persist($script);
					$em->flush();
					$this->get('session')->getFlashBag()->add('notice', 'Script ajouté');

					echo '<SCRIPT>javascript:window.parent.opener.location.reload();</SCRIPT>'; 
					echo '<SCRIPT>javascript:window.close()</SCRIPT>';
				}
			}
		}
		return $this->render('BaquarasTestBundle:Default:ajouterScript.html.twig', array('form' => $form->createView(), 'package' => $package, 'application' => $application));
	}
	
	public function modifierScriptAction($scriptId)
	// Modifier un script
	{
		$script = $this->getDoctrine()->getRepository('BaquarasTestBundle:Script')->find($scriptId);
		$package = $script->getPackage();
		$application = $package->getApplication();
		
		$em = $this->getDoctrine()->getManager();
		
		$allScripts = $this->getDoctrine()->getRepository('BaquarasTestBundle:Script')->findAll();

		$form = $this->createForm(new ScriptType(), $script);

		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				// On vérifie qu'il n'y a pas de doublons
				$nom = $form['nom']->getData();
				$nb = 0;
				
				foreach ($allScripts as $value) {
					if ($value->getNom() == $nom) {
						$nb++;
					}
				}
				
				if ($nb >= 2) {
					$this->get('session')->getFlashBag()->add('notice','Un script du même nom existe déjà');
					
					return $this->redirect($this->generateUrl('modifierScript', array('scriptId' => $scriptId)));
				} 
				else {
					// On persiste le nouvel objet en base
					$em = $this->getDoctrine()->getManager();
					$em->persist($script);
					$em->flush();
					
					// Message de confirmation de la création
					$this->get('session')->getFlashBag()->add('notice','Script mis à jour');
					
					echo '<SCRIPT>javascript:window.parent.opener.location.reload();</SCRIPT>'; 
					echo '<SCRIPT>javascript:window.close()</SCRIPT>';
				}
			}

		}
		return $this->render('BaquarasTestBundle:Default:modifierScript.html.twig', array('form' => $form->createView(), 'application' => $application, 'script' => $script));
	
		
	}
	
	public function supprimerScriptAction($scriptId)
	// Supprimer un script
	{
		$script = $this->getDoctrine()->getRepository('BaquarasTestBundle:Script')->find($scriptId);
		$package = $script->getPackage();
		$application = $package->getApplication();
		
		$em = $this->getDoctrine()->getManager();
		
		$package->removeScript($script);
		$em->remove($script);
		$em->flush();
		
		$this->get('session')->getFlashBag()->add('notice','Script supprimé');

		return $this->redirect($this->generateUrl('modifierApplication', array('id' => $application->getId())));
	}

}