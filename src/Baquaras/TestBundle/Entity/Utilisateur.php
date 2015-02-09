<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Utilisateur
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Security\User\UtilisateurRepository")
 * @UniqueEntity(
 * 		fields={"cpteMatriculaire"},
 * 		message="Cet utilisateur a déjà été ajouté"
 *		)
 * @UniqueEntity(
 * 		fields={"nom","prenom","mail"},
 * 		message="Cet utilisateur a déjà été ajouté"
 *		)
 */
class Utilisateur
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
     * @ORM\Column(name="Civilite", type="string", length=255, nullable=true)
     */
    private $civilite;
	
    /**
     * @var string
	 *
     * @ORM\Column(name="Nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=255, nullable=true)
     */
    private $prenom;
	
	/**
     * @var string
     *
     * @ORM\Column(name="Statut", type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="CpteMatriculaire", type="string", length=255, nullable=true)
     */
    private $cpteMatriculaire;
	
	/**
     * @var string
     *
     * @ORM\Column(name="Matricule", type="string", length=255, nullable=true)
     */
    private $matricule;
	
    /**
     * @var string
     * @ORM\Column(name="Mail", type="string", length=255, nullable=true)
     * @Assert\Email()
     */
    private $mail;
	
	/**
     * @var string
     *
     * @ORM\Column(name="Telephone", type="string", length=255, nullable=true)
     */
    private $telephone;
 
 	/**
     * @ORM\ManyToOne(targetEntity="Profil")
     * @ORM\JoinColumn(name="profil1", referencedColumnName="id", nullable=true)
	 * @Assert\NotBlank (message = "Veuillez affecter un profil à l'utilisateur")
     */
    private $profil1;
	
	/**
     * @ORM\ManyToOne(targetEntity="Profil")
     * @ORM\JoinColumn(name="profil2", referencedColumnName="id", nullable=true)
     */
    private $profil2;
	
	/**
     * @ORM\OneToMany(targetEntity="EvolutionStatut", mappedBy="utilisateur")
     **/
    private $evolutionsStatut;
	
	/**
     * @ORM\OneToMany(targetEntity="ModificationApplication", mappedBy="utilisateur")
     **/
    private $modifsApplication;

    /**
     * @ORM\ManyToMany(targetEntity="Application", inversedBy="utilisateur", cascade={"persist"})
     * @ORM\JoinTable(name="utilisateur_application")
     **/
    private $application;
    
    /**
     * @ORM\ManyToMany(targetEntity="Application", inversedBy="moes", cascade={"persist"})
     * @ORM\JoinTable(name="moa_application")
     **/
    private $applications;
    
    /**
     * @ORM\ManyToMany(targetEntity="Application", inversedBy="droitsApplication")
     * @ORM\JoinTable(name="droits_application")

     **/
    private $usersDroit;
	
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
     * Set civilite
     *
     * @param string $civilite
     * @return Utilisateur
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get civilite
     *
     * @return string 
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Utilisateur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set statut
     *
     * @param string $statut
     * @return Utilisateur
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string 
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set matricule
     *
     * @param string $matricule
     * @return Utilisateur
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule
     *
     * @return string 
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return Utilisateur
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set cpteMatriculaire
     *
     * @param string $cpteMatriculaire
     * @return Utilisateur
     */
    public function setCpteMatriculaire($cpteMatriculaire)
    {
        $this->cpteMatriculaire = $cpteMatriculaire;

        return $this;
    }

    /**
     * Get cpteMatriculaire
     *
     * @return string 
     */
    public function getCpteMatriculaire()
    {
        return $this->cpteMatriculaire;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Utilisateur
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }
	
	public function __toString()
	{
		return $this->getNom().' '.$this->getPrenom();
	}

    /**
     * Set profil1
     *
     * @param \Baquaras\TestBundle\Entity\Profil $profil1
     * @return Utilisateur
     */
    public function setProfil1($profil1 = 1)
    {
        $this->profil1 = $profil1;

        return $this;
    }

    /**
     * Get profil1
     *
     * @return \Baquaras\TestBundle\Entity\Profil 
     */
    public function getProfil1()
    {
        return $this->profil1;
    }

    /**
     * Set profil2
     *
     * @param \Baquaras\TestBundle\Entity\Profil $profil2
     * @return Utilisateur
     */
    public function setProfil2(\Baquaras\TestBundle\Entity\Profil $profil2 = null)
    {
        $this->profil2 = $profil2;

        return $this;
    }

    /**
     * Get profil2
     *
     * @return \Baquaras\TestBundle\Entity\Profil 
     */
    public function getProfil2()
    {
        return $this->profil2;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->evolutionsStatut = new \Doctrine\Common\Collections\ArrayCollection();
        $this->modifsApplication = new \Doctrine\Common\Collections\ArrayCollection();
        $this->application = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usersDroit = new \Doctrine\Common\Collections\ArrayCollection();
        $this->applications = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add evolutionsStatut
     *
     * @param \Baquaras\TestBundle\Entity\EvolutionStatut $evolutionsStatut
     * @return Utilisateur
     */
    public function addEvolutionsStatut(\Baquaras\TestBundle\Entity\EvolutionStatut $evolutionsStatut)
    {
        $this->evolutionsStatut[] = $evolutionsStatut;

        return $this;
    }

    /**
     * Remove evolutionsStatut
     *
     * @param \Baquaras\TestBundle\Entity\EvolutionStatut $evolutionsStatut
     */
    public function removeEvolutionsStatut(\Baquaras\TestBundle\Entity\EvolutionStatut $evolutionsStatut)
    {
        $this->evolutionsStatut->removeElement($evolutionsStatut);
    }

    /**
     * Get evolutionsStatut
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvolutionsStatut()
    {
        return $this->evolutionsStatut;
    }

    /**
     * Add modifsApplication
     *
     * @param \Baquaras\TestBundle\Entity\ModificationApplication $modifsApplication
     * @return Utilisateur
     */
    public function addModifsApplication(\Baquaras\TestBundle\Entity\ModificationApplication $modifsApplication)
    {
        $this->modifsApplication[] = $modifsApplication;

        return $this;
    }

    /**
     * Remove modifsApplication
     *
     * @param \Baquaras\TestBundle\Entity\ModificationApplication $modifsApplication
     */
    public function removeModifsApplication(\Baquaras\TestBundle\Entity\ModificationApplication $modifsApplication)
    {
        $this->modifsApplication->removeElement($modifsApplication);
    }

    /**
     * Get modifsApplication
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModifsApplication()
    {
        return $this->modifsApplication;
    }

    /**
     * Set application
     *
     * @param \Baquaras\TestBundle\Entity\Application $application
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
     * Add Application
     *
     * @param \Baquaras\TestBundle\Entity\Application $Application
     * @return Utilisateur
     */
    public function addApplication(\Baquaras\TestBundle\Entity\Application $Application)
    {
        $this->application[] = $Application;

        return $this;
    }

    public function getCompleteName()
    {
        return sprintf('%s - %s', $this->nom, $this->prenom);
    }

    /**
     * Remove application
     *
     * @param \Baquaras\TestBundle\Entity\Application $application
     */
    public function removeApplication(\Baquaras\TestBundle\Entity\Application $application)
    {
        $this->application->removeElement($application);
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
     * Add usersDroit
     *
     * @param \Baquaras\TestBundle\Entity\Application $usersDroit
     * @return Utilisateur
     */
    public function addUsersDroit(\Baquaras\TestBundle\Entity\Application $usersDroit)
    {
        $this->usersDroit[] = $usersDroit;

        return $this;
    }

    /**
     * Remove usersDroit
     *
     * @param \Baquaras\TestBundle\Entity\Application $usersDroit
     */
    public function removeUsersDroit(\Baquaras\TestBundle\Entity\Application $usersDroit)
    {
        $this->usersDroit->removeElement($usersDroit);
    }

    /**
     * Get usersDroit
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsersDroit()
    {
        return $this->usersDroit;
    }
}
