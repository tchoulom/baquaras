<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Baquaras\TestBundle\Entity\Item;
use Baquaras\TestBundle\Entity\Liste;
use Baquaras\TestBundle\Form\ItemType;

class ListeController extends Controller
{
	public function listeritemAction(Request $request)
	/* Affiche le formulaire de création d'une application */
	{
		$repository = $this->getDoctrine()->getManager()->getRepository('BaquarasTestBundle:Liste');
		$repository2 = $this->getDoctrine()->getManager()->getRepository('BaquarasTestBundle:Item');
		$items = $repository->findAll();
		$listes = $repository->findAll();
		
		return $this->render('BaquarasTestBundle:Default:listeritem.html.twig', array('items' => $items, 'listes' => $listes));
	}
	
	public function modifieritemAction(Request $request)
	/* Affiche le formulaire de modification d'une application */
	{
		$item = new Item();
		$form  =  $this->createForm(new ItemType, $item);

		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($item);
				$em->flush();
				
				return  $this->redirect($this->generateUrl('pagetest'));
			}
		}
		return  $this->render('BaquarasTestBundle:Default:modifieritem.html.twig', array('form' => $form->createView(),));
	}     
}