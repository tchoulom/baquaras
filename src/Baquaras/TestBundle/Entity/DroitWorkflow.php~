<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DroitWorkflow
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\DroitWorkflowRepository")
 */
class DroitWorkflow
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
     * @ORM\ManyToOne(targetEntity="Statut", inversedBy="droits")
	 * @ORM\JoinColumn(name="Statut_id", referencedColumnName="id")
	 * @Assert\NotNull (message = "Veuillez sélectionner un statut")
     **/
    private $statut;
	
	/**
     * @ORM\ManyToOne(targetEntity="Acces", inversedBy="droits")
	 * @ORM\JoinColumn(name="Acces_id", referencedColumnName="id")
	 * @Assert\NotNull (message = "Veuillez sélectionner un accès")
     **/
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
     * Set profil
     *
     * @param \Baquaras\TestBundle\Entity\Profil $profil
     * @return DroitWorkflow
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
     * Set statut
     *
     * @param \Baquaras\TestBundle\Entity\Statut $statut
     * @return DroitWorkflow
     */
    public function setStatut(\Baquaras\TestBundle\Entity\Statut $statut = null)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return \Baquaras\TestBundle\Entity\Statut 
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set acces
     *
     * @param \Baquaras\TestBundle\Entity\Acces $acces
     * @return DroitWorkflow
     */
    public function setAcces(\Baquaras\TestBundle\Entity\Acces $acces = null)
    {
        $this->acces = $acces;

        return $this;
    }

    /**
     * Get acces
     *
     * @return \Baquaras\TestBundle\Entity\Acces 
     */
    public function getAcces()
    {
        return $this->acces;
    }
}
