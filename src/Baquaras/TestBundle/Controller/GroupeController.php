<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Baquaras\TestBundle\Entity\Groupe;
use Baquaras\TestBundle\Entity\GroupeApplication;
use Baquaras\TestBundle\Entity\Utilisateur;
use Baquaras\TestBundle\Form\GroupeType;
use Baquaras\TestBundle\Form\UtilisateurType;

class GroupeController extends Controller
{
	public function ajouterGroupeUserHarpeAction(Request $request) 
	/* Rechercher un groupe d'utilisateurs dans Harpe */
	{
		$em = $this->getDoctrine()->getManager();
		
		// On charge le fichier xml
		/*$xml = simplexml_load_file("C:/wamp/www/Symfony/src/Baquaras/TestBundle/Entity/structuresMetier_Full.xml");
		$resultats = array();
		$ids = array();*/
		
		$defaultData = array('message' => 'Message');
		$form = $this->createFormBuilder($defaultData)
			->add('champRecherche', 'text', array(
				'label' => 'Recherche'))
			->add('save', 'submit', array(
				'label' => 'Lancer la recherche'))
			->getForm();
			
		$form->handleRequest($request);
		if ($form->isValid()) {
			// RÈcupÈration du champ recherche
			$recherche = $form['champRecherche']->getData();
			/*$i = 0;
			
			foreach($xml->Groupe[0]->children() as $personne) {
				// Parcours du fichier personnes pour trouver une correspondance sur le nom ou le prÈnom
				// La chaÓne de caractËres entrÈes est recherchÈe en dÈbut, milieu et fin de chaÓne
				$test = preg_match('#'.$recherche.'#', $personne->Generique['prenom'].' ');
				$test2 = preg_match('#'.$recherche.'#', $personne->Generique['nom'].' ');
				
				if ($test == 1 || $test2 == 1) {
					$resultats[$i] = $personne->Generique['prenom'].' '.$personne->Generique['nom'];
					$matricules[$i] = $personne['matricule'];
				}
				$i++;
			}*/
		}
		return $this->render('BaquarasTestBundle:Default:ajouterUserHarpe.html.twig', array('form' => $form->createView(), 'resultats' => $resultats, 'ids' => $ids));
	}
	
