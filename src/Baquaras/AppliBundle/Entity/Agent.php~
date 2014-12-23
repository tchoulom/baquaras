<?php
namespace Baquaras\AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Events;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Baquaras\AppliBundle\Entity\AgentRepository")
 * @ORM\Table(name="Agent")
 * @ORM\HasLifecycleCallbacks
 */

 class Agent
{
    /**
     * @ORM\id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @see : http://www.doctrine-project.org/docs/orm/2.0/en/reference/basic-mapping.html#identifier-generation-strategies
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=8)
     */
     protected $matricule;

    /**
     * @ORM\Column(type="string", length=4)
     */
     protected $civilite;

    /**
     * @ORM\Column(type="string", length=40)
     */
     protected $nom;

    /**
     * @ORM\Column(type="string", length=40)
     */
     protected $prenom;

    /**
     * @ORM\Column(type="string", length=101)
     */
     protected $structuremetiernom;

    /**
     * @ORM\Column(type="string", length=51)
     */
     protected $mail;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
     protected $tel;

    /**
     * @ORM\Column(type="string", length=151)
     */
     protected $localisationnom;

    /**
     * @ORM\Column(type="string", length=26, nullable=true)
     */
     protected $categorie;

    /**
     * @ORM\Column(type="string", length=41)
     */
     protected $statut;

    /**
     * @var DateTime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $created_at;

    /**
     * @var DateTime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    protected $updated_at;

    /**
     * @var DateTime $deleted_at
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deleted_at;

     /**
     * Consturcts a new instance of Role.
     */

    /** @ORM\PrePersist */
    public function PrePersist()
    {
    }

    /** @ORM\PostRemove */
    public function PostRemove()
    {
         $this->deleted_at = new \DateTime();
    }

    /** @ORM\PreUpdate */
    public function PreUpdate()
    {
		$this->updatedAt = new \DateTime();
    }

	public function __construct() {
		$this->createdAt = new \DateTime();
	}
    /**
     * Get id
     *
     * @return bigint
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set matricule
     *
     * @param string $matricule
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
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
     * Set civilite
     *
     * @param string $civilite
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;
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
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
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
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
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
     * Set structuremetiernom
     *
     * @param string $structuremetiernom
     */
    public function setStructuremetiernom($structuremetiernom)
    {
        $this->structuremetiernom = $structuremetiernom;
    }

    /**
     * Get structuremetiernom
     *
     * @return string
     */
    public function getStructuremetiernom()
    {
        return $this->structuremetiernom;
    }

    /**
     * Set mail
     *
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
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

    /**
     * Set tel
     *
     * @param string $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set localisationnom
     *
     * @param string $localisationnom
     */
    public function setLocalisationnom($localisationnom)
    {
        $this->localisationnom = $localisationnom;
    }

    /**
     * Get localisationnom
     *
     * @return string
     */
    public function getLocalisationnom()
    {
        return $this->localisationnom;
    }

    /**
     * Set categorie
     *
     * @param string $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set statut
     *
     * @param string $statut
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
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
     * Get created_at
     *
     * @return datetime
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }

     /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set deleted_at
     *
     * @param datetime $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deleted_at = $deletedAt;
    }

    /**
     * Get deleted_at
     *
     * @return datetime
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }
}
