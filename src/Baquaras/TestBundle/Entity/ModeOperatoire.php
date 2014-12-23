<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModeOperatoire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\ModeOperatoireRepository")
 */
class ModeOperatoire
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
     * @ORM\Column(name="Libelle", type="string", length=255, nullable=true)
     */
    private $libelle;

	/**
     * @var string
     *
     * @ORM\Column(name="Precautions", type="string", length=5000, nullable=true)
     */
	private $precautions;
	
	/**
     * @var string
     *
     * @ORM\Column(name="Prerequis", type="string", length=5000, nullable=true)
     */
	private $prerequis;
	
	/**
     * @var string
     *
     * @ORM\Column(name="Preliminaire", type="string", length=5000, nullable=true)
     */
	private $preliminaire;
	
	/**
     * @var string
     *
     * @ORM\Column(name="Installation", type="string", length=5000, nullable=true)
     */
	private $installation;
	
	/**
     * @var string
     *
     * @ORM\Column(name="Test", type="string", length=5000, nullable=true)
     */
	private $test;
	
	/**
     * @var string
     *
     * @ORM\Column(name="RepriseExistant", type="string", length=5000, nullable=true)
     */
	private $repriseexistant;
	
	/**
     * @var string
     *
     * @ORM\Column(name="Arborescence", type="string", length=5000, nullable=true)
     */
	private $arborescence;
	
		/**
     * @var string
     *
     * @ORM\Column(name="Parameters", type="string", length=5000, nullable=true)
     */
	private $parameters;
	
	/**
     * @ORM\OneToMany(targetEntity="package", mappedBy="modeOperatoire")
     */
    private $packages;

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
     * Set libelle
     *
     * @param string $libelle
     * @return ModeOperatoire
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set ligneCommandePublication
     *
     * @param string $ligneCommandePublication
     * @return ModeOperatoire
     */
    public function setLigneCommandePublication($ligneCommandePublication)
    {
        $this->ligneCommandePublication = $ligneCommandePublication;

        return $this;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->packages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add packages
     *
     * @param \Baquaras\TestBundle\Entity\Package $packages
     * @return ModeOperatoire
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
     * Set precautions
     *
     * @param string $precautions
     * @return ModeOperatoire
     */
    public function setPrecautions($precautions)
    {
        $this->precautions = $precautions;

        return $this;
    }

    /**
     * Get precautions
     *
     * @return string 
     */
    public function getPrecautions()
    {
        return $this->precautions;
    }

    /**
     * Set preliminaire
     *
     * @param string $preliminaire
     * @return ModeOperatoire
     */
    public function setPreliminaire($preliminaire)
    {
        $this->preliminaire = $preliminaire;

        return $this;
    }

    /**
     * Get preliminaire
     *
     * @return string 
     */
    public function getPreliminaire()
    {
        return $this->preliminaire;
    }

    /**
     * Set installation
     *
     * @param string $installation
     * @return ModeOperatoire
     */
    public function setInstallation($installation)
    {
        $this->installation = $installation;

        return $this;
    }

    /**
     * Get installation
     *
     * @return string 
     */
    public function getInstallation()
    {
        return $this->installation;
    }

    /**
     * Set test
     *
     * @param string $test
     * @return ModeOperatoire
     */
    public function setTest($test)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get test
     *
     * @return string 
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Set repriseexistant
     *
     * @param string $repriseexistant
     * @return ModeOperatoire
     */
    public function setRepriseexistant($repriseexistant)
    {
        $this->repriseexistant = $repriseexistant;

        return $this;
    }

    /**
     * Get repriseexistant
     *
     * @return string 
     */
    public function getRepriseexistant()
    {
        return $this->repriseexistant;
    }

    /**
     * Set arborescence
     *
     * @param string $arborescence
     * @return ModeOperatoire
     */
    public function setArborescence($arborescence)
    {
        $this->arborescence = $arborescence;

        return $this;
    }

    /**
     * Get arborescence
     *
     * @return string 
     */
    public function getArborescence()
    {
        return $this->arborescence;
    }

    /**
     * Set parameters
     *
     * @param string $parameters
     * @return ModeOperatoire
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get parameters
     *
     * @return string 
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set prerequis
     *
     * @param string $prerequis
     * @return ModeOperatoire
     */
    public function setPrerequis($prerequis)
    {
        $this->prerequis = $prerequis;

        return $this;
    }

    /**
     * Get prerequis
     *
     * @return string 
     */
    public function getPrerequis()
    {
        return $this->prerequis;
    }
}
