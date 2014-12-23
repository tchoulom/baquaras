<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Droit
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\DroitRepository")
 */
class Droit
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
     * @ORM\ManyToOne(targetEntity="Profil", inversedBy="droits")
	 * @ORM\JoinColumn(name="Profil_id", referencedColumnName="id")
	 * @Assert\NotNull (message = "Veuillez sélectionner un profil")
     **/
    private $profil;
	
	/**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="droits")
	 * @ORM\JoinColumn(name="Page_id", referencedColumnName="id")
	 * @Assert\NotNull(message = "Veuillez sélectionner une page")
     **/
    private $page;
	
	/**
     * @var boolean
     *
     * @ORM\Column(name="Acces_id", type="boolean")
	 * @Assert\NotNull (message = "Veuillez sélectionner un type d'accès")
     */
    private $acces;

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
     * Set acces
     *
     * @param boolean $acces
     * @return Droit
     */
    public function setAcces($acces)
    {
        $this->acces = $acces;

        return $this;
    }

    /**
     * Get acces
     *
     * @return boolean 
     */
    public function getAcces()
    {
        return $this->acces;
    }

    /**
     * Set profil
     *
     * @param \Baquaras\TestBundle\Entity\Profil $profil
     * @return Droit
     */
    public function setProfil(\Baquaras\TestBundle\Entity\Profil $profil = null)
    {
        $this->profil = $profil;

        return $this;
    }

    /**
     * Get profil
     *
     * @return \Baquaras\TestBundle\Entity\Profil 
     */
    public function getProfil()
    {
        return $this->profil;
    }

    /**
     * Set page
     *
     * @param \Baquaras\TestBundle\Entity\Page $page
     * @return Droit
     */
    public function setPage(\Baquaras\TestBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \Baquaras\TestBundle\Entity\Page 
     */
    public function getPage()
    {
        return $this->page;
    }
}
