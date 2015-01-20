<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\PageRepository")
 */
class Page
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
     * @ORM\OneToMany(targetEntity="Droit", mappedBy="page")
     */
    private $droits;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;
	
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
        $this->droits = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Page
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
     * Set type
     *
     * @param integer $type
     * @return type
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * Add droits
     *
     * @param \Baquaras\TestBundle\Entity\Droit $droits
     * @return Page
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
}
