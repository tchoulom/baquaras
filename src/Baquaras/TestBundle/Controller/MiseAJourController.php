<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Baquaras\TestBundle\Entity\Application;
use Baquaras\TestBundle\Entity\Architecture;
use Baquaras\TestBundle\Entity\Utilisateur;
use Baquaras\TestBundle\Entity\MiseAJour;
use Baquaras\TestBundle\Form\ApplicationType;
use Baquaras\TestBundle\Form\ApplicationType1;
use Baquaras\TestBundle\Form\UtilisateurType;
use Baquaras\TestBundle\Form\MiseAJourType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MiseAJourController extends Controller
{
	/**
	 * @ParamConverter("application", options={"mapping": {"id": "id"}})
	 */
	public  function  ajouterMAJAction(Request  $request, Application $application) 
        {
            if($this->container->get('management_roles')->RoleVerified('ajouter une mise') === false) {
                 throw new AccessDeniedException('Accès limité');
            }
	/*  Affiche  le  formulaire  de  création  d'une  mise  à jour  */
		$miseajour = new MiseAJour();
		$application->addMisesajour($miseajour);
		$miseajour->setApplication($application);

		$form  =  $this->createForm(new MiseAJourType, $miseajour);
		$request = $this->get('request');

		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($miseajour);
				$em->flush();
				
				echo '<SCRIPT>javascript:window.parent.opener.location.reload();</SCRIPT>'; 
				echo '<SCRIPT>javascript:window.close()</SCRIPT>';
				//return  $this->redirect($this->generateUrl('listerApplications'));
			}
		}
		return  $this->render('BaquarasTestBundle:Default:ajoutermiseajour.html.twig', array('form' => $form->createView(), 'application' => $application));
	}
          
	public function modifierMAJAction($majId)
	// Fonction permettant la modification d'une application
	{
		$em = $this->getDoctrine()->getManager();
		$maj = $this->getDoctrine()->getRepository('BaquarasTestBundle:MiseAJour')->find($majId);

		$form = $this->createForm(new MiseAJourType, $maj);

		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				$em->persist($maj);
				$em->flush();
				
				$this->get('session')->getFlashBag()->add('notice','MAJ mise à jour');

				echo '<SCRIPT>javascript:window.parent.opener.location.reload();</SCRIPT>'; 
				echo '<SCRIPT>javascript:window.close()</SCRIPT>';
				//return $this->redirect($this->generateUrl('modifierApplication', array('id' => $maj->getApplication())));
			}
		}
		return $this->render('BaquarasTestBundle:Default:modifierMAJ.html.twig', array('form' => $form->createView(), 'maj' => $maj));
	}
	
	public function supprimerMAJAction($applId, $majId)
	//
	{
		$request = $this->getRequest();
                $em = $this->getDoctrine()->getManager();  //Modif Ernest TCHOULOM 13-02-2015
                $application = $this->getDoctrine()->getRepository('BaquarasTestBundle:Application')->find($majId);
		$maj = $this->getDoctrine()->getRepository('BaquarasTestBundle:MiseAJour')->find($majId);
		
		$this->get('session')->getFlashBag()->add('notice','MAJ supprimée');
		
		$application->removeMisesajour($maj);
		$em->remove($maj);
		$em->flush();

		return $this->redirect($this->generateUrl('modifierApplication', array('id' => $application->getId())));

	}
}