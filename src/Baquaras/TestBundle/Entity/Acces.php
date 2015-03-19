<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acces
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_1", columns={"id"})})
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\AccesRepository")
 */
class Acces
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
     * @ORM\OneToMany(targetEntity="DroitWorkflow", mappedBy="acces")
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
     * @return Acces
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
     * @param \Baquaras\TestBundle\Entity\DroitWorkflow $droits
     * @return Acces
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
}
