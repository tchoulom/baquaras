<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Script
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\ScriptRepository")
 */
class Script
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
     * @ORM\Column(name="Nom", type="string", length=255)
	 * @Assert\NotBlank (message = "Veuillez indiquer un nom")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Fonction", type="string", length=255)
	 * @Assert\NotBlank (message = "Veuillez renseigner sa fonction")
     */
    private $fonction;

	/**
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="Type", referencedColumnName="id")
	 * @Assert\NotBlank (message = "Veuillez sélectionner un type")
     */
    private $type;

	/**
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="Techno", referencedColumnName="id", nullable=true)
     */
    private $techno;

	/**
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="Condition_Execution", referencedColumnName="id", nullable=true)
     */
    private $conditionExecution;
	
	/**
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="Condition_Lancement", referencedColumnName="id", nullable=true)
     */
    private $conditionLancement;
	
 	/**
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="oscible", referencedColumnName="id", nullable=true)
     */
    private $oscible;
	
	/**
     * @ORM\ManyToOne(targetEntity="Package", inversedBy="scripts")
     * @ORM\JoinColumn(name="package_id", referencedColumnName="id", nullable=true)
     **/
    private $package;

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
     * @return Script
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
     * Set fonction
     *
     * @param string $fonction
     * @return Script
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return string 
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Script
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set techno
     *
     * @param string $techno
     * @return Script
     */
    public function setTechno($techno)
    {
        $this->techno = $techno;

        return $this;
    }

    /**
     * Get techno
     *
     * @return string 
     */
    public function getTechno()
    {
        return $this->techno;
    }

    /**
     * Set conditionExecution
     *
     * @param string $conditionExecution
     * @return Script
     */
    public function setConditionExecution($conditionExecution)
    {
        $this->conditionExecution = $conditionExecution;

        return $this;
    }

    /**
     * Get conditionExecution
     *
     * @return string 
     */
    public function getConditionExecution()
    {
        return $this->conditionExecution;
    }

    /**
     * Set oscible
     *
     * @param \Baquaras\TestBundle\Entity\Item $oscible
     * @return Script
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
     * Set package
     *
     * @param \Baquaras\TestBundle\Entity\Package $package
     * @return Script
     */
    public function setPackage(\Baquaras\TestBundle\Entity\Package $package = null)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * Get package
     *
     * @return \Baquaras\TestBundle\Entity\Package 
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Set conditionLancement
     *
     * @param string $conditionLancement
     * @return Script
     */
    public function setConditionLancement($conditionLancement)
    {
        $this->conditionLancement = $conditionLancement;

        return $this;
    }

    /**
     * Get conditionLancement
     *
     * @return string 
     */
    public function getConditionLancement()
    {
        return $this->conditionLancement;
    }
}
