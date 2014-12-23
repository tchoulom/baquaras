<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Item
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\ItemRepository")
 */
class Item
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
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true)
	 * @Assert\NotBlank (message = "Veuillez préciser un nom pour cet item")
     */
    private $libelle;
	
    /**
     * @ORM\ManyToOne(targetEntity="Liste", inversedBy="items")
     * @ORM\JoinColumn(name="liste", referencedColumnName="id")
	 * @Assert\NotBlank (message = "Veuillez sélectionner une liste")
     **/
    private $liste;
	
	/**
     * @ORM\ManyToMany(targetEntity="ArchitectureApplication", mappedBy="liaisonsOffice")
     */
    private $archis;
		
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
     * @return Item
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
     * Set liste
     *
     * @param \Baquaras\TestBundle\Entity\Liste $liste
     * @return Item
     */
    public function setListe(\Baquaras\TestBundle\Entity\Liste $liste = null)
    {
        $this->liste = $liste;

        return $this;
    }

    /**
     * Get liste
     *
     * @return \Baquaras\TestBundle\Entity\Liste 
     */
    public function getListe()
    {
        return $this->liste;
    }
	
	public function __toString() {
		return $this->libelle;
	}
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->archis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add archis
     *
     * @param \Baquaras\TestBundle\Entity\ArchitectureApplication $archis
     * @return Item
     */
    public function addArchi(\Baquaras\TestBundle\Entity\ArchitectureApplication $archis)
    {
        $this->archis[] = $archis;

        return $this;
    }

    /**
     * Remove archis
     *
     * @param \Baquaras\TestBundle\Entity\ArchitectureApplication $archis
     */
    public function removeArchi(\Baquaras\TestBundle\Entity\ArchitectureApplication $archis)
    {
        $this->archis->removeElement($archis);
    }

    /**
     * Get archis
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArchis()
    {
        return $this->archis;
    }
}
