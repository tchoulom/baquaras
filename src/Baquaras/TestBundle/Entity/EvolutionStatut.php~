<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvolutionStatut
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\EvolutionStatutRepository")
 */
class EvolutionStatut
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
     * @ORM\ManyToOne(targetEntity="Package", inversedBy="evolutionsStatut")
     * @ORM\JoinColumn(name="package_id", referencedColumnName="id", nullable=true)
     */
    private $package;
 
    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="evolutionsStatut")
     * @ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id", nullable=true)
     */
    private $utilisateur;
 
    /**
     * @ORM\Column(name="date_modification_statut", type="date", nullable=true)
     */
    private $dateModif;
	
    /**
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=true)
     */
    private $commentaire;
	
	/**
     * @ORM\Column(name="objet_modif", type="string", length=255, nullable=true)
     */
    private $objetModif;

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
     * Set dateModif
     *
     * @param \DateTime $dateModif
     * @return EvolutionStatut
     */
    public function setDateModif($dateModif)
    {
        $this->dateModif = $dateModif;

        return $this;
    }

    /**
     * Get dateModif
     *
     * @return \DateTime 
     */
    public function getDateModif()
    {
        return $this->dateModif;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return EvolutionStatut
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

    /**
     * Set objetModif
     *
     * @param string $objetModif
     * @return EvolutionStatut
     */
    public function setObjetModif($objetModif)
    {
        $this->objetModif = $objetModif;

        return $this;
    }

    /**
     * Get objetModif
     *
     * @return string 
     */
    public function getObjetModif()
    {
        return $this->objetModif;
    }

    /**
     * Set package
     *
     * @param \Baquaras\TestBundle\Entity\Package $package
     * @return EvolutionStatut
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
     * Set utilisateur
     *
     * @param \Baquaras\TestBundle\Entity\Utilisateur $utilisateur
     * @return EvolutionStatut
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
}
