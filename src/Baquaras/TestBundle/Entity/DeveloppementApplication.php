<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DeveloppementApplication
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\DeveloppementApplicationRepository")
 */
class DeveloppementApplication
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Developpement_Specifique", type="boolean", nullable=true)
     */
    private $developpementSpecifique;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Appli_Avec_TMA", type="boolean", nullable=true)
     */
    private $appliAvecTMA;

    /**
     * @var string
     *
     * @ORM\Column(name="Outil_Developpement", type="string", length=255, nullable=true)
     */
    private $outilDeveloppement;

    /**
     * @var string
     *
     * @ORM\Column(name="Login_Compte_Test", type="string", length=255, nullable=true)
     */
    private $loginCompteTest;

    /**
     * @var string
     *
     * @ORM\Column(name="Password_Compte_Test", type="string", length=255, nullable=true)
     */
    private $passwordCompteTest;

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
     * Set developpementSpecifique
     *
     * @param boolean $developpementSpecifique
     * @return DeveloppementApplication
     */
    public function setDeveloppementSpecifique($developpementSpecifique)
    {
        $this->developpementSpecifique = $developpementSpecifique;

        return $this;
    }

    /**
     * Get developpementSpecifique
     *
     * @return boolean 
     */
    public function getDeveloppementSpecifique()
    {
        return $this->developpementSpecifique;
    }

    /**
     * Set appliAvecTMA
     *
     * @param boolean $appliAvecTMA
     * @return DeveloppementApplication
     */
    public function setAppliAvecTMA($appliAvecTMA)
    {
        $this->appliAvecTMA = $appliAvecTMA;

        return $this;
    }

    /**
     * Get appliAvecTMA
     *
     * @return boolean 
     */
    public function getAppliAvecTMA()
    {
        return $this->appliAvecTMA;
    }

    /**
     * Set outilDeveloppement
     *
     * @param string $outilDeveloppement
     * @return DeveloppementApplication
     */
    public function setOutilDeveloppement($outilDeveloppement)
    {
        $this->outilDeveloppement = $outilDeveloppement;

        return $this;
    }

    /**
     * Get outilDeveloppement
     *
     * @return string 
     */
    public function getOutilDeveloppement()
    {
        return $this->outilDeveloppement;
    }

    /**
     * Set loginCompteTest
     *
     * @param string $loginCompteTest
     * @return DeveloppementApplication
     */
    public function setLoginCompteTest($loginCompteTest)
    {
        $this->loginCompteTest = $loginCompteTest;

        return $this;
    }

    /**
     * Get loginCompteTest
     *
     * @return string 
     */
    public function getLoginCompteTest()
    {
        return $this->loginCompteTest;
    }

    /**
     * Set passwordCompteTest
     *
     * @param string $passwordCompteTest
     * @return DeveloppementApplication
     */
    public function setPasswordCompteTest($passwordCompteTest)
    {
        $this->passwordCompteTest = $passwordCompteTest;

        return $this;
    }

    /**
     * Get passwordCompteTest
     *
     * @return string 
     */
    public function getPasswordCompteTest()
    {
        return $this->passwordCompteTest;
    }
}
