<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Application
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\ApplicationRepository")
 */
class Application
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
	 * @Assert\NotBlank (message = "Veuillez renseigner le nom de l'application")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Version", type="string", length=255, nullable=true)
	 * @Assert\NotBlank (message = "Veuillez indiquer la version de l'application")
     */
    private $version;

    /**
     * @var string
     *
     * @ORM\Column(name="Correctif_Qualif", type="string", length=255, nullable=true)
     */
    private $correctifQualif;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=2000, nullable=true)
	 * @Assert\NotBlank (message = "Veuillez donner une description à l'application")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Editeur", type="string", length=255, nullable=true)
     */
    private $editeur;

 	/**
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="type", referencedColumnName="id", nullable=true)
	 * @Assert\NotBlank (message = "Veuillez sélectionner le type de l'application")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="Code_Convergence", type="string", length=255, nullable=true)
     */
    private $codeConvergence;

    /**
     * @var string
     *
     * @ORM\Column(name="Code_ECAR", type="string", length=255, nullable=true)
     */
    private $codeECAR;
	
	/**
     * @var boolean
     *
     * @ORM\Column(name="Appli_Referencee_SIERA", type="boolean", nullable=true)
     */
    private $appliReferenceeSIERA;

    /**
     * @var string
     *
     * @ORM\Column(name="Code_SIERA", type="string", length=255, nullable=true)
     */
    private $codeSIERA;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_Application_SIERA", type="string", length=255, nullable=true)
     */
    private $nomApplicationSIERA;
    
    /**
     * @var string
     *
     * @ORM\Column(name="Nom_Client_SIERA", type="string", length=255, nullable=true)
     */
    private $nomClientSIERA;
    
    /**
     * @var string
     *
     * @ORM\Column(name="Id_Client_SIERA", type="string", length=255, nullable=true)
     */
    private $idClientSIERA;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="dept_moa", type="string", length=255, nullable=true)
     */
    private $deptMoa;
    
    /**
     * @var string
     *
     * @ORM\Column(name="code_moa", type="string", length=255, nullable=true)
     */
    private $codeMoa;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="dept_users", type="string", length=255, nullable=true)
     */
    private $deptUsers;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Appli_Sous_Gouvernance", type="boolean", nullable=true)
     */
    private $appliSousGouvernance;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Dans_Catalogue_SIT", type="boolean", nullable=true)
     */
    private $dansCatalogueSIT;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Inscrite_Revue_Performance", type="boolean", nullable=true)
     */
    private $inscriteRevuePerformance;
	
 	/**
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="OS_Cible_id", referencedColumnName="id", nullable=true)
     */
    private $oscible;
	
	/**
     * @var string
     *
     * @ORM\Column(name="groupesInstall", type="string", length=1000, nullable=true)
     */
    private $groupesInstall;
	
	/**
     * @ORM\OneToMany(targetEntity="PopulationCible", mappedBy="application")
     **/
    private $populationCible;
	
	/**
     * @ORM\OneToOne(targetEntity="InstallationApplication", cascade={"persist"})
     * @ORM\JoinColumn(name="installation_id", referencedColumnName="id", nullable=true)
     **/
    private $installation;
	
    /**
     * @ORM\OneToOne(targetEntity="ArchitectureApplication", cascade={"persist"})
     * @ORM\JoinColumn(name="architecture_id", referencedColumnName="id", nullable=true)
     **/
    private $architecture;
	
	/**
     * @ORM\OneToOne(targetEntity="GestionApplication", cascade={"persist"})
     * @ORM\JoinColumn(name="gestion_id", referencedColumnName="id", nullable=true)
     **/
    private $gestion;
	
	/**
     * @ORM\OneToOne(targetEntity="DeveloppementApplication", cascade={"persist"})
     * @ORM\JoinColumn(name="developpement_id", referencedColumnName="id", nullable=true)
     **/
    private $developpement;
	
	/**
     * @ORM\OneToOne(targetEntity="CatalogueSIT", cascade={"persist"})
     * @ORM\JoinColumn(name="reference_catalogue", referencedColumnName="id", nullable=true)
     **/
    private $refCatalogue;
	
	/**
     * @ORM\OneToMany(targetEntity="Package", mappedBy="application")
     **/
    private $packages;
	
	/**
     * @ORM\OneToMany(targetEntity="PreRequis", mappedBy="application")
	 **/
    private $preRequis;
	
	/**
     * @ORM\OneToMany(targetEntity="NonRequis", mappedBy="application")
     **/
    private $nonRequis;
	
	/**
     * @ORM\OneToMany(targetEntity="AutrePreRequis", mappedBy="application")
     **/
    private $autresPreRequis;
	
	/**
     * @ORM\OneToMany(targetEntity="MiseAJour", mappedBy="application")
     **/
    private $misesajour;
	
     /**
     * @ORM\ManyToMany(targetEntity="Utilisateur", mappedBy="usersDroit")
     **/
    private $droitsApplication ;
    
    /**
     * @ORM\ManyToMany(targetEntity="Utilisateur", mappedBy="applications")
     */
    private $moes;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Utilisateur", mappedBy="application")
     */
    private $utilisateur;
    /**
     * @ORM\OneToMany(targetEntity="GroupeApplication", mappedBy="application", cascade={"persist"})
     *
     **/
    private $groupeApplications;
	
    /**
     * @var integer
     *
     * @ORM\Column(name="id_application_siera", type="integer", nullable=true)
     */
    private $id_application_siera;
    
    /**
     * @var string
     *
     * @ORM\Column(name="lien_baquaras", type="string", length=255, nullable=true)
     */
    private $lien_baquaras;
	/**
     * Constructor
     */
    public function __construct()
    {
        $this->appliReferenceeSIERA = null;
	$this->appliSousGouvernance = null;
	$this->dansCatalogueSIT = null;
	$this->inscriteRevuePerformance = null;
        $this->populationCible = new \Doctrine\Common\Collections\ArrayCollection();
        $this->packages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->preRequis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nonRequis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->autresPreRequis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->misesajour = new \Doctrine\Common\Collections\ArrayCollection();
        $this->droitsApplication = new \Doctrine\Common\Collections\ArrayCollection();
        $this->groupeApplications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->utilisateur = new \Doctrine\Common\Collections\ArrayCollection();
        $this->moes = new \Doctrine\Common\Collections\ArrayCollection();
        
    }
	
	public function __toString()
	{
		return $this->getNom()/*.' '.$this->getVersion()*/;
	}
	
	public function NomAndVersion()
	{
		return $this->getNom().' '.$this->getVersion();
	}

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
     * Set nom
     *
     * @param string $nom
     * @return Application
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
     * Set version
     *
     * @param string $version
     * @return Application
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set correctifQualif
     *
     * @param string $correctifQualif
     * @return Application
     */
    public function setCorrectifQualif($correctifQualif)
    {
        $this->correctifQualif = $correctifQualif;

        return $this;
    }

    /**
     * Get correctifQualif
     *
     * @return string 
     */
    public function getCorrectifQualif()
    {
        return $this->correctifQualif;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Application
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set editeur
     *
     * @param string $editeur
     * @return Application
     */
    public function setEditeur($editeur)
    {
        $this->editeur = $editeur;

        return $this;
    }

    /**
     * Get editeur
     *
     * @return string 
     */
    public function getEditeur()
    {
        return $this->editeur;
    }

    /**
     * Set codeConvergence
     *
     * @param string $codeConvergence
     * @return Application
     */
    public function setCodeConvergence($codeConvergence)
    {
        $this->codeConvergence = $codeConvergence;

        return $this;
    }

    /**
     * Get codeConvergence
     *
     * @return string 
     */
    public function getCodeConvergence()
    {
        return $this->codeConvergence;
    }

    /**
     * Set codeECAR
     *
     * @param string $codeECAR
     * @return Application
     */
    public function setCodeECAR($codeECAR)
    {
        $this->codeECAR = $codeECAR;

        return $this;
    }

    /**
     * Get codeECAR
     *
     * @return string 
     */
    public function getCodeECAR()
    {
        return $this->codeECAR;
    }

    /**
     * Set appliReferenceeSIERA
     *
     * @param boolean $appliReferenceeSIERA
     * @return Application
     */
    public function setAppliReferenceeSIERA($appliReferenceeSIERA)
    {
        $this->appliReferenceeSIERA = $appliReferenceeSIERA;

        return $this;
    }

    /**
     * Get appliReferenceeSIERA
     *
     * @return boolean 
     */
    public function getAppliReferenceeSIERA()
    {
        return $this->appliReferenceeSIERA;
    }

    /**
     * Set codeSIERA
     *
     * @param string $codeSIERA
     * @return Application
     */
    public function setCodeSIERA($codeSIERA)
    {
        $this->codeSIERA = $codeSIERA;

        return $this;
    }

    /**
     * Get codeSIERA
     *
     * @return string 
     */
    public function getCodeSIERA()
    {
        return $this->codeSIERA;
    }

    /**
     * Set nomApplicationSIERA
     *
     * @param string $nomApplicationSIERA
     * @return Application
     */
    public function setNomApplicationSIERA($nomApplicationSIERA)
    {
        $this->nomApplicationSIERA = $nomApplicationSIERA;

        return $this;
    }

    /**
     * Get nomApplicationSIERA
     *
     * @return string 
     */
    public function getNomApplicationSIERA()
    {
        return $this->nomApplicationSIERA;
    }

    /**
     * Set appliSousGouvernance
     *
     * @param boolean $appliSousGouvernance
     * @return Application
     */
    public function setAppliSousGouvernance($appliSousGouvernance)
    {
        $this->appliSousGouvernance = $appliSousGouvernance;

        return $this;
    }

    /**
     * Get appliSousGouvernance
     *
     * @return boolean 
     */
    public function getAppliSousGouvernance()
    {
        return $this->appliSousGouvernance;
    }

    /**
     * Set dansCatalogueSIT
     *
     * @param boolean $dansCatalogueSIT
     * @return Application
     */
    public function setDansCatalogueSIT($dansCatalogueSIT)
    {
        $this->dansCatalogueSIT = $dansCatalogueSIT;

        return $this;
    }

    /**
     * Get dansCatalogueSIT
     *
     * @return boolean 
     */
    public function getDansCatalogueSIT()
    {
        return $this->dansCatalogueSIT;
    }

    /**
     * Set inscriteRevuePerformance
     *
     * @param boolean $inscriteRevuePerformance
     * @return Application
     */
    public function setInscriteRevuePerformance($inscriteRevuePerformance)
    {
        $this->inscriteRevuePerformance = $inscriteRevuePerformance;

        return $this;
    }

    /**
     * Get inscriteRevuePerformance
     *
     * @return boolean 
     */
    public function getInscriteRevuePerformance()
    {
        return $this->inscriteRevuePerformance;
    }

    /**
     * Set type
     *
     * @param \Baquaras\TestBundle\Entity\Item $type
     * @return Application
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
     * Set oscible
     *
     * @param \Baquaras\TestBundle\Entity\Item $oscible
     * @return Application
     */
    public function setOscible(\Baquaras\TestBundle\Entity\Item $oscible = null)
    {
        $this->oscible = $oscible;

        return $this;
    }

    /**
     * Get oscible
     *
     * @return \Baquaras\TestBundle\Entity\Item 
     */
    public function getOscible()
    {
        return $this->oscible;
    }

    /**
     * Add populationCible
     *
     * @param \Baquaras\TestBundle\Entity\PopulationCible $populationCible
     * @return Application
     */
    public function addPopulationCible(\Baquaras\TestBundle\Entity\PopulationCible $populationCible)
    {
        $this->populationCible[] = $populationCible;

        return $this;
    }

    /**
     * Remove populationCible
     *
     * @param \Baquaras\TestBundle\Entity\PopulationCible $populationCible
     */
    public function removePopulationCible(\Baquaras\TestBundle\Entity\PopulationCible $populationCible)
    {
        $this->populationCible->removeElement($populationCible);
    }

    /**
     * Get populationCible
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPopulationCible()
    {
        return $this->populationCible;
    }

    /**
     * Set installation
     *
     * @param \Baquaras\TestBundle\Entity\InstallationApplication $installation
     * @return Application
     */
    public function setInstallation(\Baquaras\TestBundle\Entity\InstallationApplication $installation = null)
    {
        $this->installation = $installation;

        return $this;
    }

    /**
     * Get installation
     *
     * @return \Baquaras\TestBundle\Entity\InstallationApplication 
     */
    public function getInstallation()
    {
        return $this->installation;
    }

    /**
     * Set architecture
     *
     * @param \Baquaras\TestBundle\Entity\ArchitectureApplication $architecture
     * @return Application
     */
    public function setArchitecture(\Baquaras\TestBundle\Entity\ArchitectureApplication $architecture = null)
    {
        $this->architecture = $architecture;

        return $this;
    }

    /**
     * Get architecture
     *
     * @return \Baquaras\TestBundle\Entity\ArchitectureApplication 
     */
    public function getArchitecture()
    {
        return $this->architecture;
    }

    /**
     * Set gestion
     *
     * @param \Baquaras\TestBundle\Entity\GestionApplication $gestion
     * @return Application
     */
    public function setGestion(\Baquaras\TestBundle\Entity\GestionApplication $gestion = null)
    {
        $this->gestion = $gestion;

        return $this;
    }

    /**
     * Get gestion
     *
     * @return \Baquaras\TestBundle\Entity\GestionApplication 
     */
    public function getGestion()
    {
        return $this->gestion;
    }

    /**
     * Set developpement
     *
     * @param \Baquaras\TestBundle\Entity\DeveloppementApplication $developpement
     * @return Application
     */
    public function setDeveloppement(\Baquaras\TestBundle\Entity\DeveloppementApplication $developpement = null)
    {
        $this->developpement = $developpement;

        return $this;
    }

    /**
     * Get developpement
     *
     * @return \Baquaras\TestBundle\Entity\DeveloppementApplication 
     */
    public function getDeveloppement()
    {
        return $this->developpement;
    }

    /**
     * Set refCatalogue
     *
     * @param \Baquaras\TestBundle\Entity\CatalogueSIT $refCatalogue
     * @return Application
     */
    public function setRefCatalogue(\Baquaras\TestBundle\Entity\CatalogueSIT $refCatalogue = null)
    {
        $this->refCatalogue = $refCatalogue;

        return $this;
    }

    /**
     * Get refCatalogue
     *
     * @return \Baquaras\TestBundle\Entity\CatalogueSIT 
     */
    public function getRefCatalogue()
    {
        return $this->refCatalogue;
    }

    /**
     * Add packages
     *
     * @param \Baquaras\TestBundle\Entity\Package $packages
     * @return Application
     */
    public function addPackage(\Baquaras\TestBundle\Entity\Package $packages)
    {
        $this->packages[] = $packages;

        return $this;
    }

    /**
     * Remove packages
     *
     * @param \Baquaras\TestBundle\Entity\Package $packages
     */
    public function removePackage(\Baquaras\TestBundle\Entity\Package $packages)
    {
        $this->packages->removeElement($packages);
    }

    /**
     * Get packages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * Add preRequis
     *
     * @param \Baquaras\TestBundle\Entity\PreRequis $preRequis
     * @return Application
     */
    public function addPreRequi(\Baquaras\TestBundle\Entity\PreRequis $preRequis)
    {
        $this->preRequis[] = $preRequis;

        return $this;
    }

    /**
     * Remove preRequis
     *
     * @param \Baquaras\TestBundle\Entity\PreRequis $preRequis
     */
    public function removePreRequi(\Baquaras\TestBundle\Entity\PreRequis $preRequis)
    {
        $this->preRequis->removeElement($preRequis);
    }

    /**
     * Get preRequis
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPreRequis()
    {
        return $this->preRequis;
    }

    /**
     * Add nonRequis
     *
     * @param \Baquaras\TestBundle\Entity\NonRequis $nonRequis
     * @return Application
     */
    public function addNonRequi(\Baquaras\TestBundle\Entity\NonRequis $nonRequis)
    {
        $this->nonRequis[] = $nonRequis;

        return $this;
    }

    /**
     * Remove nonRequis
     *
     * @param \Baquaras\TestBundle\Entity\NonRequis $nonRequis
     */
    public function removeNonRequi(\Baquaras\TestBundle\Entity\NonRequis $nonRequis)
    {
        $this->nonRequis->removeElement($nonRequis);
    }

    /**
     * Get nonRequis
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNonRequis()
    {
        return $this->nonRequis;
    }

    /**
     * Add misesajour
     *
     * @param \Baquaras\TestBundle\Entity\MiseAJour $misesajour
     * @return Application
     */
    public function addMisesajour(\Baquaras\TestBundle\Entity\MiseAJour $misesajour)
    {
        $this->misesajour[] = $misesajour;

        return $this;
    }

    /**
     * Remove misesajour
     *
     * @param \Baquaras\TestBundle\Entity\MiseAJour $misesajour
     */
    public function removeMisesajour(\Baquaras\TestBundle\Entity\MiseAJour $misesajour)
    {
        $this->misesajour->removeElement($misesajour);
    }

    /**
     * Get misesajour
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMisesajour()
    {
        return $this->misesajour;
    }

    
    /**
     * Add autresPreRequis
     *
     * @param \Baquaras\TestBundle\Entity\AutrePreRequis $autresPreRequis
     * @return Application
     */
    public function addAutresPreRequis(\Baquaras\TestBundle\Entity\AutrePreRequis $autresPreRequis)
    {
        $this->autresPreRequis[] = $autresPreRequis;

        return $this;
    }

    /**
     * Remove autresPreRequis
     *
     * @param \Baquaras\TestBundle\Entity\AutrePreRequis $autresPreRequis
     */
    public function removeAutresPreRequis(\Baquaras\TestBundle\Entity\AutrePreRequis $autresPreRequis)
    {
        $this->autresPreRequis->removeElement($autresPreRequis);
    }

    /**
     * Get autresPreRequis
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAutresPreRequis()
    {
        return $this->autresPreRequis;
    }

    /**
     * Add autresPreRequis
     *
     * @param \Baquaras\TestBundle\Entity\AutrePreRequis $autresPreRequis
     * @return Application
     */
    public function addAutresPreRequi(\Baquaras\TestBundle\Entity\AutrePreRequis $autresPreRequis)
    {
        $this->autresPreRequis[] = $autresPreRequis;

        return $this;
    }

    /**
     * Remove autresPreRequis
     *
     * @param \Baquaras\TestBundle\Entity\AutrePreRequis $autresPreRequis
     */
    public function removeAutresPreRequi(\Baquaras\TestBundle\Entity\AutrePreRequis $autresPreRequis)
    {
        $this->autresPreRequis->removeElement($autresPreRequis);
    }
	
	


    /**
     * Set groupesInstall
     *
     * @param string $groupesInstall
     * @return Application
     */
    public function setGroupesInstall($groupesInstall)
    {
        $this->groupesInstall = $groupesInstall;

        return $this;
    }

    /**
     * Get groupesInstall
     *
     * @return string 
     */
    public function getGroupesInstall()
    {
        return $this->groupesInstall;
    }

    /**
     * Add groupeApplications
     *
     * @param \Baquaras\TestBundle\Entity\GroupeApplication $groupeApplications
     * @return Application
     */
    public function addGroupeApplication(\Baquaras\TestBundle\Entity\GroupeApplication $groupeApplications)
    {
        $this->groupeApplications[] = $groupeApplications;

        return $this;
    }

    /**
     * Remove groupeApplications
     *
     * @param \Baquaras\TestBundle\Entity\GroupeApplication $groupeApplications
     */
    public function removeGroupeApplication(\Baquaras\TestBundle\Entity\GroupeApplication $groupeApplications)
    {
        $this->groupeApplications->removeElement($groupeApplications);
    }

    /**
     * Get groupeApplications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupeApplications()
    {
        return $this->groupeApplications;
    }
    
    /**
     * Add utilisateur
     *
     * @param \Baquaras\TestBundle\Entity\Utilisateur $utilisateur
     * @return Application
     */
    public function addUtilisateur(\Baquaras\TestBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur[] = $utilisateur;
        //$this->utilisateur->setApplication($this);

        return $this;
    }

    /**
     * Remove utilisateur
     *
     * @param \Baquaras\TestBundle\Entity\Utilisateur $utilisateur
     */
    public function removeUtilisateur(\Baquaras\TestBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur->removeElement($utilisateur);
    }

    /**
     * Get utilisateur
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
   

    /**
     * Set deptMoa
     *
     * @param string $deptMoa
     * @return Application
     */
    public function setDeptMoa($deptMoa)
    {
        $this->deptMoa = $deptMoa;

        return $this;
    }

    /**
     * Get deptMoa
     *
     * @return string 
     */
    public function getDeptMoa()
    {
        return $this->deptMoa;
    }

    /**
     * Set deptUsers
     *
     * @param string $deptUsers
     * @return Application
     */
    public function setDeptUsers($deptUsers)
    {
        $this->deptUsers = $deptUsers;

        return $this;
    }

    /**
     * Get deptUsers
     *
     * @return string 
     */
    public function getDeptUsers()
    {
        return $this->deptUsers;
    }

    /**
     * Set nomClientSIERA
     *
     * @param string $nomClientSIERA
     * @return Application
     */
    public function setNomClientSIERA($nomClientSIERA)
    {
        $this->nomClientSIERA = $nomClientSIERA;

        return $this;
    }

    /**
     * Get nomClientSIERA
     *
     * @return string 
     */
    public function getNomClientSIERA()
    {
        return $this->nomClientSIERA;
    }

    /**
     * Set idClientSIERA
     *
     * @param string $idClientSIERA
     * @return Application
     */
    public function setIdClientSIERA($idClientSIERA)
    {
        $this->idClientSIERA = $idClientSIERA;

        return $this;
    }

    /**
     * Get idClientSIERA
     *
     * @return string 
     */
    public function getIdClientSIERA()
    {
        return $this->idClientSIERA;
    }

    /**
     * Set codeMoa
     *
     * @param string $codeMoa
     * @return Application
     */
    public function setCodeMoa($codeMoa)
    {
        $this->codeMoa = $codeMoa;

        return $this;
    }

    /**
     * Get codeMoa
     *
     * @return string 
     */
    public function getCodeMoa()
    {
        return $this->codeMoa;
    }

    /**
     * Add droitsApplication
     *
     * @param \Baquaras\TestBundle\Entity\Utilisateur $droitsApplication
     * @return Application
     */
    public function addDroitsApplication(\Baquaras\TestBundle\Entity\Utilisateur $droitsApplication)
    {
        $this->droitsApplication[] = $droitsApplication;

        return $this;
    }

    /**
     * Remove droitsApplication
     *
     * @param \Baquaras\TestBundle\Entity\Utilisateur $droitsApplication
     */
    public function removeDroitsApplication(\Baquaras\TestBundle\Entity\Utilisateur $droitsApplication)
    {
        $this->droitsApplication->removeElement($droitsApplication);
    }

    /**
     * Get droitsApplication
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDroitsApplication()
    {
        return $this->droitsApplication;
    }

    /**
     * Add moes
     *
     * @param \Baquaras\TestBundle\Entity\Utilisateur $moes
     * @return Application
     */
    public function addMo(\Baquaras\TestBundle\Entity\Utilisateur $moes)
    {
        $this->moes[] = $moes;

        return $this;
    }

    /**
     * Remove moes
     *
     * @param \Baquaras\TestBundle\Entity\Utilisateur $moes
     */
    public function removeMo(\Baquaras\TestBundle\Entity\Utilisateur $moes)
    {
        $this->moes->removeElement($moes);
    }

    /**
     * Get moes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMoes()
    {
        return $this->moes;
    }
    
     /**
     * Set id_application_siera
     *
     * @param integer $id_application_siera
     * @return Application
     */
    public function setIdApplicationSiera($id_application_siera)
    {
        $this->id_application_siera = $id_application_siera;

        return $this;
    }

    /**
     * Get id_application_siera
     *
     * @return integer 
     */
    public function getIdApplicationSiera()
    {
        return $this->id_application_siera;
    }
    
    /**
     * Set lien_baquaras
     *
     * @param string $lien_baquaras
     * @return Application
     */
    public function setLienBaquaras($lien_baquaras)
    {
        $this->lien_baquaras = $lien_baquaras;

        return $this;
    }

    /**
     * Get lien_baquaras
     *
     * @return string 
     */
    public function getLienBaquaras()
    {
        return $this->lien_baquaras;
    }
}