	public function ajoutergroupeuserAction(Request $request) 
	/* Affiche le formulaire pour ajouter un utilisateur */
	{
		$groupeuser = new Groupe();
		$form = $this->createForm(new GroupeType, $groupeuser);
		
		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($groupeuser);
				$em->flush();
				
				$this->get('session')->getFlashBag()->add('info', 'Technicien ajout√©');
				
				return $this->redirect($this->generateUrl('listerApplications'));
			}
		}
		
		return $this->render('BaquarasTestBundle:Default:ajoutergroupuser.html.twig', array('form' => $form->createView(),));	
	}
	
	public function rechercherGroupeADAction(Request $request, $applicationId) 
	/*  */
	{
		$em = $this->getDoctrine()->getManager();
		$application = $this->getDoctrine()->getRepository('BaquarasTestBundle:Application')->find($applicationId);
		$resultats = array();
		$resultats_membres = array();
		$rightValues = array();
        
		$defaultData = array('message' => 'Message');
        $form = $this->createFormBuilder($defaultData)
        	->add('champRecherche', 'text', array(
              	'label' => 'Recherche'))
            /*->add('save', 'submit', array(
               	'label' => 'Lancer la recherche'))*/
           	->getForm();
            
        $form->handleRequest($request);
		
		$gauche = $request->request->get('leftValues');
		
		//if($form->isValid()) {
			
			if ($this->getRequest()->request->get('submitAction') == 'rechercher'){
			$expression = $form['champRecherche']->getData();
			
			//// LDAP
			echo 'Connexion...';
			
			$ldap_host = "ratp.infrawin.ratp";
			$base_dn = "OU=SIT IET,OU=Delegation de groupes,OU=Groupes,DC=ratp,DC=infrawin,DC=ratp";
			//$base_dn_member = "CN=JG90263,OU=CGF,OU=RATP,OU=Utilisateurs Entreprises,DC=ratp,DC=infrawin,DC=ratp";
			$filter = "(sAMAccountName=*$expression*)";
			$filterAll = "(sAMAccountName=*)";
			$ldap_user  = "ratp\ServicemaintXP1";
			$ldap_pass = "CL@2pnXP1m@*";

			//// Connexion au LDAP
			$connect = ldap_connect($ldap_host);
			echo ' Le resultat dela connexion est '.$connect.'<br/>';
			
			if ($connect) {
				echo 'Liaison....';
				$bind = ldap_bind($connect, $ldap_user, $ldap_pass);
				echo ' Le resultat de connexion est '.$bind.'<br/>';
           
				//// Recherche sur le nom
				$search = ldap_search($connect, $base_dn, $filter, array(), 0, 0);
				echo 'Le nombre d\'entr√©es est '.ldap_count_entries($connect,$search).'<br/>';
				$info = ldap_get_entries($connect, $search);

				for ($i=0 ; $i<$info["count"] ; $i++){
					$resultats[] = $info[$i]["cn"][0].' ';
					$nb_membres = count($info[$i]["member"]);
					//echo 'Le nombre de membres est de : '.$nb_membres;
					
					for ($j = 0; $j < $nb_membres-1 ; $j++){
						echo '........'.$info[$i]["member"][$j].'<br/>';
						$base_dn_membre = $info[$i]["member"][$j];
						$search_membres = ldap_search($connect, $base_dn_membre, $filterAll, array(), 0, 0);
						echo 'Le nombre d\'entr√©es est '.ldap_count_entries($connect,$search_membres).'<br/>';
						$info_membres = ldap_get_entries($connect, $search_membres);
						$resultats_membres[$i][$j] = $info_membres[0]["displayname"][0];
						//echo ':::::::'.$info_membres[0]["displayname"][0];
					}
						
					//
					//$base_dn_members = $member."";
						//echo 'la base dn member est : '.$base_dn_members;
						//$search_members = ldap_search($connect, $base_dn_members, $filterAll, array(), 0, 0);
						//echo 'Le nombre d\'entr√©es est '.ldap_count_entries($connect,$search_members).'<br/>';
						//$info_members = ldap_get_entries($connect, $search_members);
						//var_dump($info_members);
						//}
				}
				
					//for ($i=0 ; $i<$infoAll["count"] ; $i++){
					//	$resultatsAll[] = $infoAll[$i]["cn"][0];
					//}
				
				//// Fin de la connexion au LDAP
				ldap_close($connect);
			}else{
				echo 'Impossible de connecter au serveur LDAP.';
			}	
			}
		//}
			
		if ($this->getRequest()->request->get('submitAction') == 'enregistrer')
		{
echo 'lalal';
				// on r√©cup√®re le select des d√©partements s√©lectionn√©s
				// le select ne contient que les id des d√©partements
				$grpes = $request->request->get('form_rightValues');
				foreach($grpe as $grpes) {
					$groupe = new Groupe();
					$groupe->setLibelle($rightVal);
					$groupeApplication = new GroupeApplication();
					$groupeApplication->setGroupe($groupe);
					$groupeApplication->setApplication($application);
					$em->persist($groupe);
					$em->persist($groupeApplication);
				}
				$em->flush();
		}	
		
		return $this->render('BaquarasTestBundle:Default:rechercherGroupeAD.html.twig', array('form' => $form->createView(), 'application' => $application, 'resultats' => $resultats, 'resultatsMembres' => $resultats_membres, 'rightValues' => $rightValues));
	}
	
	public function ajouterGroupeADAction(Request $request, $applicationId) 
	/*  */
	{		
	
		$em = $this->getDoctrine()->getManager();
		$application = $this->getDoctrine()->getRepository('BaquarasTestBundle:Application')->find($applicationId);
		$resultats = array();
		$resultats_membres = array();
	
		$form = $this->createFormBuilder($defaultData)
        	->add('leftValues', 'choice', array(
              	'label' => 'champ gauche',
				'choices' => $resultats,
				'multiple' => true))
			->add('rightValues', 'choice', array(
              	'label' => 'champ droite',
				'choices' => array(),
				'multiple' => true))
            ->add('save', 'submit', array(
               	'label' => 'Enregistrer'))
           	->getForm();
            
        $form->handleRequest($request);
		
		if($form->isValid()) {
		
		}
		
		return $this->render('BaquarasTestBundle:Default:ajouterGroupeAD.html.twig', array('form' => $form->createView(), 'application' => $application, 'resultats' => $resultats, 'resultatsMembres' => $resultats_membres));

	}
          
}