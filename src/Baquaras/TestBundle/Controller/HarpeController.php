<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse; 

use Baquaras\TestBundle\Entity\Agents;
use Baquaras\TestBundle\Entity\Application;
use Baquaras\TestBundle\Entity\PopulationCible;

class HarpeController extends Controller
{
	/**
	 * @ParamConverter("application", options={"mapping": {"applicationId": "id"}})
	 */
	public function rechercherHarpeAction(Request $request, Application $application, $champ, $action)
    {
		$em = $this->getDoctrine()->getManager();
		$xml = simplexml_load_file($this->container->get('kernel')->getRootDir().'/../src/Baquaras/TestBundle/Entity/personnes_Full.xml');
		$rightValues = array();
		
		$defaultData = array('message' => 'Message');
		$form = $this->createFormBuilder($defaultData)
			->add('recherche', 'text', array('label' => 'Nom de l\'agent'))
			->add('save', 'submit', array('label' => 'Lancer la recherche'))
			->getForm();
			
		$form->handleRequest($request);
		// récupération des mouvements dans le select de gauche (supression)
		$gauche = $request->request->get('leftValues');
		// récupération des agents déjà enregistrés
		$agents = $this->getDoctrine()->getRepository('BaquarasTestBundle:Agents')->findByRole($action);
		foreach($agents as $agent) {
			$retire = false;
			if(!empty($gauche)) {
				foreach($gauche as $personne) {
					if($agent->getLibelle() == $personne)
						$retire = true;
				}
			}
			if(!$retire)
				$rightValues[] = $agent->getLibelle();
		}
		// récupération des mouvements dans le select de droite (ajout)
		$select = $request->request->get('rightValues');
		if(!empty($select)) {
			foreach($select as $agent) {
				// empêche d'avoir deux fois le même agent dans le select de droite
				$doublon = false;
				foreach($rightValues as $personne) {
					if($personne == $agent)
						$doublon = true;
				}
				if(!$doublon)
					array_push($rightValues, $agent);
			}
		}
		
		if($form->isValid()) {
			$recherche = $form['recherche']->getData();
						
			foreach($xml->Personnes[0]->children() as $personne) {
				$doublon = false;
				$test = preg_match('#'.$recherche.'#i', $personne->Generique['prenom']);
				$test2 = preg_match('#'.$recherche.'#i', $personne->Generique['nom']);
				
				if ($test == 1 || $test2 == 1) {
					if(!empty($rightValues)) {
						// on vérifie si on va crée un doublon
						foreach($rightValues as $pers) {
							$agent = $personne->Generique['prenom'] . ' ' . $personne->Generique['nom'];
							if($pers == $agent)
								$doublon = true;
						}
					}
					// on n'ajoute dans le select de gauche que s'il n'est pas déjà dans celui de droite
					if(!$doublon)
						$resultats[] = array('prenom' => $personne->Generique['prenom'],
										'nom' => $personne->Generique['nom']);
				}	
			}
		}
		if($request->request->get('enregistrer') == 'enregistrer') {
			if(!empty($gauche)) {
			// on enlève les agents qui sont passés dans le select de gauche
				foreach($gauche as $personne) {
					$agent = $this->getDoctrine()->getRepository('BaquarasTestBundle:Agents')->findOneByLibelle($personne);
					if(!empty($agent))
						$em->remove($agent);
				}
				$em->flush();
			}
			if(!empty($select)) {
				foreach($select as $personne) {
					$agent = new Agents();
					$agent->setLibelle($personne);
					$agent->setApplication($application);
					$agent->setRole($action);
					$em->persist($agent);
				}
				$em->flush();
			}
		}
		if(empty($resultats)) {
			/*foreach($xml->Personnes[0]->children() as $personne) {
				$doublon = false;
				if(!empty($rightValues)) {
				// on vérifie si on va crée un doublon
					foreach($rightValues as $pers) {
						$agent = $personne->Generique['prenom'] . ' ' . $personne->Generique['nom'];
						if($pers == $agent)
							$doublon = true;
					}
				}
				// on n'ajoute dans le select de gauche que s'il n'est pas déjà dans celui de droite
				if(!$doublon)
					$resultats[] = array('prenom' => $personne->Generique['prenom'],
											'nom' => $personne->Generique['nom']);
			}	*/
			$resultats = array();
		}
		
		return $this->render('BaquarasTestBundle:Default:rechercherHarpe.html.twig', array('form' => $form->createView(), 'action' => $action, 'rightValues' => $rightValues, 'application'=> $application, 'champ' => $champ, 'agents' => $resultats));
	}
	
