<?php
/**
 * Entité qui contient les roles des utilisateurs de l'appli
 */
namespace Baquaras\AppliBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
class Role implements RoleInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string $name
     */
    protected $name;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     *
     * @var DateTime $createdAt
     */
    protected $createdAt;

     /**
     * @ORM\ManyToMany(targetEntity="\Baquaras\TestBundle\Entity\Utilisateur", mappedBy="role")
     */
    private $utilisateur;   //ET 03-03-2015

    /**
     * Gets the id.
     *
     * @return integer The id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the role name.
     *
     * @return string The name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the role name.
     *
     * @param string $value The name.
     */
    public function setName($value)
    {
        $this->name = $value;
    }

    /**
     * Gets the DateTime the role was created.
     *
     * @return DateTime A DateTime object.
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Consturcts a new instance of Role.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->utilisateur = new \Doctrine\Common\Collections\ArrayCollection();//ET 03-03-2015
    }

    /**
     * Implementation of getRole for the RoleInterface.
     *
     * @return string The role.
     */
    public function getRole()
    {
        return $this->getName();
    }

    /**
     * Fontion nécessaire au bon fonctionnement du CRUD généré par SonataAdminBundle
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    
     /*Begin ET 03-03-2015*/
    /**
     * Add utilisateur
     *
     * @param \Baquaras\TestBundle\Entity\ModificationApplication $utilisateur
     * @return Utilisateur
     */
    public function addUtilisateur(\Baquaras\TestBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur[] = $utilisateur;

        return $this;
    }

    /**
     * Remove utilisateur
     *
     * @param \Baquaras\TestBundle\Entity\Utilisateur $utilisateur
     */
    public function removeUtilisateur(\Baquaras\AppliBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur->removeElement($utilisateur);
    }

    /**
     * Get utilisateur
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
    /*End ET 03-03-2015*/
}
