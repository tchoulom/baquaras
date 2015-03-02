<?php

namespace Baquaras\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Baquaras\TestBundle\Entity\Acces;
use Baquaras\TestBundle\Entity\Application;
use Baquaras\TestBundle\Entity\ArchitectureApplication;
use Baquaras\TestBundle\Entity\AutrePreRequis;
use Baquaras\TestBundle\Entity\AutrePreRequisApplication;
use Baquaras\TestBundle\Entity\CatalogueSIT;
use Baquaras\TestBundle\Entity\DeveloppementApplication;
use Baquaras\TestBundle\Entity\DroitWorkflow;
use Baquaras\TestBundle\Entity\Fichier;
use Baquaras\TestBundle\Entity\GestionApplication;
use Baquaras\TestBundle\Entity\InstallationApplication;
use Baquaras\TestBundle\Entity\InstallationPackage;
use Baquaras\TestBundle\Entity\Item;
use Baquaras\TestBundle\Entity\Liste;
use Baquaras\TestBundle\Entity\MiseAJour;
use Baquaras\TestBundle\Entity\ModeOperatoire;
use Baquaras\TestBundle\Entity\NonRequis;
use Baquaras\TestBundle\Entity\NonRequisApplication;
use Baquaras\TestBundle\Entity\Package;
use Baquaras\TestBundle\Entity\Page;
use Baquaras\TestBundle\Entity\PreRequis;
use Baquaras\TestBundle\Entity\PreRequisApplication;
use Baquaras\TestBundle\Entity\Profil;
use Baquaras\TestBundle\Entity\Qualification;
use Baquaras\TestBundle\Entity\Script;
use Baquaras\TestBundle\Entity\Statut;
use Baquaras\TestBundle\Entity\Utilisateur;
use Baquaras\TestBundle\Entity\PageRepository;
use Baquaras\TestBundle\Form\ApplicationType;
use Baquaras\TestBundle\Form\ApplicationAjoutType;
use Baquaras\TestBundle\Form\AutrePreRequisType;
use Baquaras\TestBundle\Form\UtilisateurType;
use Baquaras\TestBundle\Form\MiseAJourType;
use Baquaras\TestBundle\Form\NonRequisType;
use Baquaras\TestBundle\Form\PackageType;
use Baquaras\TestBundle\Form\PreRequisType;
use Baquaras\TestBundle\Entity\ItemRepository;
use Baquaras\TestBundle\Entity\EvolutionStatut;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AppliController extends Controller {

    public function listerApplicationsAction($action, $page, $export) {
      
       $user = $this->container->get('security.context')->getToken()->getUser(); //Ernest TCHOULOM 13-02-2015
       $username = $user->getUsername();
        //$username = $this->container->get('security.context')->getToken()->getUser();
       $user = $this->container->get('doctrine')->getRepository('BaquarasTestBundle:Utilisateur')->findOneBy(array('cpteMatriculaire' =>$username));
    // Fonction listant les applications qualifiées
        if ($this->container->get('management_roles')->RoleVerified('Liste des applications') === false) {
            throw new AccessDeniedException('Accès limité');
        }
        $maxApplications = 6; // nombre d'applications affichées par page
        $repository = $this->getDoctrine()->getRepository('BaquarasTestBundle:Application');
        $applications_count = $repository->countApplications();

        $pagination = array(
            'page' => $page,
            'route' => 'listerApplications',
            'pages_count' => ceil($applications_count / $maxApplications),
            'route_params' => array()
        );

        $applications = $repository->getListe($page, $maxApplications);
        $defaultData = array('message' => 'Message');
        $form = $this->createFormBuilder($defaultData)
                ->add('sousCompte', 'button', array('label' => 'Sous compte'))
                ->add('postesWSUS', 'button', array('label' => 'Postes WSUS'))
                ->add('installable', 'button', array('label' => 'Non installable par un groupe AD'))
                ->add('miseAJour', 'button', array('label' => 'Mise à jour mineure'))
                ->add('reboot', 'button', array('label' => 'Reboot'))
                ->add('preRequisManuel', 'button', array('label' => 'Pré requis manuel'))
                ->add('nonRequis', 'button', array('label' => 'Non requis'))
                ->add('populationCible', 'button', array('label' => 'Population cible'))
                ->getForm();

        switch ($action) {
            case 'triParSousCompte' :
                $liste = new \Doctrine\Common\Collections\ArrayCollection();
                foreach ($applications as $appli) {
                    foreach ($appli->getPackages() as $package) {
                        if ($package->getQualification()->getSousCompte() != null)
                            $liste->add($appli);
                    }
                }
                $applications = $liste;
                break;
            case 'triParPostesWSUS' :
                $liste = new \Doctrine\Common\Collections\ArrayCollection();
                foreach ($applications as $appli) {
                    if ($appli->getGestion()->getPostesPilotesWSUS() != null)
                        $liste->add($appli);
                }
                $applications = $liste;
                break;
            case 'triParInstallationAD' :
                $liste = new \Doctrine\Common\Collections\ArrayCollection();
                foreach ($applications as $appli) {
                    foreach ($appli->getAgents() as $personne) {
                        if ($personne->getRole() == 'personnes') {
                            if (!preg_match('/AD/', $habilite))
                                $liste->add($appli);
                        }
                    }
                }
                $applications = $liste;
                break;
            case 'triParMiseAJour' :
                $liste = new \Doctrine\Common\Collections\ArrayCollection();
                foreach ($applications as $appli) {
                    if ($appli->getMisesajour()->first() != null)
                        $liste->add($appli);
                }
                $applications = $liste;
                break;
            case 'triParReboot' :
                $liste = new \Doctrine\Common\Collections\ArrayCollection();
                foreach ($applications as $appli) {
                    $reboot = false;
                    foreach ($appli->getPackages() as $package) {
                        if ($package->getRedemarrageRequis())
                            $reboot = true;
                    }
                    if ($reboot)
                        $liste->add($appli);
                }
                $applications = $liste;
                break;
            case 'triParPreRequisManuel' :
                $liste = new \Doctrine\Common\Collections\ArrayCollection();
                $manuel = true;
                foreach ($applications as $appli) {
                    if ($appli->getPreRequis()->first() != null) {
                        foreach ($appli->getPreRequis() as $preRequis) {
                            foreach ($applications as $appli2) {
                                // si le pré requis a le nom d'une application on ne le prend pas en compte
                                if ($preRequis->getLibelle() == $appli2->getNom())
                                    $manuel = false;
                            }
                            if ($manuel) {
                                $liste->add($appli);
                                break;
                            }
                        }
                    }
                }
                $applications = $liste;
                break;
            case 'triParNonRequis' :
                $liste = new \Doctrine\Common\Collections\ArrayCollection();
                foreach ($applications as $appli) {
                    if ($appli->getNonRequis()->first() != null)
                        $liste->add($appli);
                }
                $applications = $liste;
                break;
            case 'triParPopulationCible' :
                $liste = new \Doctrine\Common\Collections\ArrayCollection();
                foreach ($applications as $appli) {
                    foreach ($appli->getPopulationCible() as $pop) {
                        if ($pop != null)
                            $liste->add($appli);
                    }
                }
                $applications = $liste;
                break;
        }

        if ($export)
            return $this->forward('BaquarasTestBundle:Appli:exporter', array('applications' => $applications, 'action' => $action));
        return $this->render('BaquarasTestBundle:Default:listerappli.html.twig', 
                array('form' => $form->createView(), 'applications' => $applications, 'pagination' => $pagination, 'action' => $action , 'user' => $user));
    }

    /*
     *  Fonction listant les applications qualifiées avec pagination alphabétique
     */

    public function listerApplicationsLettreAction() {
        $application = $this->getDoctrine()->getRepository('BaquarasTestBundle:Application')->find(100);

        return $this->render('BaquarasTestBundle:Default:listerappli.html.twig', array('application' => $application));
    }

    /**
     * Fonction permettant de rechercher une application
     */
    public function rechercherAction(Request $request) {
        if (!$this->container->get('management_roles')->RoleVerified('recherche')) {
            throw new AccessDeniedException('Accès limité');
        }
        $defaultData = array('message' => 'Message');
        $form = $this->createFormBuilder($defaultData)
                ->add('nomListe', 'entity', array('label' => 'Nom de l\'application', 'empty_value' => 'Sélectionner une application', 'class' => 'BaquarasTestBundle:Application', 'property' => 'NomAndVersion'))
                ->add('nomPosition', 'choice', array('label' => 'Indiquer une partie du nom de l\'application', 'choices' => array('D' => 'Commence par', 'M' => 'Composé de', 'F' => 'Fini par'), 'multiple' => false, 'expanded' => true))
                ->add('nomPartie', 'text', array('label' => 'Partie du nom'))
                ->add('productCode', 'text', array('label' => 'Product Code (GUID) du package'))
                ->add('type', 'entity', array(
                    'label' => 'Type de l\'application',
                    'empty_value' => 'Sélectionner un type d\'application',
                    'class' => 'BaquarasTestBundle:Item',
                    'query_builder' => function(ItemRepository $er) {
                        return $er->getItemsQueryBuilder(1);
                    },
                    'property' => 'libelle',
                    'multiple' => true,
                    'expanded' => true))
                ->add('palierTechnique', 'entity', array(
                    'label' => 'Palier technique',
                    'empty_value' => 'Sélectionner un palier technique',
                    'class' => 'BaquarasTestBundle:Item',
                    'query_builder' => function(ItemRepository $er) {
                        return $er->getItemsQueryBuilder(4);
                    },
                    'property' => 'libelle',
                    'multiple' => true,
                    'expanded' => true))
                ->add('appliWeb', 'choice', array('label' => 'Application web', 'choices' => array(1 => 'Oui', 0 => 'Non'), 'expanded' => true))
                ->add('appliClientServeur', 'choice', array('label' => 'Application Client/Serveur', 'choices' => array(1 => 'Oui', 0 => 'Non'), 'expanded' => true))
                ->add('statut', 'entity', array('label' => 'Statut', 'empty_value' => 'Sélectionner un statut', 'class' => 'BaquarasTestBundle:Statut', 'property' => 'libelle', 'multiple' => true))
                ->add('preRequis', 'entity', array(
                    'label' => 'Est pré requis de',
                    'empty_value' => 'Sélectionner une application',
                    'class' => 'BaquarasTestBundle:Application',
                    'property' => 'NomAndVersion'))
                ->add('save', 'submit', array('label' => 'Rechercher'))
                ->getForm();

        $applications = new \Doctrine\Common\Collections\ArrayCollection();
        $form->handleRequest($request);

        if ($form->isValid()) {

            $nomListe = $form["nomListe"]->getData();
            $nomPosition = $form["nomPosition"]->getData();
            $nomPartie = $form["nomPartie"]->getData();
            $productCode = $form["productCode"]->getData();
            $type = $form["type"]->getData();
            $palierTechnique = $form["palierTechnique"]->getData();
            $appliWeb = $form["appliWeb"]->getData();
            $appliClientServeur = $form["appliClientServeur"]->getData();
            $statut = $form["statut"]->getData();
            $preRequis = $form["preRequis"]->getData();

            if ($nomListe != null) {
                $applications->clear();
                $applications->add($nomListe);
            } else {
                $repository = $this->getDoctrine()->getManager()->getRepository('BaquarasTestBundle:Application');
                $allApplications = $repository->findAll();
                $em = $this->getDoctrine()->getManager();

                $applications->clear();

                // NomPartie & NomPosition
                if ($nomPartie != null) {
                    $qb = $em->createQueryBuilder();
                    $qb->select('a')
                            ->from('BaquarasTestBundle:Application', 'a')
                            ->where("a.nom LIKE :nomPartie")
                            ->orderBy('a.nom', 'ASC');

                    if ($nomPosition == "D") {
                        $qb->setParameter('nomPartie', $nomPartie . '%');
                    } else if ($nomPosition == "F") {
                        $qb->setParameter('nomPartie', '%' . $nomPartie);
                    } else {
                        $qb->setParameter('nomPartie', '%' . $nomPartie . '%');
                    }

                    $query = $qb->getQuery();
                    $applications = $query->getResult();
                    $applications = new \Doctrine\Common\Collections\ArrayCollection($applications);
                }

                // Product Code
                if ($productCode != null) {
                    $temp7 = new \Doctrine\Common\Collections\ArrayCollection();
                    if (isset($applications)) {
                        foreach ($allApplications as $value) {
                            if ($value->getPackages()->first()->getProductCode() == $productCode) {
                                $temp7->add($value);
                            }
                        }
                        $applications = $temp7;
                    }
                }

                // Type
                if (!$type->isEmpty()) {
                    $temp = new \Doctrine\Common\Collections\ArrayCollection();
                    if (empty($applications)) {
                        foreach ($allApplications as $value) {
                            foreach ($type as $value2) {
                                if ($value->getType() == $value2) {
                                    $temp->add($value);
                                }
                            }
                        }
                        $applications = $temp;
                    } else {
                        foreach ($applications->toArray() as $value) {
                            foreach ($type as $value2) {
                                if ($value->getType() == $value2) {
                                    $temp->add($value);
                                }
                            }
                        }
                        $applications = array_intersect($applications->toArray(), $temp->toArray());
                    }
                }

                // Palier Technique
                if (!$palierTechnique->isEmpty()) {
                    $temp2 = new \Doctrine\Common\Collections\ArrayCollection();
                    if (empty($applications)) {
                        foreach ($allApplications as $value) {
                            foreach ($palierTechnique as $value2) {
                                if ($value->getPackages()->first()->getPaliersTechniques() == $value2) {
                                    $temp2->add($value);
                                }
                            }
                        }
                        $applications = $temp2;
                    } else {
                        foreach ($applications->toArray() as $value) {
                            foreach ($palierTechnique as $value2) {
                                if ($value->getPackages()->first()->getPaliersTechniques() == $value2) {
                                    $temp2->add($value);
                                }
                            }
                        }
                        $applications = array_intersect($applications->toArray(), $temp2->toArray());
                    }
                }

                // ApplicationWeb	
                if ($appliWeb != null) {
                    $temp3 = new \Doctrine\Common\Collections\ArrayCollection();
                    if (empty($applications)) {
                        foreach ($allApplications as $value) {
                            if ($value->getArchitecture()->getAppliWeb() == $appliWeb) {
                                $temp3->add($value);
                            }
                        }
                        $applications = $temp3->toArray();
                    } else {
                        foreach ($applications->toArray() as $value) {
                            if ($value->getArchitecture()->getAppliWeb() == $appliWeb) {
                                $temp3->add($value);
                            }
                        }
                        $applications = array_intersect($applications->toArray(), $temp3->toArray());
                    }
                }

                // Application Client/Serveur 
                if ($appliClientServeur == 0 || $appliClientServeur == 1) {
                    $temp4 = new \Doctrine\Common\Collections\ArrayCollection();
                    if (empty($applications)) {
                        foreach ($allApplications as $value) {
                            if ($value->getArchitecture()->getAppliClientServeur() == $appliClientServeur) {
                                $temp4->add($value);
                            }
                        }
                        $applications = $temp4->toArray();
                    } else {
                        foreach ($applications->toArray() as $value) {
                            if ($value->getArchitecture()->getAppliClientServeur() == $appliClientServeur) {
                                $temp4->add($value);
                            }
                        }
                        $applications = array_intersect($applications->toArray(), $temp4->toArray());
                    }
                }

                // Statut
                if (!$statut->isEmpty()) {
                    $temp5 = new \Doctrine\Common\Collections\ArrayCollection();
                    if (empty($applications)) {
                        foreach ($allApplications as $value) {
                            foreach ($statut as $value2) {
                                if ($value->getPackages()->first()->getStatutQualif() == $value2) {
                                    $temp5->add($value);
                                }
                            }
                        }
                        $applications = $temp5;
                    } else {
                        foreach ($applications as $value) {
                            foreach ($statut as $value2) {
                                if ($value->getPackages()->first()->getStatutQualif() == $value2) {
                                    $temp5->add($value);
                                }
                            }
                        }
                        $applications = array_intersect($applications, $temp5->toArray());
                    }
                }

                // Pré requis
                if ($preRequis != null) {
                    $temp6 = new \Doctrine\Common\Collections\ArrayCollection();
                    if (empty($applications)) {
                        foreach ($allApplications as $value) {
                            if ($value->getPreRequis()->first() != null) {
                                if ($value->getPreRequis()->first()->getLibelle() == $preRequis->getNom()) {
                                    $temp6->add($value);
                                }
                            }
                        }
                        $applications = $temp6;
                    } else {
                        foreach ($applications as $value) {
                            if ($value->getPreRequis() != null) {
                                if ($value->getPreRequis()->first()->getLibelle() == $preRequis->getNom()) {
                                    $temp6->add($value);
                                }
                            }
                        }
                        $applications = array_intersect($applications, $temp6->toArray());
                    }
                }
            }
        }

        return $this->render('BaquarasTestBundle:Default:rechercher.html.twig', array('form' => $form->createView(), 'applications' => $applications));
    }

    public function exporterAction($applications, $action) {
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("BAQUARAS")
                ->setLastModifiedBy("BAQUARAS")
                ->setTitle("Resultats de la recherche")
                ->setSubject("Resultats de la recherche")
                ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
                ->setKeywords("office 2005 openxml php")
                ->setCategory("Test result file");
        $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $phpExcelObject->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $phpExcelObject->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $phpExcelObject->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $phpExcelObject->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Nom')
                ->setCellValue('B1', 'Version')
                ->setCellValue('C1', 'Correctif Qualif')
                ->setCellValue('D1', 'Description')
                ->setCellValue('E1', 'Installable par')
                ->setCellValue('F1', 'Installable à distance')
                ->setCellValue('G1', 'Mode Opératoire');

        // Pour chaque critère on rajoute une colonne
        // ce qui décale la colonne Statut
        switch ($action) {
            case 'triParSousCompte' :
                $phpExcelObject->setActiveSheetIndex(0)
                        ->setCellValue('H1', 'Sous compte')
                        ->setCellValue('I1', 'Statut');
                break;
            case 'triParPostesWSUS' :
                $phpExcelObject->setActiveSheetIndex(0)
                        ->setCellValue('H1', 'Postes WSUS')
                        ->setCellValue('I1', 'Statut');
                break;
            case 'triParMiseAJour' :
                $phpExcelObject->setActiveSheetIndex(0)
                        ->setCellValue('H1', 'Mise à jour')
                        ->setCellValue('I1', 'Statut');
                break;
            case 'triParPreRequisManuel' :
                $phpExcelObject->setActiveSheetIndex(0)
                        ->setCellValue('H1', 'Pré requis')
                        ->setCellValue('I1', 'Statut');
                break;
            case 'triParNonRequis' :
                $phpExcelObject->setActiveSheetIndex(0)
                        ->setCellValue('H1', 'Non requis')
                        ->setCellValue('I1', 'Statut');
                break;
            case 'triParPopulationCible' :
                $phpExcelObject->setActiveSheetIndex(0)
                        ->setCellValue('H1', 'Population cible')
                        ->setCellValue('I1', 'Statut');
                break;
            // si on ne fait que lister les applications, on n'a pas besoin de décaler la colonne Statut
            default :
                $phpExcelObject->setActiveSheetIndex(0)
                        ->setCellValue('H1', 'Statut');
                break;
        }

        $i = 2;
        foreach ($applications as $appli) {
            $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $appli->getNom())
                    ->setCellValue('B' . $i, $appli->getVersion())
                    ->setCellValue('C' . $i, $appli->getCorrectifQualif())
                    ->setCellValue('D' . $i, $appli->getDescription())
                    ->setCellValue('E' . $i, $appli->getGroupesInstall())
                    ->setCellValue('F' . $i, $appli->getInstallation()->getInstallationADistance());
            foreach ($appli->getPackages() as $package) {
                if ($package->getModeOperatoire()) {
                    $phpExcelObject->setActiveSheetIndex(0)
                            ->setCellValue('G' . $i, $package->getModeOperatoire()->getLibelle());
                }

                $nMAJ = 0;
                $nPR = 0;
                $nNR = 0;

                switch ($action) {
                    case 'triParSousCompte' :
                        $phpExcelObject->setActiveSheetIndex(0)
                                ->setCellValue('H' . $i, $package->getQualification()->getSousCompte());
                        if ($package->getStatutQualif() != null) {
                            $phpExcelObject->setActiveSheetIndex(0)
                                    ->setCellValue('I' . $i, $package->getStatutQualif()->getLibelle());
                        }
                        break;
                    case 'triParPostesWSUS' :
                        $phpExcelObject->setActiveSheetIndex(0)
                                ->setCellValue('H' . $i, $appli->getGestion()->getPostesPilotesWSUS());
                        if ($package->getStatutQualif() != null) {
                            $phpExcelObject->setActiveSheetIndex(0)
                                    ->setCellValue('I' . $i, $package->getStatutQualif()->getLibelle());
                        }
                        break;
                    case 'triParMiseAJour' :
                        if ($appli->getMisesajour()->first() != null) {
                            foreach ($appli->getMisesajour() as $miseAJour) {
                                $phpExcelObject->setActiveSheetIndex(0)
                                        ->setCellValue('H' . ($i + $nMAJ), $miseAJour->getDescription());
                                $nMAJ++;
                            }
                        }
                        if ($package->getStatutQualif() != null) {
                            $phpExcelObject->setActiveSheetIndex(0)
                                    ->setCellValue('I' . $i, $package->getStatutQualif()->getLibelle());
                        }
                        break;
                    case 'triParPreRequisManuel' :
                        if ($appli->getPreRequis()->first() != null) {
                            foreach ($appli->getPreRequis() as $preRequis) {
                                $phpExcelObject->setActiveSheetIndex(0)
                                        ->setCellValue('H' . ($i + $nPR), $preRequis->getLibelle());
                                $nPR++;
                            }
                        }
                        if ($package->getStatutQualif() != null) {
                            $phpExcelObject->setActiveSheetIndex(0)
                                    ->setCellValue('I' . $i, $package->getStatutQualif()->getLibelle());
                        }
                        break;
                    case 'triParNonRequis' :
                        if ($appli->getNonRequis()->first() != null) {
                            foreach ($appli->getNonRequis() as $nonRequis) {
                                $phpExcelObject->setActiveSheetIndex(0)
                                        ->setCellValue('H' . ($i + $nNR), $nonRequis->getLibelle());
                                $nNR++;
                            }
                        }
                        if ($package->getStatutQualif() != null) {
                            $phpExcelObject->setActiveSheetIndex(0)
                                    ->setCellValue('I' . $i, $package->getStatutQualif()->getLibelle());
                        }
                        break;
                    case 'triParPopulationCible' :
                        $phpExcelObject->setActiveSheetIndex(0)
                                ->setCellValue('H' . $i, $appli->getPopulationCible());
                        if ($package->getStatutQualif() != null) {
                            $phpExcelObject->setActiveSheetIndex(0)
                                    ->setCellValue('I' . $i, $package->getStatutQualif()->getLibelle());
                        }
                        break;
                    default :
                        if ($package->getStatutQualif() != null) {
                            $phpExcelObject->setActiveSheetIndex(0)
                                    ->setCellValue('H' . $i, $package->getStatutQualif()->getLibelle());
                        }
                        break;
                }
                $i = ($nMAJ > $nNR ? $nMAJ : $nNR) > $nPR ? ($nMAJ > $nNR ? $nMAJ : $nNR) : $nPR;
            }
            $i++;
        }
        $phpExcelObject->getActiveSheet()->setTitle('Simple');
        // setActiveSheet définit la page sur laquelle Excel s'ouvre
        $phpExcelObject->setActiveSheetIndex(0);

        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // en-tête du fichier
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $action . '.xls');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        return $response;
    }

    /*
     *  Fonction permettant d'ajouter/créer une application
     * 
     */
    public function ajouterApplicationAction(Request $request) 
    {
        if ($this->container->get('management_roles')->RoleVerified('ajouter une application') === false) {
            throw new AccessDeniedException('Accès limité');
        }
        $em = $this->getDoctrine()->getManager();

        /* Application */
        $application = new Application();

        /* Installation */
        $installation = new InstallationApplication();
        $application->setInstallation($installation);

        /* Développement */
        $developpement = new DeveloppementApplication();
        $application->setDeveloppement($developpement);

        /* Architecture */
        $architecture = new ArchitectureApplication();
        $application->setArchitecture($architecture);

        /* Gestion */
        $gestion = new GestionApplication();
        $application->setgestion($gestion);

        /* Catalogue */
        $refCatalogue = new CatalogueSIT();
        $application->setRefCatalogue($refCatalogue);

        /* Fichier */
        $fichier = new Fichier();
        $refCatalogue->setDocInfoComplementaire($fichier);

        /* Package */
        $package = new Package();
        $package->setApplication($application);
        $application->getPackages()->add($package);

        /* Statut */
        $statut = $this->getDoctrine()->getRepository('BaquarasTestBundle:Statut')->find(1);
        $package->setStatutQualif($statut);

        /* qualification */
        $qualification = new Qualification();
        $package->setQualification($qualification);

        /* installation_package */
        $installationp = new InstallationPackage();
        $package->setInstallation($installationp);

        $form = $this->createForm('baquaras_testbundle_application', $application);
        $request = $this->get('request');
        $id = $this->container->get('session')->get('iduser');
        if(!$id) {
            throw new AccessDeniedException('Accès limité vous devez se connecter');
        }
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($application);
                $em->persist($installation);
                $em->persist($gestion);
                $em->persist($architecture);
                $em->persist($developpement);
                $em->persist($refCatalogue);
                $em->persist($fichier);
                $em->persist($package);
                $em->persist($qualification);
                $em->persist($installationp);
                $em->flush();
                foreach($application->getUtilisateur() as $utilisateur) {
                    $user = $this->getDoctrine()->getRepository('BaquarasTestBundle:Utilisateur')->findOneBy(array('id'=>$utilisateur->getId()));
                    $user->addApplication($application);
                    $em->persist($user);
                    $em->flush();
                }
                
                //Begin Enest TCHOULOM 16-02-2015
                //$results = $this->container->get('baquaras.connect_siera')->createAppliInSiera($application->getId(), $application->getNomApplicationSIERA());
                  //$application = $this->getDoctrine()->getRepository('BaquarasTestBundle:Application')->createAppliInViewBaquaras($application->getId(), $application->getNom(), $application->getDeptMoa(), $application->getDeptUsers(), $application->getNomApplicationSIERA());
                //End Enest TCHOULOM 16-02-2015
                
                $this->get('session')->getFlashBag()->add('notice', 'Application ajoutée');
                return $this->redirect($this->generateUrl('listerApplications'));
            }
        }
        return $this->render('BaquarasTestBundle:Default:ajouter.html.twig', array('form' => $form->createView(),));
    }

    /**
     * Fonction permettant la modification d'une application
     * @ParamConverter("application", options={"mapping": {"id": "id"}})
     */
    public function modifierApplicationAction(Application $application)
    {
        if ($this->container->get('management_roles')->RoleVerified('modifier une application') === false) {
            throw new AccessDeniedException('Accès limité');
        }
        $em = $this->getDoctrine()->getManager();
        //Begin ET 02-03-2015
         $user = $this->container->get('security.context')->getToken()->getUser(); //Ernest TCHOULOM 13-02-2015
         $username = $user->getUsername();
         $user = $this->container->get('doctrine')->getRepository('BaquarasTestBundle:Utilisateur')->findOneBy(array('cpteMatriculaire' =>$username));
       //End ET 02-03-2015             
        $pck = $application->getPackages()->first();
        $form = $this->createForm(new ApplicationType($application->getId()), $application);

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
           // $application->getRefCatalogue()->getDocInfoComplementaire()->upload();
            $em->persist($application);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Application mise à jour');

            return $this->redirect($this->generateUrl('listerApplications'));
        }

        return $this->render('BaquarasTestBundle:Default:modifierappli.html.twig', array('form' => $form->createView(), 'application' => $application, 'pck' => $pck, 'user' => $user));
    }

    /**
     * Fonction permettant la consultation d'une application
     * @ParamConverter("application", options={"mapping": {"id": "id"}})
     */
    public function consulterApplicationAction(Application $application) 
    {
        if (!$this->container->get('management_roles')->RoleVerified('consulter les d')) {
            throw new AccessDeniedException('Accès limité');
        }
        if($application->getCodeMoa()) {
            $moa = $this->getDoctrine()->getRepository('BaquarasTestBundle:Utilisateur')->findOneBy(array('cpteMatriculaire'=> $application->getCodeMoa()));
        }
        return $this->render('BaquarasTestBundle:Default:consulterappli.html.twig', array('application' => $application, 'moa' => isset($moa)?$moa:null));
    }

    /**
     * @ParamConverter("application", options={"mapping": {"id": "id"}})
     */
    public function supprimerApplicationAction(Application $application) {
        if (!$this->container->get('management_roles')->RoleVerified('supprimer une application')) {
            throw new AccessDeniedException('Accès limité');
        }
        if ($this->container->get('management_roles')->RoleVerified() === false) {
            throw new AccessDeniedException('Accès limité');
        }
        $em = $this->getDoctrine()->getManager();

        /* Installation */
        $installation = $application->getInstallation();
        $application->setInstallation();
        if (!empty($installation)) {
            $em->remove($installation);
        }

        /* Architecture */
        $architecture = $application->getArchitecture();
        $application->setArchitecture();
        if (!empty($architecture)) {
            $em->remove($architecture);
        }

        /* Developpement */
        $developpement = $application->getDeveloppement();
        $application->setDeveloppement();
        if (!empty($developpement)) {
            $em->remove($developpement);
        }

        /* Gestion */
        $gestion = $application->getGestion();
        $application->setGestion();
        if (!empty($gestion)) {
            $em->remove($gestion);
        }

        /* Catalogue */
        $catalogue = $application->getRefCatalogue();
       /* $application->setRefCatalogue();
        if (!empty($catalogue)) {
            $em->remove($catalogue);
        }*/

        /* Packages Pré-requis */
        $preRequisApplication = $application->getPreRequis();
        if (!$preRequisApplication->isEmpty()) {
            foreach ($preRequisApplication->toArray() as $value) {
                $preRequis = $value->getPreRequis();
                $application->removePreRequisApplication($value);
                $em->remove($preRequis);
                $em->remove($value);
            }
        }

        /* Packages non-requis */
        $nonRequisApplication = $application->getNonRequis();
        if (!$nonRequisApplication->isEmpty()) {
            foreach ($nonRequisApplication->toArray() as $value) {
                $nonRequis = $value->getNonRequis();
                $application->removeNonRequisApplication($value);
                $em->remove($nonRequis);
                $em->remove($value);
            }
        }

        /* Autres Pré-requis */
        $autresPreRequisApplication = $application->getAutresPreRequis();
        if (!$autresPreRequisApplication->isEmpty()) {
            foreach ($autresPreRequisApplication->toArray() as $value) {
                $autrePreRequis = $value->getAutresPreRequis();
                $application->removeAutresPreRequisApplication($value);
                $em->remove($autrePreRequis);
                $em->remove($value);
            }
        }

        /* Packages */
        $packages = $application->getPackages();
        if (!$packages->isEmpty()) {
            foreach ($packages->toArray() as $value) {
                $application->removePackage($value);
                $em->remove($value);

                $modeop = $value->getModeOperatoire();
                if (!empty($modeop)) {
                    $value->setModeOperatoire();
                    $em->remove($modeop);
                }

                $qualification = $value->getQualification();
                if (!empty($qualification)) {
                    $value->setQualification();
                    $em->remove($qualification);
                }
                $installationp = $value->getInstallation();
                if (!empty($installationp)) {
                    $em->remove($installationp);
                }

                $value->setApplication();
            }
        }

        /* Mises à jour */
        $maj = $application->getMisesajour();
        if (!$maj->isEmpty()) {
            foreach ($maj->toArray() as $value) {
                $application->removeMisesajour($value);
                $em->remove($value);
            }
        }

        /* Scripts */

        /* Application */
        $em->remove($application);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'Application supprimée');

        return $this->redirect($this->generateUrl('listerApplications'));
    }

    public function consulterFichierAction(Fichier $fichier) {
        $response = new Response();
        $response->setContent(file_get_contents($fichier->getUploadRootDir() . '/' . $fichier->getUrl()));
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-disposition', 'filename=' . $fichier->getUrl());

        return $response;
    }

    public function initialiserAction() {
    // Iniatilise les tables Item et Liste, permettant la customisation de listes déroulantes
        $em = $this->getDoctrine()->getManager();

        // Statuts
        $statut1 = new Statut();
        $statut1->setLibelle("Planifiée");
        $em->persist($statut1);
        $statut2 = new Statut();
        $statut2->setLibelle("Pré-qualifiée");
        $em->persist($statut2);
        $statut3 = new Statut();
        $statut3->setLibelle("Packaging");
        $em->persist($statut3);
        $statut4 = new Statut();
        $statut4->setLibelle("Pré-production");
        $em->persist($statut4);
        $statut5 = new Statut();
        $statut5->setLibelle("En production");
        $em->persist($statut5);
        $statut6 = new Statut();
        $statut6->setLibelle("Publiée");
        $em->persist($statut6);
        $statut7 = new Statut();
        $statut7->setLibelle("Non publiée");
        $em->persist($statut7);
        $statut8 = new Statut();
        $statut8->setLibelle("Télédistribuée");
        $em->persist($statut8);
        $statut9 = new Statut();
        $statut9->setLibelle("Publiée et télédistribuée");
        $em->persist($statut9);
        $statut10 = new Statut();
        $statut10->setLibelle("Publiée pour maintenance");
        $em->persist($statut10);
        $statut11 = new Statut();
        $statut11->setLibelle("Retirée de la production");
        $em->persist($statut11);
        $statut12 = new Statut();
        $statut12->setLibelle("Planifiée(suspendue)");
        $em->persist($statut12);
        $statut13 = new Statut();
        $statut13->setLibelle("Pré-qualifiée (suspendue)");
        $em->persist($statut13);
        $statut14 = new Statut();
        $statut14->setLibelle("Packaging (suspendue)");
        $em->persist($statut14);
        $statut15 = new Statut();
        $statut15->setLibelle("Pré-production(suspendue)");
        $em->persist($statut15);
        $statut16 = new Statut();
        $statut16->setLibelle("En production(suspendue)");
        $em->persist($statut16);

        // Profils
        $profil8 = new Profil();
        $profil8->setLibelle("Utilisateur non connecté");
        $em->persist($profil8);
        $profil7 = new Profil();
        $profil7->setLibelle("Lecteur avancé");
        $em->persist($profil7);
        $profil6 = new Profil();
        $profil6->setLibelle("Technicien support");
        $em->persist($profil6);
        $profil5 = new Profil();
        $profil5->setLibelle("Intégrateur");
        $em->persist($profil5);
        $profil4 = new Profil();
        $profil4->setLibelle("Chef de produit");
        $em->persist($profil4);
        $profil3 = new Profil();
        $profil3->setLibelle("Qualificateur");
        $em->persist($profil3);
        $profil2 = new Profil();
        $profil2->setLibelle("Responsable qualification");
        $em->persist($profil2);
        $profil1 = new Profil();
        $profil1->setLibelle("Administrateur");
        $em->persist($profil1);


        // Utilisateurs
        //$user1 = new Utilisateur();	$user1->setNom("test");	$user1->setPrenom("test");	$em->persist($user1);
        // Pages
        $page1 = new Page();
        $page1->setLibelle("Liste des applications qualifiées");
        $em->persist($page1);
        $page2 = new Page();
        $page2->setLibelle("Ajouter une application");
        $em->persist($page2);
        $page3 = new Page();
        $page3->setLibelle("Modifier une application");
        $em->persist($page3);
        $page4 = new Page();
        $page4->setLibelle("Consulter les détails d'une application");
        $em->persist($page4);
        $page5 = new Page();
        $page5->setLibelle("Ajouter une mise à jour");
        $em->persist($page5);
        $page6 = new Page();
        $page6->setLibelle("Supprimer une application");
        $em->persist($page6);
        $page7 = new Page();
        $page7->setLibelle("Recherche");
        $em->persist($page7);
        $page8 = new Page();
        $page8->setLibelle("Liste des applications en cours de qualification");
        $em->persist($page8);
        $page9 = new Page();
        $page9->setLibelle("Administration");
        $em->persist($page9);

        // Accès
        $acces1 = new Acces();
        $acces1->setLibelle("-");
        $em->persist($acces1);
        $acces2 = new Acces();
        $acces2->setLibelle("Lecture");
        $em->persist($acces2);
        $acces3 = new Acces();
        $acces3->setLibelle("Modification");
        $em->persist($acces3);
        $acces4 = new Acces();
        $acces4->setLibelle("Validation");
        $em->persist($acces4);
        $acces5 = new Acces();
        $acces5->setLibelle("Création/Suppression");
        $em->persist($acces5);

        // Droits Workflow
        // 1 - Administrateur
        $dw1 = new DroitWorkflow();
        $dw1->setProfil($profil1);
        $dw1->setStatut($statut1);
        $dw1->setAcces($acces5);
        $em->persist($dw1);
        $dw2 = new DroitWorkflow();
        $dw2->setProfil($profil1);
        $dw2->setStatut($statut2);
        $dw2->setAcces($acces5);
        $em->persist($dw2);
        $dw3 = new DroitWorkflow();
        $dw3->setProfil($profil1);
        $dw3->setStatut($statut3);
        $dw3->setAcces($acces5);
        $em->persist($dw3);
        $dw4 = new DroitWorkflow();
        $dw4->setProfil($profil1);
        $dw4->setStatut($statut4);
        $dw4->setAcces($acces5);
        $em->persist($dw4);
        $dw5 = new DroitWorkflow();
        $dw5->setProfil($profil1);
        $dw5->setStatut($statut5);
        $dw5->setAcces($acces5);
        $em->persist($dw5);
        $dw6 = new DroitWorkflow();
        $dw6->setProfil($profil1);
        $dw6->setStatut($statut6);
        $dw6->setAcces($acces5);
        $em->persist($dw6);
        $dw7 = new DroitWorkflow();
        $dw7->setProfil($profil1);
        $dw7->setStatut($statut7);
        $dw7->setAcces($acces5);
        $em->persist($dw7);
        $dw8 = new DroitWorkflow();
        $dw8->setProfil($profil1);
        $dw8->setStatut($statut8);
        $dw8->setAcces($acces5);
        $em->persist($dw8);
        $dw9 = new DroitWorkflow();
        $dw9->setProfil($profil1);
        $dw9->setStatut($statut9);
        $dw9->setAcces($acces5);
        $em->persist($dw9);
        $dw10 = new DroitWorkflow();
        $dw10->setProfil($profil1);
        $dw10->setStatut($statut10);
        $dw10->setAcces($acces5);
        $em->persist($dw10);
        $dw11 = new DroitWorkflow();
        $dw11->setProfil($profil1);
        $dw11->setStatut($statut11);
        $dw11->setAcces($acces5);
        $em->persist($dw11);
        $dw12 = new DroitWorkflow();
        $dw12->setProfil($profil1);
        $dw12->setStatut($statut12);
        $dw12->setAcces($acces5);
        $em->persist($dw12);
        $dw13 = new DroitWorkflow();
        $dw13->setProfil($profil1);
        $dw13->setStatut($statut13);
        $dw13->setAcces($acces5);
        $em->persist($dw13);
        $dw14 = new DroitWorkflow();
        $dw14->setProfil($profil1);
        $dw14->setStatut($statut14);
        $dw14->setAcces($acces5);
        $em->persist($dw14);
        $dw15 = new DroitWorkflow();
        $dw15->setProfil($profil1);
        $dw15->setStatut($statut15);
        $dw15->setAcces($acces5);
        $em->persist($dw15);
        $dw16 = new DroitWorkflow();
        $dw16->setProfil($profil1);
        $dw16->setStatut($statut16);
        $dw16->setAcces($acces5);
        $em->persist($dw16);
        $em->flush();

        // 2 - Responsable qualification
        $dw1 = new DroitWorkflow();
        $dw1->setProfil($profil2);
        $dw1->setStatut($statut1);
        $dw1->setAcces($acces5);
        $em->persist($dw1);
        $dw2 = new DroitWorkflow();
        $dw2->setProfil($profil2);
        $dw2->setStatut($statut2);
        $dw2->setAcces($acces5);
        $em->persist($dw2);
        $dw3 = new DroitWorkflow();
        $dw3->setProfil($profil2);
        $dw3->setStatut($statut3);
        $dw3->setAcces($acces5);
        $em->persist($dw3);
        $dw4 = new DroitWorkflow();
        $dw4->setProfil($profil2);
        $dw4->setStatut($statut4);
        $dw4->setAcces($acces5);
        $em->persist($dw4);
        $dw5 = new DroitWorkflow();
        $dw5->setProfil($profil2);
        $dw5->setStatut($statut5);
        $dw5->setAcces($acces5);
        $em->persist($dw5);
        $dw6 = new DroitWorkflow();
        $dw6->setProfil($profil2);
        $dw6->setStatut($statut6);
        $dw6->setAcces($acces5);
        $em->persist($dw6);
        $dw7 = new DroitWorkflow();
        $dw7->setProfil($profil2);
        $dw7->setStatut($statut7);
        $dw7->setAcces($acces5);
        $em->persist($dw7);
        $dw8 = new DroitWorkflow();
        $dw8->setProfil($profil2);
        $dw8->setStatut($statut8);
        $dw8->setAcces($acces5);
        $em->persist($dw8);
        $dw9 = new DroitWorkflow();
        $dw9->setProfil($profil2);
        $dw9->setStatut($statut9);
        $dw9->setAcces($acces5);
        $em->persist($dw9);
        $dw10 = new DroitWorkflow();
        $dw10->setProfil($profil2);
        $dw10->setStatut($statut10);
        $dw10->setAcces($acces5);
        $em->persist($dw10);
        $dw11 = new DroitWorkflow();
        $dw11->setProfil($profil2);
        $dw11->setStatut($statut11);
        $dw11->setAcces($acces5);
        $em->persist($dw11);
        $dw12 = new DroitWorkflow();
        $dw12->setProfil($profil2);
        $dw12->setStatut($statut12);
        $dw12->setAcces($acces5);
        $em->persist($dw12);
        $dw13 = new DroitWorkflow();
        $dw13->setProfil($profil2);
        $dw13->setStatut($statut13);
        $dw13->setAcces($acces5);
        $em->persist($dw13);
        $dw14 = new DroitWorkflow();
        $dw14->setProfil($profil2);
        $dw14->setStatut($statut14);
        $dw14->setAcces($acces5);
        $em->persist($dw14);
        $dw15 = new DroitWorkflow();
        $dw15->setProfil($profil2);
        $dw15->setStatut($statut15);
        $dw15->setAcces($acces5);
        $em->persist($dw15);
        $dw16 = new DroitWorkflow();
        $dw16->setProfil($profil2);
        $dw16->setStatut($statut16);
        $dw16->setAcces($acces5);
        $em->persist($dw16);
        $em->flush();

        // 3 - Qualificateur
        $dw1 = new DroitWorkflow();
        $dw1->setProfil($profil3);
        $dw1->setStatut($statut1);
        $dw1->setAcces($acces1);
        $em->persist($dw1);
        $dw2 = new DroitWorkflow();
        $dw2->setProfil($profil3);
        $dw2->setStatut($statut2);
        $dw2->setAcces($acces3);
        $em->persist($dw2);
        $dw3 = new DroitWorkflow();
        $dw3->setProfil($profil3);
        $dw3->setStatut($statut3);
        $dw3->setAcces($acces3);
        $em->persist($dw3);
        $dw4 = new DroitWorkflow();
        $dw4->setProfil($profil3);
        $dw4->setStatut($statut4);
        $dw4->setAcces($acces3);
        $em->persist($dw4);
        $dw5 = new DroitWorkflow();
        $dw5->setProfil($profil3);
        $dw5->setStatut($statut5);
        $dw5->setAcces($acces1);
        $em->persist($dw5);
        $dw6 = new DroitWorkflow();
        $dw6->setProfil($profil3);
        $dw6->setStatut($statut6);
        $dw6->setAcces($acces1);
        $em->persist($dw6);
        $dw7 = new DroitWorkflow();
        $dw7->setProfil($profil3);
        $dw7->setStatut($statut7);
        $dw7->setAcces($acces1);
        $em->persist($dw7);
        $dw8 = new DroitWorkflow();
        $dw8->setProfil($profil3);
        $dw8->setStatut($statut8);
        $dw8->setAcces($acces1);
        $em->persist($dw8);
        $dw9 = new DroitWorkflow();
        $dw9->setProfil($profil3);
        $dw9->setStatut($statut9);
        $dw9->setAcces($acces1);
        $em->persist($dw9);
        $dw10 = new DroitWorkflow();
        $dw10->setProfil($profil3);
        $dw10->setStatut($statut10);
        $dw10->setAcces($acces1);
        $em->persist($dw10);
        $dw11 = new DroitWorkflow();
        $dw11->setProfil($profil3);
        $dw11->setStatut($statut11);
        $dw11->setAcces($acces1);
        $em->persist($dw11);
        $dw12 = new DroitWorkflow();
        $dw12->setProfil($profil3);
        $dw12->setStatut($statut12);
        $dw12->setAcces($acces1);
        $em->persist($dw12);
        $dw13 = new DroitWorkflow();
        $dw13->setProfil($profil3);
        $dw13->setStatut($statut13);
        $dw13->setAcces($acces3);
        $em->persist($dw13);
        $dw14 = new DroitWorkflow();
        $dw14->setProfil($profil3);
        $dw14->setStatut($statut14);
        $dw14->setAcces($acces3);
        $em->persist($dw14);
        $dw15 = new DroitWorkflow();
        $dw15->setProfil($profil3);
        $dw15->setStatut($statut15);
        $dw15->setAcces($acces3);
        $em->persist($dw15);
        $dw16 = new DroitWorkflow();
        $dw16->setProfil($profil3);
        $dw16->setStatut($statut16);
        $dw16->setAcces($acces1);
        $em->persist($dw16);
        $em->flush();

        // 4 - Chef de produit
        $dw1 = new DroitWorkflow();
        $dw1->setProfil($profil4);
        $dw1->setStatut($statut1);
        $dw1->setAcces($acces3);
        $em->persist($dw1);
        $dw2 = new DroitWorkflow();
        $dw2->setProfil($profil4);
        $dw2->setStatut($statut2);
        $dw2->setAcces($acces3);
        $em->persist($dw2);
        $dw3 = new DroitWorkflow();
        $dw3->setProfil($profil4);
        $dw3->setStatut($statut3);
        $dw3->setAcces($acces1);
        $em->persist($dw3);
        $dw4 = new DroitWorkflow();
        $dw4->setProfil($profil4);
        $dw4->setStatut($statut4);
        $dw4->setAcces($acces1);
        $em->persist($dw4);
        $dw5 = new DroitWorkflow();
        $dw5->setProfil($profil4);
        $dw5->setStatut($statut5);
        $dw5->setAcces($acces1);
        $em->persist($dw5);
        $dw6 = new DroitWorkflow();
        $dw6->setProfil($profil4);
        $dw6->setStatut($statut6);
        $dw6->setAcces($acces1);
        $em->persist($dw6);
        $dw7 = new DroitWorkflow();
        $dw7->setProfil($profil4);
        $dw7->setStatut($statut7);
        $dw7->setAcces($acces1);
        $em->persist($dw7);
        $dw8 = new DroitWorkflow();
        $dw8->setProfil($profil4);
        $dw8->setStatut($statut8);
        $dw8->setAcces($acces1);
        $em->persist($dw8);
        $dw9 = new DroitWorkflow();
        $dw9->setProfil($profil4);
        $dw9->setStatut($statut9);
        $dw9->setAcces($acces1);
        $em->persist($dw9);
        $dw10 = new DroitWorkflow();
        $dw10->setProfil($profil4);
        $dw10->setStatut($statut10);
        $dw10->setAcces($acces1);
        $em->persist($dw10);
        $dw11 = new DroitWorkflow();
        $dw11->setProfil($profil4);
        $dw11->setStatut($statut11);
        $dw11->setAcces($acces1);
        $em->persist($dw11);
        $dw12 = new DroitWorkflow();
        $dw12->setProfil($profil4);
        $dw12->setStatut($statut12);
        $dw12->setAcces($acces3);
        $em->persist($dw12);
        $dw13 = new DroitWorkflow();
        $dw13->setProfil($profil4);
        $dw13->setStatut($statut13);
        $dw13->setAcces($acces3);
        $em->persist($dw13);
        $dw14 = new DroitWorkflow();
        $dw14->setProfil($profil4);
        $dw14->setStatut($statut14);
        $dw14->setAcces($acces1);
        $em->persist($dw14);
        $dw15 = new DroitWorkflow();
        $dw15->setProfil($profil4);
        $dw15->setStatut($statut15);
        $dw15->setAcces($acces1);
        $em->persist($dw15);
        $dw16 = new DroitWorkflow();
        $dw16->setProfil($profil4);
        $dw16->setStatut($statut16);
        $dw16->setAcces($acces1);
        $em->persist($dw16);
        $em->flush();

        // 5 - Intégrateur
        $dw1 = new DroitWorkflow();
        $dw1->setProfil($profil5);
        $dw1->setStatut($statut1);
        $dw1->setAcces($acces1);
        $em->persist($dw1);
        $dw2 = new DroitWorkflow();
        $dw2->setProfil($profil5);
        $dw2->setStatut($statut2);
        $dw2->setAcces($acces1);
        $em->persist($dw2);
        $dw3 = new DroitWorkflow();
        $dw3->setProfil($profil5);
        $dw3->setStatut($statut3);
        $dw3->setAcces($acces1);
        $em->persist($dw3);
        $dw4 = new DroitWorkflow();
        $dw4->setProfil($profil5);
        $dw4->setStatut($statut4);
        $dw4->setAcces($acces1);
        $em->persist($dw4);
        $dw5 = new DroitWorkflow();
        $dw5->setProfil($profil5);
        $dw5->setStatut($statut5);
        $dw5->setAcces($acces3);
        $em->persist($dw5);
        $dw6 = new DroitWorkflow();
        $dw6->setProfil($profil5);
        $dw6->setStatut($statut6);
        $dw6->setAcces($acces3);
        $em->persist($dw6);
        $dw7 = new DroitWorkflow();
        $dw7->setProfil($profil5);
        $dw7->setStatut($statut7);
        $dw7->setAcces($acces3);
        $em->persist($dw7);
        $dw8 = new DroitWorkflow();
        $dw8->setProfil($profil5);
        $dw8->setStatut($statut8);
        $dw8->setAcces($acces3);
        $em->persist($dw8);
        $dw9 = new DroitWorkflow();
        $dw9->setProfil($profil5);
        $dw9->setStatut($statut9);
        $dw9->setAcces($acces3);
        $em->persist($dw9);
        $dw10 = new DroitWorkflow();
        $dw10->setProfil($profil5);
        $dw10->setStatut($statut10);
        $dw10->setAcces($acces3);
        $em->persist($dw10);
        $dw11 = new DroitWorkflow();
        $dw11->setProfil($profil5);
        $dw11->setStatut($statut11);
        $dw11->setAcces($acces3);
        $em->persist($dw11);
        $dw12 = new DroitWorkflow();
        $dw12->setProfil($profil5);
        $dw12->setStatut($statut12);
        $dw12->setAcces($acces1);
        $em->persist($dw12);
        $dw13 = new DroitWorkflow();
        $dw13->setProfil($profil5);
        $dw13->setStatut($statut13);
        $dw13->setAcces($acces1);
        $em->persist($dw13);
        $dw14 = new DroitWorkflow();
        $dw14->setProfil($profil5);
        $dw14->setStatut($statut14);
        $dw14->setAcces($acces1);
        $em->persist($dw14);
        $dw15 = new DroitWorkflow();
        $dw15->setProfil($profil5);
        $dw15->setStatut($statut15);
        $dw15->setAcces($acces1);
        $em->persist($dw15);
        $dw16 = new DroitWorkflow();
        $dw16->setProfil($profil5);
        $dw16->setStatut($statut16);
        $dw16->setAcces($acces3);
        $em->persist($dw16);
        $em->flush();

        // 6 - Technicien support
        $dw1 = new DroitWorkflow();
        $dw1->setProfil($profil6);
        $dw1->setStatut($statut1);
        $dw1->setAcces($acces5);
        $em->persist($dw1);
        $dw2 = new DroitWorkflow();
        $dw2->setProfil($profil6);
        $dw2->setStatut($statut2);
        $dw2->setAcces($acces5);
        $em->persist($dw2);
        $dw3 = new DroitWorkflow();
        $dw3->setProfil($profil6);
        $dw3->setStatut($statut3);
        $dw3->setAcces($acces5);
        $em->persist($dw3);
        $dw4 = new DroitWorkflow();
        $dw4->setProfil($profil6);
        $dw4->setStatut($statut4);
        $dw4->setAcces($acces5);
        $em->persist($dw4);
        $dw5 = new DroitWorkflow();
        $dw5->setProfil($profil6);
        $dw5->setStatut($statut5);
        $dw5->setAcces($acces5);
        $em->persist($dw5);
        $dw6 = new DroitWorkflow();
        $dw6->setProfil($profil6);
        $dw6->setStatut($statut6);
        $dw6->setAcces($acces5);
        $em->persist($dw6);
        $dw7 = new DroitWorkflow();
        $dw7->setProfil($profil6);
        $dw7->setStatut($statut7);
        $dw7->setAcces($acces5);
        $em->persist($dw7);
        $dw8 = new DroitWorkflow();
        $dw8->setProfil($profil6);
        $dw8->setStatut($statut8);
        $dw8->setAcces($acces5);
        $em->persist($dw8);
        $dw9 = new DroitWorkflow();
        $dw9->setProfil($profil6);
        $dw9->setStatut($statut9);
        $dw9->setAcces($acces5);
        $em->persist($dw9);
        $dw10 = new DroitWorkflow();
        $dw10->setProfil($profil6);
        $dw10->setStatut($statut10);
        $dw10->setAcces($acces5);
        $em->persist($dw10);
        $dw11 = new DroitWorkflow();
        $dw11->setProfil($profil6);
        $dw11->setStatut($statut11);
        $dw11->setAcces($acces5);
        $em->persist($dw11);
        $dw12 = new DroitWorkflow();
        $dw12->setProfil($profil6);
        $dw12->setStatut($statut12);
        $dw12->setAcces($acces5);
        $em->persist($dw12);
        $dw13 = new DroitWorkflow();
        $dw13->setProfil($profil6);
        $dw13->setStatut($statut13);
        $dw13->setAcces($acces5);
        $em->persist($dw13);
        $dw14 = new DroitWorkflow();
        $dw14->setProfil($profil6);
        $dw14->setStatut($statut14);
        $dw14->setAcces($acces5);
        $em->persist($dw14);
        $dw15 = new DroitWorkflow();
        $dw15->setProfil($profil6);
        $dw15->setStatut($statut15);
        $dw15->setAcces($acces5);
        $em->persist($dw15);
        $dw16 = new DroitWorkflow();
        $dw16->setProfil($profil6);
        $dw16->setStatut($statut16);
        $dw16->setAcces($acces5);
        $em->persist($dw16);
        $em->flush();

        // 7 - Lecteur avancé
        $dw1 = new DroitWorkflow();
        $dw1->setProfil($profil7);
        $dw1->setStatut($statut1);
        $dw1->setAcces($acces1);
        $em->persist($dw1);
        $dw2 = new DroitWorkflow();
        $dw2->setProfil($profil7);
        $dw2->setStatut($statut2);
        $dw2->setAcces($acces1);
        $em->persist($dw2);
        $dw3 = new DroitWorkflow();
        $dw3->setProfil($profil7);
        $dw3->setStatut($statut3);
        $dw3->setAcces($acces1);
        $em->persist($dw3);
        $dw4 = new DroitWorkflow();
        $dw4->setProfil($profil7);
        $dw4->setStatut($statut4);
        $dw4->setAcces($acces1);
        $em->persist($dw4);
        $dw5 = new DroitWorkflow();
        $dw5->setProfil($profil7);
        $dw5->setStatut($statut5);
        $dw5->setAcces($acces1);
        $em->persist($dw5);
        $dw6 = new DroitWorkflow();
        $dw6->setProfil($profil7);
        $dw6->setStatut($statut6);
        $dw6->setAcces($acces2);
        $em->persist($dw6);
        $dw7 = new DroitWorkflow();
        $dw7->setProfil($profil7);
        $dw7->setStatut($statut7);
        $dw7->setAcces($acces2);
        $em->persist($dw7);
        $dw8 = new DroitWorkflow();
        $dw8->setProfil($profil7);
        $dw8->setStatut($statut8);
        $dw8->setAcces($acces2);
        $em->persist($dw8);
        $dw9 = new DroitWorkflow();
        $dw9->setProfil($profil7);
        $dw9->setStatut($statut9);
        $dw9->setAcces($acces2);
        $em->persist($dw9);
        $dw10 = new DroitWorkflow();
        $dw10->setProfil($profil7);
        $dw10->setStatut($statut10);
        $dw10->setAcces($acces2);
        $em->persist($dw10);
        $dw11 = new DroitWorkflow();
        $dw11->setProfil($profil7);
        $dw11->setStatut($statut11);
        $dw11->setAcces($acces2);
        $em->persist($dw11);
        $dw12 = new DroitWorkflow();
        $dw12->setProfil($profil7);
        $dw12->setStatut($statut12);
        $dw12->setAcces($acces1);
        $em->persist($dw12);
        $dw13 = new DroitWorkflow();
        $dw13->setProfil($profil7);
        $dw13->setStatut($statut13);
        $dw13->setAcces($acces1);
        $em->persist($dw13);
        $dw14 = new DroitWorkflow();
        $dw14->setProfil($profil7);
        $dw14->setStatut($statut14);
        $dw14->setAcces($acces1);
        $em->persist($dw14);
        $dw15 = new DroitWorkflow();
        $dw15->setProfil($profil7);
        $dw15->setStatut($statut15);
        $dw15->setAcces($acces1);
        $em->persist($dw15);
        $dw16 = new DroitWorkflow();
        $dw16->setProfil($profil7);
        $dw16->setStatut($statut16);
        $dw16->setAcces($acces1);
        $em->persist($dw16);
        $em->flush();

        // 8 - Utilisateur anonyme/non connecté
        $dw1 = new DroitWorkflow();
        $dw1->setProfil($profil8);
        $dw1->setStatut($statut1);
        $dw1->setAcces($acces1);
        $em->persist($dw1);
        $dw2 = new DroitWorkflow();
        $dw2->setProfil($profil8);
        $dw2->setStatut($statut2);
        $dw2->setAcces($acces1);
        $em->persist($dw2);
        $dw3 = new DroitWorkflow();
        $dw3->setProfil($profil8);
        $dw3->setStatut($statut3);
        $dw3->setAcces($acces1);
        $em->persist($dw3);
        $dw4 = new DroitWorkflow();
        $dw4->setProfil($profil8);
        $dw4->setStatut($statut4);
        $dw4->setAcces($acces1);
        $em->persist($dw4);
        $dw5 = new DroitWorkflow();
        $dw5->setProfil($profil8);
        $dw5->setStatut($statut5);
        $dw5->setAcces($acces1);
        $em->persist($dw5);
        $dw6 = new DroitWorkflow();
        $dw6->setProfil($profil8);
        $dw6->setStatut($statut6);
        $dw6->setAcces($acces2);
        $em->persist($dw6);
        $dw7 = new DroitWorkflow();
        $dw7->setProfil($profil8);
        $dw7->setStatut($statut7);
        $dw7->setAcces($acces2);
        $em->persist($dw7);
        $dw8 = new DroitWorkflow();
        $dw8->setProfil($profil8);
        $dw8->setStatut($statut8);
        $dw8->setAcces($acces2);
        $em->persist($dw8);
        $dw9 = new DroitWorkflow();
        $dw9->setProfil($profil8);
        $dw9->setStatut($statut9);
        $dw9->setAcces($acces2);
        $em->persist($dw9);
        $dw10 = new DroitWorkflow();
        $dw10->setProfil($profil8);
        $dw10->setStatut($statut10);
        $dw10->setAcces($acces2);
        $em->persist($dw10);
        $dw11 = new DroitWorkflow();
        $dw11->setProfil($profil8);
        $dw11->setStatut($statut11);
        $dw11->setAcces($acces2);
        $em->persist($dw11);
        $dw12 = new DroitWorkflow();
        $dw12->setProfil($profil8);
        $dw12->setStatut($statut12);
        $dw12->setAcces($acces1);
        $em->persist($dw12);
        $dw13 = new DroitWorkflow();
        $dw13->setProfil($profil8);
        $dw13->setStatut($statut13);
        $dw13->setAcces($acces1);
        $em->persist($dw13);
        $dw14 = new DroitWorkflow();
        $dw14->setProfil($profil8);
        $dw14->setStatut($statut14);
        $dw14->setAcces($acces1);
        $em->persist($dw14);
        $dw15 = new DroitWorkflow();
        $dw15->setProfil($profil8);
        $dw15->setStatut($statut15);
        $dw15->setAcces($acces1);
        $em->persist($dw15);
        $dw16 = new DroitWorkflow();
        $dw16->setProfil($profil8);
        $dw16->setStatut($statut16);
        $dw16->setAcces($acces1);
        $em->persist($dw16);

        // Droits page
        // Listes 
        $liste1 = new Liste();
        $liste1->setLibelle("Types d'application");
        $em->persist($liste1); //
        $liste2 = new Liste();
        $liste2->setLibelle("Liaisons Office");
        $em->persist($liste2); //
        $liste3 = new Liste();
        $liste3->setLibelle("Types de package");
        $em->persist($liste3); //
        $liste4 = new Liste();
        $liste4->setLibelle("Paliers techniques");
        $em->persist($liste4); //
        $liste5 = new Liste();
        $liste5->setLibelle("Versions outil de packaging");
        $em->persist($liste5); //
        $liste6 = new Liste();
        $liste6->setLibelle("Version template");
        $em->persist($liste6); //
        $liste7 = new Liste();
        $liste7->setLibelle("Versions AppV XP");
        $em->persist($liste7);
        $liste8 = new Liste();
        $liste8->setLibelle("Versions AppV W7");
        $em->persist($liste8);
        $liste9 = new Liste();
        $liste9->setLibelle("Entrées TNS NAMES");
        $em->persist($liste9);
        $liste10 = new Liste();
        $liste10->setLibelle("Types de script");
        $em->persist($liste10);
        $liste11 = new Liste();
        $liste11->setLibelle("Technos");
        $em->persist($liste11);
        $liste12 = new Liste();
        $liste12->setLibelle("Conditions d'exécution");
        $em->persist($liste12);
        $liste13 = new Liste();
        $liste13->setLibelle("Conditions de lancement");
        $em->persist($liste13);
        $liste14 = new Liste();
        $liste14->setLibelle("Modes de gestion");
        $em->persist($liste14);
        $liste15 = new Liste();
        $liste15->setLibelle("Modalités d'acquisition");
        $em->persist($liste15);
        $liste16 = new Liste();
        $liste16->setLibelle("Modes d'installation souhaité");
        $em->persist($liste16);
        $liste17 = new Liste();
        $liste17->setLibelle("Usage catalogue SIT");
        $em->persist($liste17);
        $liste18 = new Liste();
        $liste18->setLibelle("Types de catalogue");
        $em->persist($liste18);
        $liste19 = new Liste();
        $liste19->setLibelle("Types de qualification");
        $em->persist($liste19);
        $liste20 = new Liste();
        $liste20->setLibelle("Statuts application");
        $em->persist($liste20);
        $liste21 = new Liste();
        $liste21->setLibelle("Types de mises à jour");
        $em->persist($liste21);
        $liste22 = new Liste();
        $liste22->setLibelle("Os Cibles");
        $em->persist($liste22);
        $liste23 = new Liste();
        $liste23->setLibelle("Liaison Access");
        $em->persist($liste23);
        $liste24 = new Liste();
        $liste24->setLibelle("Statut du patch");
        $em->persist($liste24);


        // Items
        // 1 - Types d'application
        $item1 = new Item();
        $item1->setListe($liste1);
        $item1->setLibelle("Bureautique");
        $em->persist($item1);
        $item2 = new Item();
        $item2->setListe($liste1);
        $item2->setLibelle("Métier");
        $em->persist($item2);
        $item3 = new Item();
        $item3->setListe($liste1);
        $item3->setLibelle("Progiciel");
        $em->persist($item3);
        $item4 = new Item();
        $item4->setListe($liste1);
        $item4->setLibelle("Système");
        $em->persist($item4);
        $item5 = new Item();
        $item5->setListe($liste1);
        $item5->setLibelle("Maintenance");
        $em->persist($item5);
        $item6 = new Item();
        $item6->setListe($liste1);
        $item6->setLibelle("Utilitaire");
        $em->persist($item6);
        $item7 = new Item();
        $item7->setListe($liste1);
        $item7->setLibelle("Anti-virus/Sécurité");
        $em->persist($item7);
        $item8 = new Item();
        $item8->setListe($liste1);
        $item8->setLibelle("Sauvegarde");
        $em->persist($item8);
        $item9 = new Item();
        $item9->setListe($liste1);
        $item9->setLibelle("Outil de communication");
        $em->persist($item9);
        $item10 = new Item();
        $item10->setListe($liste1);
        $item10->setLibelle("Exploitation/Supervision");
        $em->persist($item10);

        // 2 - Liaisons Office
        $item26 = new Item();
        $item26->setListe($liste2);
        $item26->setLibelle("Utilisation Outlook");
        $em->persist($item26);
        $item27 = new Item();
        $item27->setListe($liste2);
        $item27->setLibelle("Utilisation Winword");
        $em->persist($item27);
        $item28 = new Item();
        $item28->setListe($liste2);
        $item28->setLibelle("Utilisation Excel");
        $em->persist($item28);
        $item29 = new Item();
        $item29->setListe($liste2);
        $item29->setLibelle("Utilisation Powerpoint");
        $em->persist($item29);
        $item30 = new Item();
        $item30->setListe($liste2);
        $item30->setLibelle("Composant (ou DLL Ms Office pré-requis de l\'application");
        $em->persist($item30);
        $item31 = new Item();
        $item31->setListe($liste2);
        $item31->setLibelle("Existence de liens ELO/COM");
        $em->persist($item31);
        $item32 = new Item();
        $item32->setListe($liste2);
        $item32->setLibelle("Existence de liens DDE");
        $em->persist($item32);
        $item33 = new Item();
        $item33->setListe($liste2);
        $item33->setLibelle("Utilisation de macros");
        $em->persist($item33);
        $item34 = new Item();
        $item34->setListe($liste2);
        $item34->setLibelle("Export de fichiers (ou modèles de documents) Ms Office");
        $em->persist($item34);
        $item35 = new Item();
        $item35->setListe($liste2);
        $item35->setLibelle("Import de fichiers (ou modèles de documents) Ms Office");
        $em->persist($item35);

        // 3 - Types de package
        $item19 = new Item();
        $item19->setListe($liste3);
        $item19->setLibelle("AUTO-IT (LAUNCHER AUTOIT QUI PILOTE UN EXE, UNE MSI OU UNE MSI/SMT)");
        $em->persist($item19);
        $item18 = new Item();
        $item18->setListe($liste3);
        $item18->setLibelle("EXE (MSI+EXE+CAB)");
        $em->persist($item18);
        $item20 = new Item();
        $item20->setListe($liste3);
        $item20->setLibelle("LAUNCHER INSTALLSHIELD");
        $em->persist($item20);
        $item21 = new Item();
        $item21->setListe($liste3);
        $item21->setLibelle("MSI (MSI+CAB)");
        $em->persist($item21);
        $item22 = new Item();
        $item22->setListe($liste3);
        $item22->setLibelle("MSI/MST (MSI+MST+CAB)");
        $em->persist($item22);

        // 4 - Paliers techniques
        $item36 = new Item();
        $item36->setListe($liste4);
        $item36->setLibelle("XP SP1");
        $em->persist($item36);
        $item37 = new Item();
        $item37->setListe($liste4);
        $item37->setLibelle("XP SP2");
        $em->persist($item37);
        $item38 = new Item();
        $item38->setListe($liste4);
        $item38->setLibelle("NT");
        $em->persist($item38);
        $item39 = new Item();
        $item39->setListe($liste4);
        $item39->setLibelle("W7 codée en 32 bits");
        $em->persist($item39);
        $item40 = new Item();
        $item40->setListe($liste4);
        $item40->setLibelle("W7 codée en 64 bits");
        $em->persist($item40);

        // 5 - Versions de l'outil packaging
        $item23 = new Item();
        $item23->setListe($liste5);
        $item23->setLibelle("AdminStudio 6");
        $em->persist($item23);
        $item24 = new Item();
        $item24->setListe($liste5);
        $item24->setLibelle("AdminStudio FLEXNET 7");
        $em->persist($item24);
        $item25 = new Item();
        $item25->setListe($liste5);
        $item25->setLibelle("AdminStudio 5.x");
        $em->persist($item25);

        // 6 - Versions template
        // 7 - Versions AppV XP
        // 8 - Versions AppV W7
        // 9 - Entrées TNS NAMES
        // 10 - Types de script
        $script1 = new Item();
        $script1->setListe($liste10);
        $script1->setLibelle("ActiveSetup");
        $em->persist($script1);
        $script2 = new Item();
        $script2->setListe($liste10);
        $script2->setLibelle("PreInstall");
        $em->persist($script2);
        $script3 = new Item();
        $script3->setListe($liste10);
        $script3->setLibelle("PostInstall");
        $em->persist($script3);

        // 11 - Technos
        $techno1 = new Item();
        $techno1->setListe($liste11);
        $techno1->setLibelle("VBS");
        $em->persist($techno1);
        $techno2 = new Item();
        $techno2->setListe($liste11);
        $techno2->setLibelle("Powershell");
        $em->persist($techno2);
        //$techno3 = new Item();	$techno3->setListe($liste11);	$techno3->setLibelle("");				$em->persist($techno3);
        // 12 - Conditions d'exécution
        $cond1 = new Item();
        $cond1->setListe($liste12);
        $cond1->setLibelle("Télédistribution");
        $em->persist($cond1);
        $cond2 = new Item();
        $cond2->setListe($liste12);
        $cond2->setLibelle("Master");
        $em->persist($cond2);
        $cond3 = new Item();
        $cond3->setListe($liste12);
        $cond3->setLibelle("Publication");
        $em->persist($cond3);

        // 13 - conditions de lancement
        $cond4 = new Item();
        $cond4->setListe($liste13);
        $cond4->setLibelle("MSI (custom action)");
        $em->persist($cond4);
        $cond5 = new Item();
        $cond5->setListe($liste13);
        $cond5->setLibelle("ActiveSetup");
        $em->persist($cond5);
        $cond6 = new Item();
        $cond6->setListe($liste13);
        $cond6->setLibelle("RunOnce");
        $em->persist($cond6);
        $cond7 = new Item();
        $cond7->setListe($liste13);
        $cond7->setLibelle("PreInstall");
        $em->persist($cond7);
        $cond8 = new Item();
        $cond8->setListe($liste13);
        $cond8->setLibelle("PostInstall");
        $em->persist($cond8);

        // 14 - Modes de gestion
        $mode1 = new Item();
        $mode1->setListe($liste14);
        $mode1->setLibelle("mode1");
        $em->persist($mode1);
        $mode2 = new Item();
        $mode2->setListe($liste14);
        $mode2->setLibelle("mode2");
        $em->persist($mode2);

        // 15 - Modalités d'acquisition
        // $modal1 = new Item();	$modal1->setListe($liste15);	$item40->setLibelle("");					$êm->persist($modal1);
        // 16 - Modes d'installation souhaitée
        $item14 = new Item();
        $item14->setListe($liste16);
        $item14->setLibelle("Publication");
        $em->persist($item14);
        $item15 = new Item();
        $item15->setListe($liste16);
        $item15->setLibelle("Télédistribution");
        $em->persist($item15);
        $item16 = new Item();
        $item16->setListe($liste16);
        $item16->setLibelle("Publication et télédistribution");
        $em->persist($item16);
        $item17 = new Item();
        $item17->setListe($liste16);
        $item17->setLibelle("Non publiée");
        $em->persist($item17);

        // 17 - Usage catalogue SIT
        // 18 - Types de catalogue
        // 19 - Types de qualification
        $qual1 = new Item();
        $qual1->setListe($liste19);
        $qual1->setLibelle("type q1");
        $em->persist($qual1);
        $qual2 = new Item();
        $qual2->setListe($liste19);
        $qual2->setLibelle("type q2");
        $em->persist($qual2);

        // 20 - Statuts d'application
        $statut1 = new Item();
        $statut1->setListe($liste20);
        $statut1->setLibelle("Planifiée");
        $em->persist($statut1);
        $statut2 = new Item();
        $statut2->setListe($liste20);
        $statut2->setLibelle("Pré-qualifiée");
        $em->persist($statut2);
        $statut3 = new Item();
        $statut3->setListe($liste20);
        $statut3->setLibelle("Packaging");
        $em->persist($statut3);
        $statut4 = new Item();
        $statut4->setListe($liste20);
        $statut4->setLibelle("Pré-production");
        $em->persist($statut4);
        $statut5 = new Item();
        $statut5->setListe($liste20);
        $statut5->setLibelle("En production");
        $em->persist($statut5);
        $statut6 = new Item();
        $statut6->setListe($liste20);
        $statut6->setLibelle("Publiée");
        $em->persist($statut6);
        $statut7 = new Item();
        $statut7->setListe($liste20);
        $statut7->setLibelle("Non publiée");
        $em->persist($statut7);
        $statut8 = new Item();
        $statut8->setListe($liste20);
        $statut8->setLibelle("Télédistribuée");
        $em->persist($statut8);
        $statut9 = new Item();
        $statut9->setListe($liste20);
        $statut9->setLibelle("Publiée et télédistribuée");
        $em->persist($statut9);
        $statut10 = new Item();
        $statut10->setListe($liste20);
        $statut10->setLibelle("Publiée pour maintenance");
        $em->persist($statut10);
        $statut11 = new Item();
        $statut11->setListe($liste20);
        $statut11->setLibelle("Retirée de la production");
        $em->persist($statut11);

        // 21 - Types de mise à jour 
        $maj1 = new Item();
        $maj1->setListe($liste21);
        $maj1->setLibelle("Normale");
        $em->persist($maj1);
        $maj2 = new Item();
        $maj2->setListe($liste21);
        $maj2->setLibelle("Urgente");
        $em->persist($maj2);

        // 22 - OS Cibles 
        $os1 = new Item();
        $os1->setListe($liste22);
        $os1->setLibelle("Windows 7");
        $em->persist($os1);
        $os2 = new Item();
        $os2->setListe($liste22);
        $os2->setLibelle("Windows XP");
        $em->persist($os2);
        $os3 = new Item();
        $os3->setListe($liste22);
        $os3->setLibelle("Windows 7/Windows XP");
        $em->persist($os3);

        // 23 - Liaisons Access
        $liais1 = new Item();
        $liais1->setListe($liste23);
        $liais1->setLibelle("");
        $em->persist($liais1);
        $liais2 = new Item();
        $liais2->setListe($liste23);
        $liais2->setLibelle("");
        $em->persist($liais2);
        $liais3 = new Item();
        $liais3->setListe($liste23);
        $liais3->setLibelle("");
        $em->persist($liais3);
        $liais4 = new Item();
        $liais4->setListe($liste23);
        $liais4->setLibelle("");
        $em->persist($liais4);
        /**/
        $em->flush();
        $this->get('session')->getFlashBag()->add('notice', 'BDD initialisée');


        return $this->redirect($this->generateUrl('listerApplications'));
    }

    public function voirSuiviQualifAction($page, $triSuiviQualif, $idPackage) {

        $maxPerPage = 10; // nombre d'applications affichées par page
        $packageRepository = $this->getDoctrine()->getManager()->getRepository('BaquarasTestBundle:Package');

        $itemsPackage = $packageRepository->countItemsPackages();

        $packageListe = $packageRepository->querySuivreQualif($triSuiviQualif, $page, $maxPerPage);

        $pagination = array(
            'page' => $page,
            'route' => 'voirSuiviQualif',
            'pages_count' => ceil($itemsPackage / $maxPerPage),
            'route_params' => array()
        );

        $utilisateur = $this->getDoctrine()->getRepository('BaquarasTestBundle:Utilisateur')->find(1);
        $statuts = $this->getDoctrine()->getRepository('BaquarasTestBundle:Item')->findBy(array('liste' => 20));
        $droits = $this->getDoctrine()->getRepository('BaquarasTestBundle:DroitWorkflow')->findAll();

//*****************************************************************************************************************************************
        if (isset($idPackage)) {
            $package = $packageRepository->find($idPackage);
            $id_Statut = $package->getStatutQualif()->getId();

            if (!empty($id_Statut) && $id_Statut >= 12) {
                $newIdStatut = $id_Statut - 11;
            } else {
                $newIdStatut = $id_Statut + 11;
            }


            $statuts = $this->getDoctrine()->getManager()->find('BaquarasTestBundle:Statut', $newIdStatut);
            $package->setStatutQualif($statuts);

            $bdd = $this->getDoctrine()->getManager();
            $bdd->persist($package);
            $bdd->flush();


            return $this->redirect($this->generateUrl('voirSuiviQualif'));
        }
//********************************************************************************************************************************************************	

        return $this->render('BaquarasTestBundle:Default:voirSuiviQualif.html.twig', array(
                    'packages' => $packageListe,
                    'pagination' => $pagination,
                    'utilisateur' => $utilisateur,
                    'statuts' => $statuts,
                    'droits' => $droits
        ));
    }

    /**
     * @ParamConverter("package", options={"mapping": {"id": "id"}})
     */
    public function modifStatutQualifAction(Request $request, Package $package) {
        $libelleStatut = $package->getStatutQualif()->getLibelle();
        $idStatut = $package->getStatutQualif()->getId();
        $newStatutId = $idStatut + 1;
        $statut = $this->getDoctrine()->getManager()->find('BaquarasTestBundle:Statut', $newStatutId);
        $libelle = $statut->getLibelle();
        $numeroLot = $package->getQualification()->getNumeroLot();

        $form = $this->createFormBuilder()
                ->add('statutQualif', 'choice', array(
                    'label' => 'Statut de la qualification',
                    'choices' => array('accepter' => 'Phase ' . $libelleStatut . ' acceptée, la qualification passe dans la phase ' . $libelle . '.',
                        'annuler' => 'Qualification annulée',
                        'suspendre' => 'Qualification suspendue'),
                    'expanded' => true,
                    'multiple' => false))
                ->add('commentaire', 'textarea', array(
                    'label' => 'Commentaire'))
                ->add('lotNumero', 'text', array(
                    'label' => 'Numéro de lot',
                    'attr' => array('value' => $numeroLot)))
                ->add('cancel', 'reset', array(
                    'label' => 'Annuler'))
                ->add('save', 'submit', array(
                    'label' => 'Enregistrer les modifications',
                    'attr' => array('value' => $package->getId())
                ))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $statutQualif = $form['statutQualif']->getData();
            $commentaire = $form['commentaire']->getData();
            $lotNumero = $form['lotNumero']->getData();

            switch ($statutQualif) {
                case 'accepter':
                    if ($idStatut <= 4) {
                        $newIdStatut = $idStatut + 1;
                        $statuts = $this->getDoctrine()->getManager()->find('BaquarasTestBundle:Statut', $newIdStatut);
                        $package->setStatutQualif($statuts);

                        $bdd = $this->getDoctrine()->getManager();
                        $bdd->persist($package);
                        $bdd->flush();
                    }
                    break;
                case 'annuler':
                    if ($idStatut <= 5 || ($idStatut >= 12 && $idStatut <= 17)) {
                        $newIdStatut = 17;
                        $statuts = $this->getDoctrine()->getManager()->find('BaquarasTestBundle:Statut', $newIdStatut);
                        $package->setStatutQualif($statuts);

                        $bdd = $this->getDoctrine()->getManager();
                        $bdd->persist($package);
                        $bdd->flush();
                    }
                    break;
                case 'suspendre':
                    if ($idStatut <= 5) {
                        $newIdStatut = $idStatut + 11;
                        $statuts = $this->getDoctrine()->getManager()->find('BaquarasTestBundle:Statut', $newIdStatut);
                        $package->setStatutQualif($statuts);

                        $bdd = $this->getDoctrine()->getManager();
                        $bdd->persist($package);
                        $bdd->flush();
                    }
                    break;
            }
            if (!empty($commentaire)) {
                $evolutionStatut = new EvolutionStatut();
                $evolutionStatut->setCommentaire($commentaire);

                $bdd = $this->getDoctrine()->getManager();
                $bdd->persist($evolutionStatut);
                $bdd->flush();
            }
            if (!empty($lotNumero)) {
                $em = $this->getDoctrine()->getManager();
                $idQualification = $package->getQualification()->getId();
                $qualification = $em->getRepository('BaquarasTestBundle:Qualification')->find($idQualification);

                if (!$qualification) {
                    throw $this->createNotFoundException(
                            'Aucun produit trouvé pour cet id : ' . $idQualification);
                }
                $qualification->setNumeroLot($lotNumero);

                $em->flush();
            }
            $this->get('session')->getFlashBag()->add('notice', 'Statut mis à jour');

            return $this->redirect($this->generateUrl('voirSuiviQualif'));
        }

        return $this->render('BaquarasTestBundle:Default:modifStatutQualif.html.twig', array(
                    'package' => $package,
                    'form' => $form->createView()
        ));
    }
    
    /*
     * get appli from siera
     * @param integer $idSeria
     * @return response()
     */
    public function rechercheSieraAction(Request $request, $siera)
    {
        $results = array();
        if($request->request->get('type') == 'application') {
            $results = $this->container->get('baquaras.connect_siera')->getApplicationNameSiera($siera);
        } elseif ($request->request->get('type') == 'client') {
            $siera = str_replace('%20', ' ', $siera);
            $results = $this->container->get('baquaras.connect_siera')->getClientNameSiera($siera);
        }
        
        return new Response(json_encode($results));
        
    }
    

}
