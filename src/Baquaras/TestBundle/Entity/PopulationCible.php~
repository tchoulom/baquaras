<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PopulationCible
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PopulationCible
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
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="population", type="string", length=255)
     */
    private $population;
	
	/**
     * @ORM\ManyToOne(targetEntity="Application", inversedBy="populationCible")
     **/
    private $application;


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
     * Set departement
     *
     * @param string $departement
     * @return PopulationCible
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return string 
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set ud
     *
     * @param string $ud
     * @return PopulationCible
     */
    public function setUd($ud)
    {
        $this->ud = $ud;

        return $this;
    }

    /**
     * Get ud
     *
     * @return string 
     */
    public function getUd()
    {
        return $this->ud;
    }

    /**
     * Set ul
     *
     * @param string $ul
     * @return PopulationCible
     */
    public function setUl($ul)
    {
        $this->ul = $ul;

        return $this;
    }

    /**
     * Get ul
     *
     * @return string 
     */
    public function getUl()
    {
        return $this->ul;
    }

    /**
     * Set application
     *
     * @param \Baquaras\TestBundle\Entity\Application $application
     * @return PopulationCible
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
     * Set libelle
     *
     * @param string $libelle
     * @return PopulationCible
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
     * Set population
     *
     * @param string $population
     * @return PopulationCible
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        return $this;
    }

    /**
     * Get population
     *
     * @return string 
     */
    public function getPopulation()
    {
        return $this->population;
    }
}
