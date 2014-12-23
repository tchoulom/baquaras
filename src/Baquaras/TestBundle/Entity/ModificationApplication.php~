<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModificationApplication
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\ModificationApplicationRepository")
 */
class ModificationApplication
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
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="modifsApplication")
     * @ORM\JoinColumn(name="utilisateur", referencedColumnName="id")
     **/
    private $utilisateur;

	/**
     * @ORM\ManyToOne(targetEntity="Package", inversedBy="modifsApplication")
     * @ORM\JoinColumn(name="packageModifie", referencedColumnName="id", nullable=true)
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
     * Set champModifie
     *
     * @param string $champModifie
     * @return ModificationApplication
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
     * @return ModificationApplication
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
     * @return ModificationApplication
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

    /**
     * Set utilisateur
     *
     * @param \Baquaras\TestBundle\Entity\Utilisateur $utilisateur
     * @return ModificationApplication
     */
    public function setUtilisateur(\Baquaras\TestBundle\Entity\Utilisateur $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \Baquaras\TestBundle\Entity\Utilisateur 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set package
     *
     * @param \Baquaras\TestBundle\Entity\Package $package
     * @return ModificationApplication
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
}
