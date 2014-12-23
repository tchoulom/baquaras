<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OSCible
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class OSCible
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
     * @return OSCible
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
        $this->applications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->misesajour = new \Doctrine\Common\Collections\ArrayCollection();
        $this->scripts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->autresprerequis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add applications
     *
     * @param \Baquaras\TestBundle\Entity\Application $applications
     * @return OSCible
     */
    public function addApplication(\Baquaras\TestBundle\Entity\Application $applications)
    {
        $this->applications[] = $applications;

        return $this;
    }

    /**
     * Remove applications
     *
     * @param \Baquaras\TestBundle\Entity\Application $applications
     */
    public function removeApplication(\Baquaras\TestBundle\Entity\Application $applications)
    {
        $this->applications->removeElement($applications);
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Add misesajour
     *
     * @param \Baquaras\TestBundle\Entity\MiseAJour $misesajour
     * @return OSCible
     */
    public function addMisesajour(\Baquaras\TestBundle\Entity\MiseAJour $misesajour)
    {
        $this->misesajour[] = $misesajour;

        return $this;
    }

    /**
     * Remove misesajour
     *
     * @param \Baquaras\TestBundle\Entity\MiseAJour $misesajour
     */
    public function removeMisesajour(\Baquaras\TestBundle\Entity\MiseAJour $misesajour)
    {
        $this->misesajour->removeElement($misesajour);
    }

    /**
     * Get misesajour
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMisesajour()
    {
        return $this->misesajour;
    }

    /**
     * Add scripts
     *
     * @param \Baquaras\TestBundle\Entity\Script $scripts
     * @return OSCible
     */
    public function addScript(\Baquaras\TestBundle\Entity\Script $scripts)
    {
        $this->scripts[] = $scripts;

        return $this;
    }

    /**
     * Remove scripts
     *
     * @param \Baquaras\TestBundle\Entity\Script $scripts
     */
    public function removeScript(\Baquaras\TestBundle\Entity\Script $scripts)
    {
        $this->scripts->removeElement($scripts);
    }

    /**
     * Get scripts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getScripts()
    {
        return $this->scripts;
    }

    /**
     * Add autresprerequis
     *
     * @param \Baquaras\TestBundle\Entity\AutrePreRequis $autresprerequis
     * @return OSCible
     */
    public function addAutresprerequi(\Baquaras\TestBundle\Entity\AutrePreRequis $autresprerequis)
    {
        $this->autresprerequis[] = $autresprerequis;

        return $this;
    }

    /**
     * Remove autresprerequis
     *
     * @param \Baquaras\TestBundle\Entity\AutrePreRequis $autresprerequis
     */
    public function removeAutresprerequi(\Baquaras\TestBundle\Entity\AutrePreRequis $autresprerequis)
    {
        $this->autresprerequis->removeElement($autresprerequis);
    }

    /**
     * Get autresprerequis
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAutresprerequis()
    {
        return $this->autresprerequis;
    }
}
