<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Profil
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\ProfilRepository")
 */
class Profil
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
     * @ORM\OneToMany(targetEntity="Droit", mappedBy="profil")
     */
    private $droits;
    
	


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
     * @return Profil
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
     * Add droits
     *
     * @param \Baquaras\TestBundle\Entity\Droit $droits
     * @return Profil
     */
    public function addDroit(\Baquaras\TestBundle\Entity\Droit $droits)
    {
        $this->droits[] = $droits;

        return $this;
    }

    /**
     * Remove droits
     *
     * @param \Baquaras\TestBundle\Entity\Droit $droits
     */
    public function removeDroit(\Baquaras\TestBundle\Entity\Droit $droits)
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
	
	public function __toString() {
		return $this->getLibelle();
	}
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->droits = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
