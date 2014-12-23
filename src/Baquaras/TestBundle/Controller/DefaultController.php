<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
	public function indexAction()
	{
	    return new Response("Bienvenue sur Baquaras");
	}
	
	public function accueilAction()
	{
		return $this->render('BaquarasTestBundle:Default:accueil.html.twig');
	}
	
	
}
