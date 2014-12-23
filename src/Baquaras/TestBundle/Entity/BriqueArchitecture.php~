<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BriqueArchitecture
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\BriqueArchitectureRepository")
 */
class BriqueArchitecture
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
     * @ORM\ManyToMany(targetEntity="ArchitectureApplication", mappedBy="briques")
     */
    private $architecture;
    
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
        $this->architecture = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return BriqueArchitecture
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
     * Add architecture
     *
     * @param \Baquaras\TestBundle\Entity\ArchitectureApplication $architecture
     * @return BriqueArchitecture
     */
    public function addArchitecture(\Baquaras\TestBundle\Entity\ArchitectureApplication $architecture)
    {
        $this->architecture[] = $architecture;

        return $this;
    }

    /**
     * Remove architecture
     *
     * @param \Baquaras\TestBundle\Entity\ArchitectureApplication $architecture
     */
    public function removeArchitecture(\Baquaras\TestBundle\Entity\ArchitectureApplication $architecture)
    {
        $this->architecture->removeElement($architecture);
    }

    /**
     * Get architecture
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArchitecture()
    {
        return $this->architecture;
    }
}
