<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statut
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\StatutRepository")
 */
class Statut
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
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true)
     */
    private $libelle;

	/**
     * @ORM\OneToMany(targetEntity="DroitWorkflow", mappedBy="statut")
     */
    private $droits;
	
	/**
     * @ORM\OneToMany(targetEntity="Package", mappedBy="statutQualif")
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
     * @return Statut
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
     * Constructor
     */
    public function __construct()
    {
        $this->droits = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add droits
     *
     * @param \Baquaras\TestBundle\Entity\DroitWorkflow $droits
     * @return Statut
     */
    public function addDroit(\Baquaras\TestBundle\Entity\DroitWorkflow $droits)
    {
        $this->droits[] = $droits;

        return $this;
    }

    /**
     * Remove droits
     *
     * @param \Baquaras\TestBundle\Entity\DroitWorkflow $droits
     */
    public function removeDroit(\Baquaras\TestBundle\Entity\DroitWorkflow $droits)
    {
        $this->droits->removeElement($droits);
    }

    /**
     * Get droits
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDroits()
    {
        return $this->droits;
    }

    /**
     * Add packages
     *
     * @param \Baquaras\TestBundle\Entity\Package $packages
     * @return Statut
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
	
	public function __toString()
	{
		return $this->getLibelle();
	}

   
}
