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
use Baquaras\TestBundle\Form\ApplicationType;
use Baquaras\TestBundle\Entity\PopulationCible;
use Baquaras\TestBundle\Entity\Utilisateur;
use Baquaras\AppliBundle\Entity\Role;

class HarpeController extends Controller
{
	/**
	 * @ParamConverter("application", options={"mapping": {"applicationId": "id"}})
	 */
	public function rechercherHarpeAction(Request $request, Application $application, $champ, $action)
        {
		$em = $this->getDoctrine()->getManager();
		//$xml = simplexml_load_file($this->container->get('kernel')->getRootDir().'/../src/Baquaras/TestBundle/Entity/personnes_Full.xml');
		$rightValues = array();
		
		/*$defaultData = array('message' => 'Message');
		$form = $this->createFormBuilder($defaultData)
			->add('recherche', 'text', array('label' => 'Nom de l\'agent'))
			->getForm();*/ //Ernest TCHOULOM 24-02-2015 Commentaire
	        
                //$defaultData = array('message' => 'Message');
		//$form = $this->createForm(new ApplicationType($defaultData), $application); //Ernest TCHOULOM 24-02-2015 
			
                $form = $this->createForm(new ApplicationType($application->getId()), $application);//Ernest TCHOULOM 24-02-2015
                    //$form->add('recherche', 'text', array('label' => 'Nom de l\'agent'))
			//->getForm();
                
		//$form->handleRequest($request);//ET Comment
		// récupération des mouvements dans le select de gauche (supression)
		$gauche = $request->request->get('leftValues');//Ernest TCHOULOM Commentaire 19-02-2015
                //$gauche = $request->request->get('rightValues');//Ernest TCHOULOM 19-02-2015 rightValues
		// récupération des agents déjà enregistrés
		/*$agents = $this->getDoctrine()->getRepository('BaquarasTestBundle:Agents')->findByRole($action);
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
		}*/
		// récupération des mouvements dans le select de droite (ajout)
	/*	$select = $request->request->get('rightValues');
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
		}*/
		
		if($form->isValid()) { //ET Comment
                   // die('test2');
			//$recherche = $form['recherche']->getData();//eRNEST tchoulom commentaire 24-02-2015
                          $recherche = $form->getData(); //Begin Check if site Label is alredy existing
    			  $recherche = $recherche->getNom();
						
			/*foreach($xml->Personnes[0]->children() as $personne) {
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
			}*/
		}
		if($request->request->get('enregistrer') == 'enregistrer') {
                        $form->handleRequest($request);
			if(!empty($gauche)) {
			// on enlève les agents qui sont passés dans le select de gauche
				foreach($gauche as $personne) {
					$agent = $this->getDoctrine()->getRepository('BaquarasTestBundle:Agents')->findOneByLibelle($personne);
					if(!empty($agent))
						$em->remove($agent);
				}
				$em->flush();
			}
                       
                        $select = $request->request->get('rightValues'); //Ernest TCHOULOM 20-02-2015
                        $leftValues = $request->request->get('leftValues'); //Ernest TCHOULOM 04-03-2015
                        
                        if(!empty($leftValues)) //Remove user from application
                        {
                            foreach($leftValues as $personne) 
                            {                                 
                                $personne = explode(" ", $personne);
                                if(count($personne) == 2)
                                {
                                    $utilisateur = $this->getDoctrine()->getRepository('BaquarasTestBundle:Utilisateur')->findBy(array('nom'=>$personne[0], 'prenom'=>$personne[1]));                           
                                    foreach($utilisateur as $user) 
                                    {
                                        foreach($user->getRole() as $role) 
                                        {
                                            if($action == "assistance")
                                            {
                                                if($role->getName() == "Assistance")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                            if($action == "ayantDroit")
                                            {
                                                if($role->getName() == "AyantDroit")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                            if($action == "personnes")
                                            {
                                                if($role->getName() == "HabiliteInstaller")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                             if($action == "moa")
                                            {
                                                if($role->getName() == "MOA")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                            if($action == "moe")
                                            {
                                                if($role->getName() == "MOE")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                        }
                                    }
                                }
                                if(count($personne) == 3)
                                {
                                    $utilisateur = $this->getDoctrine()->getRepository('BaquarasTestBundle:Utilisateur')->findBy(array('nom'=>$personne[0].' '.$personne[1], 'prenom'=>$personne[2]));                           

                                    foreach($utilisateur as $user) 
                                    {
                                       foreach($user->getRole() as $role) 
                                        {
                                            if($action == "assistance")
                                            {
                                                if($role->getName() == "Assistance")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                            if($action == "ayantDroit")
                                            {
                                                if($role->getName() == "AyantDroit")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                            if($action == "personnes")
                                            {
                                                if($role->getName() == "HabiliteInstaller")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                             if($action == "moa")
                                            {
                                                if($role->getName() == "MOA")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                            if($action == "moe")
                                            {
                                                if($role->getName() == "MOE")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        
			if(!empty($select)) {
				foreach($select as $personne) 
                                {                                 
                                    $personne = explode(" ", $personne);
                                    if(count($personne) == 2)
                                        $utilisateur = $this->getDoctrine()->getRepository('BaquarasTestBundle:Utilisateur')->findBy(array('nom'=>$personne[0], 'prenom'=>$personne[1]));                           
                                    if(count($personne) == 3)
                                        $utilisateur = $this->getDoctrine()->getRepository('BaquarasTestBundle:Utilisateur')->findBy(array('nom'=>$personne[0].' '.$personne[1], 'prenom'=>$personne[2]));                           
                                    
                                    foreach($utilisateur as $user) 
                                    {
                                        if(($user != null) && is_object($user))
                                        {
                                            $countAppForUser = 0;
                                            $countAssistanceForUser = 0;
                                            $countaynatDroitForUser = 0;
                                            $countHabilInstForUser = 0;
                                            $countMOA = 0;
                                            $countMOE = 0;
                                            foreach ($user->getApplication() as $userApp) //Applications attribuees au user
                                            {
                                              if($userApp->getId() == $application->getId())
                                                  $countAppForUser++;

                                              /*if($userApp->getId() == $application->getId())
                                              {*///}//ET 09-03-2015
                                                  foreach ($user->getRole() as $userRole)
                                                  {
                                                       if($userRole->getName() == "Assistance")
                                                           $countAssistanceForUser++;           //Le user auquel on souhaite attribuer l application a dejà le role Assistance
                                                       if($userRole->getName() == "AyantDroit")
                                                           $countaynatDroitForUser++;
                                                       if($userRole->getName() == "HabiliteInstaller")
                                                           $countHabilInstForUser++;
                                                       if($userRole->getName() == "MOE")
                                                           $countMOE++;
                                                       if($userRole->getName() == "MOA")
                                                           $countMOA++;
                                                  }

                                              //}//ET 09-03-2015
                                            }
                                            if($countAppForUser == 0)
                                              $user->addApplication($application); //On ajoute l application a lutilisateur
                                             
                                            //Un utilisateur peut avoir plusieurs différents types des roles(assistance,ayantDroit...), mais ne peut avoir plusieurs fois le meme type de role
                                             if($countAssistanceForUser == 0)
                                             {
                                                if($action == "assistance")  //On ajoute le role "Assistance" a lutilisateur
                                                {
                                                   $role = $this->getDoctrine()->getRepository('BaquarasAppliBundle:Role')->findBy(array('name'=>"Assistance"));
                                                   $user->addRole($role[0]); 
                                                }
                                             }
                                             if($countaynatDroitForUser == 0)
                                             {
                                                if($action == "ayantDroit")
                                                {
                                                   $role = $this->getDoctrine()->getRepository('BaquarasAppliBundle:Role')->findBy(array('name'=>"AyantDroit"));
                                                   $user->addRole($role[0]); 
                                                }
                                             }
                                             if($countHabilInstForUser == 0)
                                             {
                                                if($action == "personnes")
                                                {
                                                   $role = $this->getDoctrine()->getRepository('BaquarasAppliBundle:Role')->findBy(array('name'=>"HabiliteInstaller"));
                                                   $user->addRole($role[0]); 
                                                }
                                             }

                                             if($countMOE == 0)
                                             {
                                                if($action == "moe")
                                                {
                                                   $role = $this->getDoctrine()->getRepository('BaquarasAppliBundle:Role')->findBy(array('name'=>"MOE"));
                                                   $user->addRole($role[0]); 
                                                }
                                             }
                                             if($countMOA == 0)
                                             {
                                                if($action == "moa")
                                                {
                                                   $role = $this->getDoctrine()->getRepository('BaquarasAppliBundle:Role')->findBy(array('name'=>"MOA"));
                                                   $user->addRole($role[0]); 
                                                }
                                             }
                                        }
                                        $em->persist($application);
                                    }
				}
				$em->flush();
			}//Ernest TCHOULOM Commentaire 20-02-2015
		}
		//if(empty($resultats)) {
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
		//}
                
		return $this->render('BaquarasTestBundle:Default:rechercherHarpe.html.twig', array('form' => $form->createView(), 'action' => $action, 'usersOfAppli' => $application->getUtilisateur(), 'rightValues' => $rightValues, 'application'=> $application, 'champ' => $champ, 'agents' => $resultats));
	}
	
	/**
	 * @ParamConverter("application", options={"mapping": {"applicationId": "id"}})
	 */
	public function ajouterDepartementAction(Request $request, Application $application) 
	{
		$em = $this->getDoctrine()->getManager();
		
		$xml = simplexml_load_file($this->container->get('kernel')->getRootDir().'/../src/Baquaras/TestBundle/Entity/structuresMetier_Full.xml');
		
		// Liste des départements
		$listDpt[] = array('id' => 0, 'nom' => 'Tous'); 
                
		foreach ($xml->Groupe[0]->children() as $entreprise) {
			foreach ($entreprise->children() as $departement) {
				$doublon = false;
				// on vérifie si on va crée un doublon
				foreach($application->getPopulationCible() as $dpt) {
					if($dpt == $departement['nom'])
						$doublon = true;
				}
				if(!$doublon)
					$listDpt[] = array('id' => $departement['id'], 'nom' => $departement['nom']); 
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
										if($dpt == $unite['nom'])
											$doublon = true;
									}
									if(!$doublon)
										$listDpt[] = $unite;
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
											if($dpt == $entite['nom'])
												$doublon = true;
										}
										if(!$doublon)
											$listDpt[] = $entite; 
									}
								}
							}
						}
					}
				}
			}
			return new JsonResponse($listDpt);
		}
		
		if($request->request->get('enregistrer') == 'enregistrer') {
			// on récupère le select des départements sélectionnés
			// le select ne contient que les id des départements
                        
                    //Begin Ernest TCHOULOM 05-03-2015
                        $leftValues = $request->request->get('leftValues'); //Ernest TCHOULOM 04-03-2015
                        
                        if(!empty($leftValues)) //Remove user from application
                        {
                            foreach($leftValues as $personne) 
                            {                                 
                                $personne = explode(" ", $personne);
                                if(count($personne) == 2)
                                {
                                    $utilisateur = $this->getDoctrine()->getRepository('BaquarasTestBundle:Utilisateur')->findBy(array('nom'=>$personne[0], 'prenom'=>$personne[1]));                           
                                    foreach($utilisateur as $user) 
                                    {
                                        foreach($user->getRole() as $role) 
                                        {
                                            if($action == "assistance")
                                            {
                                                if($role->getName() == "Assistance")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                            if($action == "ayantDroit")
                                            {
                                                if($role->getName() == "AyantDroit")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                            if($action == "personnes")
                                            {
                                                if($role->getName() == "HabiliteInstaller")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                             if($action == "moa")
                                            {
                                                if($role->getName() == "MOA")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                            if($action == "moe")
                                            {
                                                if($role->getName() == "MOE")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                        }
                                    }
                                }
                                if(count($personne) == 3)
                                {
                                    $utilisateur = $this->getDoctrine()->getRepository('BaquarasTestBundle:Utilisateur')->findBy(array('nom'=>$personne[0].' '.$personne[1], 'prenom'=>$personne[2]));                           

                                    foreach($utilisateur as $user) 
                                    {
                                       foreach($user->getRole() as $role) 
                                        {
                                            if($action == "assistance")
                                            {
                                                if($role->getName() == "Assistance")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                            if($action == "ayantDroit")
                                            {
                                                if($role->getName() == "AyantDroit")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                            if($action == "personnes")
                                            {
                                                if($role->getName() == "HabiliteInstaller")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                             if($action == "moa")
                                            {
                                                if($role->getName() == "MOA")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                            if($action == "moe")
                                            {
                                                if($role->getName() == "MOE")
                                                {
                                                    $user->removeRole($role);
                                                    $em->persist($role);
                                                    $em->flush();
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    //End Ernest TCHOULOM 05-03-2015
                    
			$pop = $request->request->get('selectDpt');
                        if(!empty($pop))
			foreach($pop as $dpt) {
				$cible = new PopulationCible();
				// on donne le bon nom
				foreach ($xml->Groupe[0]->children() as $entreprise) {
					foreach ($entreprise->children() as $departement) {
						if($dpt == $departement['id']) {
							$cible->setLibelle($departement['nom']);
							$cible->setPopulation('departement');
							break;
						}
						foreach ($departement->children() as $unite) {
							if($dpt == $unite['id']) {
								$cible->setLibelle($unite['nom']);
								$cible->setPopulation('ud');
								break;
							}
							foreach ($unite->{"Entite"} as $entite) {
								if($dpt == $entite['id']) {
									$cible->setLibelle($entite['nom']);
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

