<?php
namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistoriqueModifications
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\HistoriqueModificationsRepository")
 */
class HistoriqueModifications
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
	 * @ORM\Column(name="Table_Modifiee", type="string", length=255, nullable=true)
	 */
	private $tableModifiee;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="Champ_Modifie", type="string", length=255, nullable=true)
	 */
	private $champModifie;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="Date_Modification", type="datetime", nullable=true)
	 */
	private $dateModification;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="Ancienne_Valeur_Champ", type="string", length=255, nullable=true)
	 */
	private $ancienneValeurChamp;

	/**
	 * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="modifs")
	 * @ORM\JoinColumn(name="utilisateur", referencedColumnName="id")
	 **/
	//private $utilisateur;
/*
	/**
	 * @ORM\ManyToOne(targetEntity="Application", inversedBy="modifs")
	 * @ORM\JoinColumn(name="application", referencedColumnName="id")
	 **/
	/*private $application;*/
	
	/**
	 * @ORM\ManyToOne(targetEntity="Application", inversedBy="histoModif")
	 * @ORM\JoinColumn(name="application", referencedColumnName="id")
	 **/
//	private $application;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Package", inversedBy="modifs")
	 * @ORM\JoinTable(name="modifsPackage")
	 **/
	/*private $package;*/

	/**
	 * @ORM\ManyToMany(targetEntity="MiseAJour", inversedBy="modifs")
	 * @ORM\JoinTable(name="modifsMAJ")
	 **/
	//private $miseajour;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->miseajour = new \Doctrine\Common\Collections\ArrayCollection();
    }

   

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
     * Set tableModifiee
     *
     * @param string $tableModifiee
     * @return HistoriqueModifications
     */
    public function setTableModifiee($tableModifiee)
    {
        $this->tableModifiee = $tableModifiee;

        return $this;
    }

    /**
     * Get tableModifiee
     *
     * @return string 
     */
    public function getTableModifiee()
    {
        return $this->tableModifiee;
    }

    /**
     * Set champModifie
     *
     * @param string $champModifie
     * @return HistoriqueModifications
     */
    public function setChampModifie($champModifie)
    {
        $this->champModifie = $champModifie;

        return $this;
    }

    /**
     * Get champModifie
     *
     * @return string 
     */
    public function getChampModifie()
    {
        return $this->champModifie;
    }

    /**
     * Set dateModification
     *
     * @param \DateTime $dateModification
     * @return HistoriqueModifications
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get dateModification
     *
     * @return \DateTime 
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * Set ancienneValeurChamp
     *
     * @param string $ancienneValeurChamp
     * @return HistoriqueModifications
     */
    public function setAncienneValeurChamp($ancienneValeurChamp)
    {
        $this->ancienneValeurChamp = $ancienneValeurChamp;

        return $this;
    }

    /**
     * Get ancienneValeurChamp
     *
     * @return string 
     */
    public function getAncienneValeurChamp()
    {
        return $this->ancienneValeurChamp;
    }
}
