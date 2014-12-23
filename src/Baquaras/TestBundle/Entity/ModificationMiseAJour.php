<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModificationMiseAJour
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\ModificationMiseAJourRepository")
 */
class ModificationMiseAJour
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
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="modifsmaj")
     * @ORM\JoinColumn(name="utilisateur", referencedColumnName="id")
     **/
    //private $utilisateur;

	/**
     * @ORM\ManyToOne(targetEntity="MiseAJour", inversedBy="modifs")
     * @ORM\JoinColumn(name="miseAJour", referencedColumnName="id", nullable=true)
     **/
    //private $miseajour;
	
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
     * @return ModificationMiseAJour
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
     * @return ModificationMiseAJour
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
     * @return ModificationMiseAJour
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
     * @return ModificationMiseAJour
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
     * Set miseajour
     *
     * @param \Baquaras\TestBundle\Entity\MiseAJour $miseajour
     * @return ModificationMiseAJour
     */
    public function setMiseajour(\Baquaras\TestBundle\Entity\MiseAJour $miseajour = null)
    {
        $this->miseajour = $miseajour;

        return $this;
    }

    /**
     * Get miseajour
     *
     * @return \Baquaras\TestBundle\Entity\MiseAJour 
     */
    public function getMiseajour()
    {
        return $this->miseajour;
    }
}
