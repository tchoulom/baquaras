<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PreRequis
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\PreRequisRepository")
 */
class PreRequis
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
     * @ORM\ManyToOne(targetEntity="Application")
     * @ORM\JoinColumn(name="libelle", referencedColumnName="id")
	 * @Assert\NotBlank (message = "Veuillez sélectionner une application")
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=5000, nullable=true)
     */
    private $commentaire;

 	/**
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="Mode_Gestion", referencedColumnName="id", nullable=true)
	 * @Assert\NotBlank (message = "Veuillez sélectionner un mode de gestion")
     */
    private $modeGestion;
	
 	/**
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="OS_Cible", referencedColumnName="id", nullable=true)
	 * @Assert\NotBlank (message = "Veuillez sélectionner un système d'exploitation")
     */
    private $oscible;
	
	/**
     * @ORM\ManyToOne(targetEntity="Application", inversedBy="preRequis")
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
     * Set libelle
     *
     * @param string $libelle
     * @return PreRequis
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
     * Set modeGestion
     *
     * @param \Baquaras\TestBundle\Entity\Item $modeGestion
     * @return PreRequis
     */
    public function setModeGestion(\Baquaras\TestBundle\Entity\Item $modeGestion = null)
    {
        $this->modeGestion = $modeGestion;

        return $this;
    }

    /**
     * Get modeGestion
     *
     * @return \Baquaras\TestBundle\Entity\Item 
     */
    public function getModeGestion()
    {
        return $this->modeGestion;
    }

    /**
     * Set oscible
     *
     * @param \Baquaras\TestBundle\Entity\Item $oscible
     * @return PreRequis
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
     * Set application
     *
     * @param \Baquaras\TestBundle\Entity\Application $application
     * @return PreRequis
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
     * Set commentaire
     *
     * @param string $commentaire
     * @return PreRequis
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
}
