<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Baquaras\TestBundle\Entity\Item;
use Baquaras\TestBundle\Entity\Liste;
use Baquaras\TestBundle\Form\ItemType;

class ItemController extends Controller
{
	
	public function listerItemAction(Request $request) {
		$item = new Item();
		$form  =  $this->createForm(new ItemType, $item);

		$listes = $this->getDoctrine()->getRepository('BaquarasTestBundle:Liste')->findAll();
		$items = $this->getDoctrine()->getRepository('BaquarasTestBundle:Item')->findAll();
		
		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$liste = $form["liste"]->getData();
				$libelle = $form["libelle"]->getData();
				$nb = 0;
				
				$items = $this->getDoctrine()->getRepository('BaquarasTestBundle:Item')->findByLibelle($libelle);
				foreach($items as $value){
					if ($value->getListe() == $liste){
						$nb++;
					}
				}
				
				if ($nb >= 2) {
					$this->get('session')->getFlashBag()->add('notice','Un item du même nom existe déjà');
					
					return $this->redirect($this->generateUrl('listerItem'));
				} else {
					$em->persist($item);
					$em->flush();
					$this->get('session')->getFlashBag()->add('notice', 'Item ajouté');
				
					return  $this->redirect($this->generateUrl('listerItem'));
				}
			}
		}
		return  $this->render('BaquarasTestBundle:Default:listerItem.html.twig', array('form' => $form->createView(), 'listes' => $listes, 'items' => $items));
	}  
	
	/**
	 * @ParamConverter("item", options={"mapping": {"itemId": "id"}})
	 */
	public function modifierItemAction(Item $item) {
		$form  =  $this->createForm(new ItemType, $item);
		$listes = $this->getDoctrine()->getRepository('BaquarasTestBundle:Liste')->findAll();
		$items = $this->getDoctrine()->getRepository('BaquarasTestBundle:Item')->findAll();

		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($item);
				$em->flush();
				$this->get('session')->getFlashBag()->add('notice', 'Item mis à jour');

				return $this->redirect($this->generateUrl('listerItem'));
			}
		}
		return  $this->render('BaquarasTestBundle:Default:modifierItem.html.twig', array('form' => $form->createView(), 'listes' => $listes, 'items' => $items, 'item' => $item));
	} 

	/**
	 * @ParamConverter("item", options={"mapping": {"itemId": "id"}})
	 */
	public function supprimerItemAction(Item $item) {
		$em = $this->getDoctrine()->getManager();
		$em->remove($item);
		$em->flush();
		$this->get('session')->getFlashBag()->add('notice', 'Item supprimé');
		
		return $this->redirect($this->generateUrl('listerItem'));
	}	
	
	/**
	 * @ParamConverter("liste", options={"mapping": {"ListeId": "id"}})
	 */
	public function supprimerListeAction(Liste $liste) {
		$em = $this->getDoctrine()->getManager();
		$em->remove($liste);
		$em->flush();
		$this->get('session')->getFlashBag()->add('notice', 'Liste supprimée');
		
		return $this->redirect($this->generateUrl('listerItem'));
	}	
}