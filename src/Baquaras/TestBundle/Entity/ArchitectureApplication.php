<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArchitectureApplication
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\ArchitectureApplicationRepository")
 */
class ArchitectureApplication
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
     * @var boolean
     *
     * @ORM\Column(name="Appli_web", type="boolean", nullable=true)
     */
    private $appliWeb;

    /**
     * @var string
     *
     * @ORM\Column(name="URL_Extranet", type="string", length=255, nullable=true)
     */
    private $urlExtranet;
	
	/**
     * @var string
     *
     * @ORM\Column(name="URL_Intranet", type="string", length=255, nullable=true)
     */
    private $urlIntranet;

    /**
     * @var string
     *
     * @ORM\Column(name="Appli_Intra_Ou_Internet", type="string", length=255, nullable=true)
     */
    private $appliIntraOuInternet;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Utilisation_ActiveX", type="boolean", nullable=true)
     */
    private $utilisationActiveX;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Utilisation_Certificats", type="boolean", nullable=true)
     */
    private $utilisationCertificats;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Utilisation_JRE", type="boolean", nullable=true)
     */
    private $utilisationJRE;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Appli_Client_Serveur", type="boolean", nullable=true)
     */
    private $appliClientServeur;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Appli_Infocentre", type="boolean", nullable=true)
     */
    private $appliInfocentre;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Base_De_Donnees", type="boolean", nullable=true)
     */
    private $baseDeDonnees;

    /**
     * @var string
     *
     * @ORM\Column(name="Commentaire", type="string", length=2000, nullable=true)
     */
    private $commentaire;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Utilisation_Office", type="boolean", nullable=true)
     */
    private $utilisationOffice;

 	/**
     * @ORM\ManyToMany(targetEntity="Item", inversedBy="archis")
     * @ORM\JoinColumn(name="Liaison_Office", referencedColumnName="id", nullable=true)
     */
    private $liaisonsOffice;

	/**
     * @var boolean
     *
     * @ORM\Column(name="Liaison_Access", type="boolean", nullable=true)
     */
    private $liaisonAccess;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Stocke_Donnees_User", type="boolean", nullable=true)
     */
    private $stockeDonneesUser;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Utilisation_Materiel_Peripherique", type="boolean", nullable=true)
     */
    private $utilisationMaterielPeripherique;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Utilisation_SSO", type="boolean", nullable=true)
     */
    private $utilisationSSO;
	
    /**
     * @ORM\ManyToMany(targetEntity="BriqueArchitecture", inversedBy="architecture")
     * @ORM\JoinColumn(nullable=true)
     */
    private $briques;
	
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
	
	public function __toString() {
		$liaisons = $this->getLiaisonsOffice();
		foreach ($liaisons->toArray() as $value) {
			return $liaisons($value)->getLibelle();
		}
	}
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->liaisonsOffice = new \Doctrine\Common\Collections\ArrayCollection();
        $this->briques = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set appliWeb
     *
     * @param boolean $appliWeb
     * @return ArchitectureApplication
     */
    public function setAppliWeb($appliWeb)
    {
        $this->appliWeb = $appliWeb;

        return $this;
    }

    /**
     * Get appliWeb
     *
     * @return boolean 
     */
    public function getAppliWeb()
    {
        return $this->appliWeb;
    }

    /**
     * Set appliIntraOuInternet
     *
     * @param string $appliIntraOuInternet
     * @return ArchitectureApplication
     */
    public function setAppliIntraOuInternet($appliIntraOuInternet)
    {
        $this->appliIntraOuInternet = $appliIntraOuInternet;

        return $this;
    }

    /**
     * Get appliIntraOuInternet
     *
     * @return string 
     */
    public function getAppliIntraOuInternet()
    {
        return $this->appliIntraOuInternet;
    }

    /**
     * Set utilisationActiveX
     *
     * @param boolean $utilisationActiveX
     * @return ArchitectureApplication
     */
    public function setUtilisationActiveX($utilisationActiveX)
    {
        $this->utilisationActiveX = $utilisationActiveX;

        return $this;
    }

    /**
     * Get utilisationActiveX
     *
     * @return boolean 
     */
    public function getUtilisationActiveX()
    {
        return $this->utilisationActiveX;
    }

    /**
     * Set utilisationCertificats
     *
     * @param boolean $utilisationCertificats
     * @return ArchitectureApplication
     */
    public function setUtilisationCertificats($utilisationCertificats)
    {
        $this->utilisationCertificats = $utilisationCertificats;

        return $this;
    }

    /**
     * Get utilisationCertificats
     *
     * @return boolean 
     */
    public function getUtilisationCertificats()
    {
        return $this->utilisationCertificats;
    }

    /**
     * Set utilisationJRE
     *
     * @param boolean $utilisationJRE
     * @return ArchitectureApplication
     */
    public function setUtilisationJRE($utilisationJRE)
    {
        $this->utilisationJRE = $utilisationJRE;

        return $this;
    }

    /**
     * Get utilisationJRE
     *
     * @return boolean 
     */
    public function getUtilisationJRE()
    {
        return $this->utilisationJRE;
    }

    /**
     * Set appliClientServeur
     *
     * @param boolean $appliClientServeur
     * @return ArchitectureApplication
     */
    public function setAppliClientServeur($appliClientServeur)
    {
        $this->appliClientServeur = $appliClientServeur;

        return $this;
    }

    /**
     * Get appliClientServeur
     *
     * @return boolean 
     */
    public function getAppliClientServeur()
    {
        return $this->appliClientServeur;
    }

    /**
     * Set appliInfocentre
     *
     * @param boolean $appliInfocentre
     * @return ArchitectureApplication
     */
    public function setAppliInfocentre($appliInfocentre)
    {
        $this->appliInfocentre = $appliInfocentre;

        return $this;
    }

    /**
     * Get appliInfocentre
     *
     * @return boolean 
     */
    public function getAppliInfocentre()
    {
        return $this->appliInfocentre;
    }

    /**
     * Set baseDeDonnees
     *
     * @param boolean $baseDeDonnees
     * @return ArchitectureApplication
     */
    public function setBaseDeDonnees($baseDeDonnees)
    {
        $this->baseDeDonnees = $baseDeDonnees;

        return $this;
    }

    /**
     * Get baseDeDonnees
     *
     * @return boolean 
     */
    public function getBaseDeDonnees()
    {
        return $this->baseDeDonnees;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return ArchitectureApplication
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
     * Set utilisationOffice
     *
     * @param boolean $utilisationOffice
     * @return ArchitectureApplication
     */
    public function setUtilisationOffice($utilisationOffice)
    {
        $this->utilisationOffice = $utilisationOffice;

        return $this;
    }

    /**
     * Get utilisationOffice
     *
     * @return boolean 
     */
    public function getUtilisationOffice()
    {
        return $this->utilisationOffice;
    }

    /**
     * Set liaisonAccess
     *
     * @param boolean $liaisonAccess
     * @return ArchitectureApplication
     */
    public function setLiaisonAccess($liaisonAccess)
    {
        $this->liaisonAccess = $liaisonAccess;

        return $this;
    }

    /**
     * Get liaisonAccess
     *
     * @return boolean 
     */
    public function getLiaisonAccess()
    {
        return $this->liaisonAccess;
    }

    /**
     * Set stockeDonneesUser
     *
     * @param boolean $stockeDonneesUser
     * @return ArchitectureApplication
     */
    public function setStockeDonneesUser($stockeDonneesUser)
    {
        $this->stockeDonneesUser = $stockeDonneesUser;

        return $this;
    }

    /**
     * Get stockeDonneesUser
     *
     * @return boolean 
     */
    public function getStockeDonneesUser()
    {
        return $this->stockeDonneesUser;
    }

    /**
     * Set utilisationMaterielPeripherique
     *
     * @param boolean $utilisationMaterielPeripherique
     * @return ArchitectureApplication
     */
    public function setUtilisationMaterielPeripherique($utilisationMaterielPeripherique)
    {
        $this->utilisationMaterielPeripherique = $utilisationMaterielPeripherique;

        return $this;
    }

    /**
     * Get utilisationMaterielPeripherique
     *
     * @return boolean 
     */
    public function getUtilisationMaterielPeripherique()
    {
        return $this->utilisationMaterielPeripherique;
    }

    /**
     * Set utilisationSSO
     *
     * @param boolean $utilisationSSO
     * @return ArchitectureApplication
     */
    public function setUtilisationSSO($utilisationSSO)
    {
        $this->utilisationSSO = $utilisationSSO;

        return $this;
    }

    /**
     * Get utilisationSSO
     *
     * @return boolean 
     */
    public function getUtilisationSSO()
    {
        return $this->utilisationSSO;
    }

    /**
     * Add liaisonsOffice
     *
     * @param \Baquaras\TestBundle\Entity\Item $liaisonsOffice
     * @return ArchitectureApplication
     */
    public function addLiaisonsOffice(\Baquaras\TestBundle\Entity\Item $liaisonsOffice)
    {
        $this->liaisonsOffice[] = $liaisonsOffice;

        return $this;
    }

    /**
     * Remove liaisonsOffice
     *
     * @param \Baquaras\TestBundle\Entity\Item $liaisonsOffice
     */
    public function removeLiaisonsOffice(\Baquaras\TestBundle\Entity\Item $liaisonsOffice)
    {
        $this->liaisonsOffice->removeElement($liaisonsOffice);
    }

    /**
     * Get liaisonsOffice
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLiaisonsOffice()
    {
        return $this->liaisonsOffice;
    }

    /**
     * Add briques
     *
     * @param \Baquaras\TestBundle\Entity\BriqueArchitecture $briques
     * @return ArchitectureApplication
     */
    public function addBrique(\Baquaras\TestBundle\Entity\BriqueArchitecture $briques)
    {
        $this->briques[] = $briques;

        return $this;
    }

    /**
     * Remove briques
     *
     * @param \Baquaras\TestBundle\Entity\BriqueArchitecture $briques
     */
    public function removeBrique(\Baquaras\TestBundle\Entity\BriqueArchitecture $briques)
    {
        $this->briques->removeElement($briques);
    }

    /**
     * Get briques
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBriques()
    {
        return $this->briques;
    }

    /**
     * Set urlExtranet
     *
     * @param string $urlExtranet
     * @return ArchitectureApplication
     */
    public function setUrlExtranet($urlExtranet)
    {
        $this->urlExtranet = $urlExtranet;

        return $this;
    }

    /**
     * Get urlExtranet
     *
     * @return string 
     */
    public function getUrlExtranet()
    {
        return $this->urlExtranet;
    }

    /**
     * Set urlIntranet
     *
     * @param string $urlIntranet
     * @return ArchitectureApplication
     */
    public function setUrlIntranet($urlIntranet)
    {
        $this->urlIntranet = $urlIntranet;

        return $this;
    }

    /**
     * Get urlIntranet
     *
     * @return string 
     */
    public function getUrlIntranet()
    {
        return $this->urlIntranet;
    }
}
