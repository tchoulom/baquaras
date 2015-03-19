<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Package
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\PackageRepository")
 */
class Package
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_Publication", type="string", length=255, nullable=true)
     */
    private $nomPublication;

 	/**
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="Type_Package", referencedColumnName="id", nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="Taille", type="string", length=255, nullable=true)
     */
    private $taille;

    /**
     * @var string
     *
     * @ORM\Column(name="Chemin", type="string", length=255, nullable=true)
     */
    private $chemin;

    /**
     * @var string
     *
     * @ORM\Column(name="Espace_Disque_Installe", type="string", length=255, nullable=true)
     */
    private $espaceDisqueInstalle;

	/**
     * @var string
     *
     * @ORM\Column(name="Ligne_Commande_Publication", type="string", length=255, nullable=true)
     */
    private $ligneCommandePublication;

    /**
     * @var string
     *
     * @ORM\Column(name="Ligne_Commande_Teledistribution", type="string", length=255, nullable=true)
     */
    private $ligneCommandeTeledistribution;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Redemarrage_Outil_Developpement", type="boolean", nullable=true)
     */
    private $redemarrageOutilDeveloppement;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Redemarrage_Requis", type="boolean", nullable=true)
     */
    private $redemarrageRequis;
	
 	/**
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="Version_Template", referencedColumnName="id", nullable=true)
     */
    private $versionTemplate;

 	/**
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="Version_Outil_Packaging", referencedColumnName="id", nullable=true)
     */
    private $versionOutilPackaging;

    /**
     * @var string
     *
     * @ORM\Column(name="Product_Code", type="string", length=255, nullable=true)
     */
    private $productCode;

    /**
     * @var string
     *
     * @ORM\Column(name="Active_Setup", type="string", length=255, nullable=true)
     */
    private $activeSetup;

    /**
     * @var boolean
     *
     * @ORM\Column(name="TNS_NAMES", type="boolean", nullable=true)
     */
    private $tNSNAMES;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_Entree_TNS_NAMES", type="string", length=255, nullable=true)
     */
    private $nomEntreeTNSNAMES;

    /**
     * @var string
     *
     * @ORM\Column(name="Commentaire", type="string", length=2000, nullable=true)
     */
    private $commentaire;

   /**
     * @ORM\OneToOne(targetEntity="Fichier", cascade={"persist"})
     */
    private $dossierTechnique;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Creation_Custom_Actions", type="boolean", nullable=true)
     */
    private $creationCustomActions;
	
 	/**
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="paliers_techniques", referencedColumnName="id", nullable=true)
     */
    private $paliersTechniques;
	
	/**
     * @ORM\ManyToOne(targetEntity="ModeOperatoire", inversedBy="packages")
     * @ORM\JoinColumn(name="mode_operatoire", referencedColumnName="id", nullable=true)
     */
    private $modeOperatoire;	
	
 	/**
     * @ORM\ManyToOne(targetEntity="Statut", inversedBy="packages")
     * @ORM\JoinColumn(name="statut", referencedColumnName="id", nullable=true)
     */
    private $statutQualif;	

	/**
     * @ORM\ManyToOne(targetEntity="Application", inversedBy="packages")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id", nullable=true)
     */
    private $application;	
	
    /**
     * @ORM\OneToMany(targetEntity="EvolutionStatut", mappedBy="package")
     **/
    private $evolutionsStatut;
	
	/**
     * @ORM\OneToMany(targetEntity="ModificationApplication", mappedBy="package")
     **/
    private $modifsApplication;

	/**
     * @ORM\OneToOne(targetEntity="Qualification")
     * @ORM\JoinColumn(name="qualification", referencedColumnName="id", nullable=true)
     **/
    private $qualification;

	/**
     * @ORM\OneToMany(targetEntity="Script", mappedBy="package")
	 **/
    private $scripts;
	
	/**
     * @ORM\OneToOne(targetEntity="InstallationPackage")
     * @ORM\JoinColumn(name="installation_id", referencedColumnName="id", nullable=true)
     **/
    private $installation;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->evolutionsStatut = new \Doctrine\Common\Collections\ArrayCollection();
        $this->scripts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Package
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set nomPublication
     *
     * @param string $nomPublication
     * @return Package
     */
    public function setNomPublication($nomPublication)
    {
        $this->nomPublication = $nomPublication;

        return $this;
    }

    /**
     * Get nomPublication
     *
     * @return string 
     */
    public function getNomPublication()
    {
        return $this->nomPublication;
    }

    /**
     * Set taille
     *
     * @param string $taille
     * @return Package
     */
    public function setTaille($taille)
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * Get taille
     *
     * @return string 
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * Set chemin
     *
     * @param string $chemin
     * @return Package
     */
    public function setChemin($chemin)
    {
        $this->chemin = $chemin;

        return $this;
    }

    /**
     * Get chemin
     *
     * @return string 
     */
    public function getChemin()
    {
        return $this->chemin;
    }

    /**
     * Set espaceDisqueInstalle
     *
     * @param string $espaceDisqueInstalle
     * @return Package
     */
    public function setEspaceDisqueInstalle($espaceDisqueInstalle)
    {
        $this->espaceDisqueInstalle = $espaceDisqueInstalle;

        return $this;
    }

    /**
     * Get espaceDisqueInstalle
     *
     * @return string 
     */
    public function getEspaceDisqueInstalle()
    {
        return $this->espaceDisqueInstalle;
    }

    /**
     * Set ligneCommandePublication
     *
     * @param string $ligneCommandePublication
     * @return Package
     */
    public function setLigneCommandePublication($ligneCommandePublication)
    {
        $this->ligneCommandePublication = $ligneCommandePublication;

        return $this;
    }

    /**
     * Get ligneCommandePublication
     *
     * @return string 
     */
    public function getLigneCommandePublication()
    {
        return $this->ligneCommandePublication;
    }

    /**
     * Set ligneCommandeTeledistribution
     *
     * @param string $ligneCommandeTeledistribution
     * @return Package
     */
    public function setLigneCommandeTeledistribution($ligneCommandeTeledistribution)
    {
        $this->ligneCommandeTeledistribution = $ligneCommandeTeledistribution;

        return $this;
    }

    /**
     * Get ligneCommandeTeledistribution
     *
     * @return string 
     */
    public function getLigneCommandeTeledistribution()
    {
        return $this->ligneCommandeTeledistribution;
    }

    /**
     * Set redemarrageOutilDeveloppement
     *
     * @param boolean $redemarrageOutilDeveloppement
     * @return Package
     */
    public function setRedemarrageOutilDeveloppement($redemarrageOutilDeveloppement)
    {
        $this->redemarrageOutilDeveloppement = $redemarrageOutilDeveloppement;

        return $this;
    }

    /**
     * Get redemarrageOutilDeveloppement
     *
     * @return boolean 
     */
    public function getRedemarrageOutilDeveloppement()
    {
        return $this->redemarrageOutilDeveloppement;
    }

    /**
     * Set redemarrageRequis
     *
     * @param boolean $redemarrageRequis
     * @return Package
     */
    public function setRedemarrageRequis($redemarrageRequis)
    {
        $this->redemarrageRequis = $redemarrageRequis;

        return $this;
    }

    /**
     * Get redemarrageRequis
     *
     * @return boolean 
     */
    public function getRedemarrageRequis()
    {
        return $this->redemarrageRequis;
    }

    /**
     * Set productCode
     *
     * @param string $productCode
     * @return Package
     */
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;

        return $this;
    }

    /**
     * Get productCode
     *
     * @return string 
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * Set activeSetup
     *
     * @param string $activeSetup
     * @return Package
     */
    public function setActiveSetup($activeSetup)
    {
        $this->activeSetup = $activeSetup;

        return $this;
    }

    /**
     * Get activeSetup
     *
     * @return string 
     */
    public function getActiveSetup()
    {
        return $this->activeSetup;
    }

    /**
     * Set tNSNAMES
     *
     * @param boolean $tNSNAMES
     * @return Package
     */
    public function setTNSNAMES($tNSNAMES)
    {
        $this->tNSNAMES = $tNSNAMES;

        return $this;
    }

    /**
     * Get tNSNAMES
     *
     * @return boolean 
     */
    public function getTNSNAMES()
    {
        return $this->tNSNAMES;
    }

    /**
     * Set nomEntreeTNSNAMES
     *
     * @param string $nomEntreeTNSNAMES
     * @return Package
     */
    public function setNomEntreeTNSNAMES($nomEntreeTNSNAMES)
    {
        $this->nomEntreeTNSNAMES = $nomEntreeTNSNAMES;

        return $this;
    }

    /**
     * Get nomEntreeTNSNAMES
     *
     * @return string 
     */
    public function getNomEntreeTNSNAMES()
    {
        return $this->nomEntreeTNSNAMES;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return Package
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set dossierTechnique
     *
     * @param \Baquaras\TestBundle\Entity\Package $dossierTechnique
     * @return Package
     */
    public function setDossierTechnique(\Baquaras\TestBundle\Entity\Fichier $dossierTechnique = null)
    {
        $this->dossierTechnique = $dossierTechnique;

        return $this;
    }

    /**
     * Get dossierTechnique
     *
     * @return \Baquaras\TestBundle\Entity\Fichier 
     */
    public function getDossierTechnique()
    {
        return $this->dossierTechnique;
    }

    /**
     * Set creationCustomActions
     *
     * @param boolean $creationCustomActions
     * @return Package
     */
    public function setCreationCustomActions($creationCustomActions)
    {
        $this->creationCustomActions = $creationCustomActions;

        return $this;
    }

    /**
     * Get creationCustomActions
     *
     * @return boolean 
     */
    public function getCreationCustomActions()
    {
        return $this->creationCustomActions;
    }

    /**
     * Set type
     *
     * @param \Baquaras\TestBundle\Entity\Item $type
     * @return Package
     */
    public function setType(\Baquaras\TestBundle\Entity\Item $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Baquaras\TestBundle\Entity\Item 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set versionTemplate
     *
     * @param \Baquaras\TestBundle\Entity\Item $versionTemplate
     * @return Package
     */
    public function setVersionTemplate(\Baquaras\TestBundle\Entity\Item $versionTemplate = null)
    {
        $this->versionTemplate = $versionTemplate;

        return $this;
    }

    /**
     * Get versionTemplate
     *
     * @return \Baquaras\TestBundle\Entity\Item 
     */
    public function getVersionTemplate()
    {
        return $this->versionTemplate;
    }

    /**
     * Set versionOutilPackaging
     *
     * @param \Baquaras\TestBundle\Entity\Item $versionOutilPackaging
     * @return Package
     */
    public function setVersionOutilPackaging(\Baquaras\TestBundle\Entity\Item $versionOutilPackaging = null)
    {
        $this->versionOutilPackaging = $versionOutilPackaging;

        return $this;
    }

    /**
     * Get versionOutilPackaging
     *
     * @return \Baquaras\TestBundle\Entity\Item 
     */
    public function getVersionOutilPackaging()
    {
        return $this->versionOutilPackaging;
    }

    /**
     * Set paliersTechniques
     *
     * @param \Baquaras\TestBundle\Entity\Item $paliersTechniques
     * @return Package
     */
    public function setPaliersTechniques(\Baquaras\TestBundle\Entity\Item $paliersTechniques = null)
    {
        $this->paliersTechniques = $paliersTechniques;

        return $this;
    }

    /**
     * Get paliersTechniques
     *
     * @return \Baquaras\TestBundle\Entity\Item 
     */
    public function getPaliersTechniques()
    {
        return $this->paliersTechniques;
    }

    /**
     * Set modeOperatoire
     *
     * @param \Baquaras\TestBundle\Entity\ModeOperatoire $modeOperatoire
     * @return Package
     */
    public function setModeOperatoire(\Baquaras\TestBundle\Entity\ModeOperatoire $modeOperatoire = null)
    {
        $this->modeOperatoire = $modeOperatoire;

        return $this;
    }

    /**
     * Get modeOperatoire
     *
     * @return \Baquaras\TestBundle\Entity\ModeOperatoire 
     */
    public function getModeOperatoire()
    {
        return $this->modeOperatoire;
    }

    /**
     * Set statutQualif
     *
     * @param \Baquaras\TestBundle\Entity\Statut $statutQualif
     * @return Package
     */
    public function setStatutQualif(\Baquaras\TestBundle\Entity\Statut $statutQualif = null)
    {
        $this->statutQualif = $statutQualif;

        return $this;
    }

    /**
     * Get statutQualif
     *
     * @return \Baquaras\TestBundle\Entity\Statut 
     */
    public function getStatutQualif()
    {
        return $this->statutQualif;
    }

    /**
     * Set application
     *
     * @param \Baquaras\TestBundle\Entity\Application $application
     * @return Package
     */
    public function setApplication(\Baquaras\TestBundle\Entity\Application $application = null)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * @return \Baquaras\TestBundle\Entity\Application 
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Add evolutionsStatut
     *
     * @param \Baquaras\TestBundle\Entity\EvolutionStatut $evolutionsStatut
     * @return Package
     */
    public function addEvolutionsStatut(\Baquaras\TestBundle\Entity\EvolutionStatut $evolutionsStatut)
    {
        $this->evolutionsStatut[] = $evolutionsStatut;

        return $this;
    }

    /**
     * Remove evolutionsStatut
     *
     * @param \Baquaras\TestBundle\Entity\EvolutionStatut $evolutionsStatut
     */
    public function removeEvolutionsStatut(\Baquaras\TestBundle\Entity\EvolutionStatut $evolutionsStatut)
    {
        $this->evolutionsStatut->removeElement($evolutionsStatut);
    }

    /**
     * Get evolutionsStatut
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvolutionsStatut()
    {
        return $this->evolutionsStatut;
    }

    /**
     * Set qualification
     *
     * @param \Baquaras\TestBundle\Entity\Qualification $qualification
     * @return Package
     */
    public function setQualification(\Baquaras\TestBundle\Entity\Qualification $qualification = null)
    {
        $this->qualification = $qualification;

        return $this;
    }

    /**
     * Get qualification
     *
     * @return \Baquaras\TestBundle\Entity\Qualification 
     */
    public function getQualification()
    {
        return $this->qualification;
    }

    /**
     * Add scripts
     *
     * @param \Baquaras\TestBundle\Entity\Script $scripts
     * @return Package
     */
    public function addScript(\Baquaras\TestBundle\Entity\Script $scripts)
    {
        $this->scripts[] = $scripts;

        return $this;
    }

    /**
     * Remove scripts
     *
     * @param \Baquaras\TestBundle\Entity\Script $scripts
     */
    public function removeScript(\Baquaras\TestBundle\Entity\Script $scripts)
    {
        $this->scripts->removeElement($scripts);
    }

    /**
     * Get scripts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getScripts()
    {
        return $this->scripts;
    }

    /**
     * Set installation
     *
     * @param \Baquaras\TestBundle\Entity\InstallationPackage $installation
     * @return Package
     */
    public function setInstallation(\Baquaras\TestBundle\Entity\InstallationPackage $installation = null)
    {
        $this->installation = $installation;

        return $this;
    }

    /**
     * Get installation
     *
     * @return \Baquaras\TestBundle\Entity\InstallationPackage 
     */
    public function getInstallation()
    {
        return $this->installation;
    }

    /**
     * Add modifsApplication
     *
     * @param \Baquaras\TestBundle\Entity\ModificationApplication $modifsApplication
     * @return Package
     */
    public function addModifsApplication(\Baquaras\TestBundle\Entity\ModificationApplication $modifsApplication)
    {
        $this->modifsApplication[] = $modifsApplication;

        return $this;
    }

    /**
     * Remove modifsApplication
     *
     * @param \Baquaras\TestBundle\Entity\ModificationApplication $modifsApplication
     */
    public function removeModifsApplication(\Baquaras\TestBundle\Entity\ModificationApplication $modifsApplication)
    {
        $this->modifsApplication->removeElement($modifsApplication);
    }

    /**
     * Get modifsApplication
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getModifsApplication()
    {
        return $this->modifsApplication;
    }
}
