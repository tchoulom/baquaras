<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groupe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\GroupeRepository")
 */
class Groupe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Libelle", type="string", length=255, nullable=true)
     */
    protected $libelle;
	
	/**
     * @ORM\OneToMany(targetEntity="GroupeApplication", mappedBy="groupe")
     **/
    private $groupeApplications;

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
     * @return Groupe
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
        $this->groupeApplications = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add groupeApplications
     *
     * @param \Baquaras\TestBundle\Entity\GroupeApplication $groupeApplications
     * @return Groupe
     */
    public function addGroupeApplication(\Baquaras\TestBundle\Entity\GroupeApplication $groupeApplications)
    {
        $this->groupeApplications[] = $groupeApplications;

        return $this;
    }

    /**
     * Remove groupeApplications
     *
     * @param \Baquaras\TestBundle\Entity\GroupeApplication $groupeApplications
     */
    public function removeGroupeApplication(\Baquaras\TestBundle\Entity\GroupeApplication $groupeApplications)
    {
        $this->groupeApplications->removeElement($groupeApplications);
    }

    /**
     * Get groupeApplications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupeApplications()
    {
        return $this->groupeApplications;
    }
}