	/**
	 * @ParamConverter("application", options={"mapping": {"applicationId": "id"}})
	 */
	public function ajouterDepartementAction(Request $request, Application $application) 
	{
		$em = $this->getDoctrine()->getManager();
		
		$xml = simplexml_load_file("/appli/u07/comp/html/Symfony/src/Baquaras/TestBundle/Entity/structuresMetier_Full.xml");
		
		// Liste des départements
		$listDpt[] = array('id' => 0, 'libelle' => 'Tous'); 
		foreach ($xml->Groupe[0]->children() as $entreprise) {
			foreach ($entreprise->children() as $departement) {
				$doublon = false;
				// on vérifie si on va crée un doublon
				foreach($application->getPopulationCible() as $dpt) {
					if($dpt == $departement['libelle'])
						$doublon = true;
				}
				if(!$doublon)
					$listDpt[] = array('id' => $departement['id'], 'libelle' => $departement['libelle']); 
			}
		}
		
		if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
		{
			$id = $request->request->get('id');
			$selecteur = $request->request->get('select');

			if ($id != null)
			{  
				if($selecteur == 'ud') {
					foreach ($xml->Groupe[0]->children() as $entreprise) {
						foreach ($entreprise->children() as $departement) {
							if($id == $departement['id']) {
								foreach ($departement->{"Unite"} as $unite) {
									$doublon = false;
									// on vérifie si on va crée un doublon
									foreach($application->getPopulationCible() as $dpt) {
										if($dpt == $unite['libelle'])
											$doublon = true;
									}
									if(!$doublon)
										$list[] = $unite;
								}
							}
						}
					}
				}
				else {
					foreach ($xml->Groupe[0]->children() as $entreprise) {
						foreach ($entreprise->children() as $departement) {
							foreach ($departement->children() as $unite) {
								if($id == $unite['id']) {
									foreach ($unite->{"Entite"} as $entite) {
										$doublon = false;
										// on vérifie si on va crée un doublon
										foreach($application->getPopulationCible() as $dpt) {
											if($dpt == $entite['libelle'])
												$doublon = true;
										}
										if(!$doublon)
											$list[] = $entite; 
									}
								}
							}
						}
					}
				}
			}
			return new JsonResponse($list);
		}
		
		if($request->request->get('enregistrer') == 'enregistrer') {
			// on récupère le select des départements sélectionnés
			// le select ne contient que les id des départements
			$pop = $request->request->get('selectDpt');
			foreach($pop as $dpt) {
				$cible = new PopulationCible();
				// on donne le bon libelle
				foreach ($xml->Groupe[0]->children() as $entreprise) {
					foreach ($entreprise->children() as $departement) {
						if($dpt == $departement['id']) {
							$cible->setLibelle($departement['libelle']);
							$cible->setPopulation('departement');
							break;
						}
						foreach ($departement->children() as $unite) {
							if($dpt == $unite['id']) {
								$cible->setLibelle($unite['libelle']);
								$cible->setPopulation('ud');
								break;
							}
							foreach ($unite->{"Entite"} as $entite) {
								if($dpt == $entite['id']) {
									$cible->setLibelle($entite['libelle']);
									$cible->setPopulation('ul');
									break;
								}
							}
						}
					}
				}
				$cible->setApplication($application);
				$em->persist($cible);
			}
			$em->flush();
		}
		
		return $this->render('BaquarasTestBundle:Default:ajouterDepartement.html.twig', array(
			'application' => $application, 
			'listDpt' => $listDpt));
	}
}

