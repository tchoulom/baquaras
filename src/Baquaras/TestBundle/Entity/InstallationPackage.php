<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InstallationPackage
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\InstallationPackageRepository")
 */
class InstallationPackage
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
     * @ORM\Column(name="Repertoire_Installation_Application", type="string", length=255, nullable=true)
     */
    private $repertoireInstallationApplication;

    /**
     * @var string
     *
     * @ORM\Column(name="Repertoire_Installation_Donnees", type="string", length=255, nullable=true)
     */
    private $repertoireInstallationDonnees;

    /**
     * @var string
     *
     * @ORM\Column(name="Ports_Ouverts_Distants", type="string", length=255, nullable=true)
     */
    private $portsOuvertsDistants;

    /**
     * @var string
     *
     * @ORM\Column(name="Ports_Ouverts_Locaux", type="string", length=255, nullable=true)
     */
    private $portsOuvertsLocaux;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Package_Virtualise", type="boolean", nullable=true)
     */
    private $packageVirtualise;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Connection_Group", type="boolean", nullable=true)
     */
    private $connectionGroup;

    /**
     * @var string
     *
     * @ORM\Column(name="Version_AppV_XP", type="string", length=255, nullable=true)
     */
    private $versionAppVXP;

    /**
     * @var string
     *
     * @ORM\Column(name="Version_AppV_W7", type="string", length=255, nullable=true)
     */
    private $versionAppVW7;
	
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
     * Set repertoireInstallationApplication
     *
     * @param string $repertoireInstallationApplication
     * @return InstallationPackage
     */
    public function setRepertoireInstallationApplication($repertoireInstallationApplication)
    {
        $this->repertoireInstallationApplication = $repertoireInstallationApplication;

        return $this;
    }

    /**
     * Get repertoireInstallationApplication
     *
     * @return string 
     */
    public function getRepertoireInstallationApplication()
    {
        return $this->repertoireInstallationApplication;
    }

    /**
     * Set repertoireInstallationDonnees
     *
     * @param string $repertoireInstallationDonnees
     * @return InstallationPackage
     */
    public function setRepertoireInstallationDonnees($repertoireInstallationDonnees)
    {
        $this->repertoireInstallationDonnees = $repertoireInstallationDonnees;

        return $this;
    }

    /**
     * Get repertoireInstallationDonnees
     *
     * @return string 
     */
    public function getRepertoireInstallationDonnees()
    {
        return $this->repertoireInstallationDonnees;
    }

    /**
     * Set portsOuvertsDistants
     *
     * @param string $portsOuvertsDistants
     * @return InstallationPackage
     */
    public function setPortsOuvertsDistants($portsOuvertsDistants)
    {
        $this->portsOuvertsDistants = $portsOuvertsDistants;

        return $this;
    }

    /**
     * Get portsOuvertsDistants
     *
     * @return string 
     */
    public function getPortsOuvertsDistants()
    {
        return $this->portsOuvertsDistants;
    }

    /**
     * Set portsOuvertsLocaux
     *
     * @param string $portsOuvertsLocaux
     * @return InstallationPackage
     */
    public function setPortsOuvertsLocaux($portsOuvertsLocaux)
    {
        $this->portsOuvertsLocaux = $portsOuvertsLocaux;

        return $this;
    }

    /**
     * Get portsOuvertsLocaux
     *
     * @return string 
     */
    public function getPortsOuvertsLocaux()
    {
        return $this->portsOuvertsLocaux;
    }

    /**
     * Set packageVirtualise
     *
     * @param boolean $packageVirtualise
     * @return InstallationPackage
     */
    public function setPackageVirtualise($packageVirtualise)
    {
        $this->packageVirtualise = $packageVirtualise;

        return $this;
    }

    /**
     * Get packageVirtualise
     *
     * @return boolean 
     */
    public function getPackageVirtualise()
    {
        return $this->packageVirtualise;
    }

    /**
     * Set versionAppVXP
     *
     * @param string $versionAppVXP
     * @return InstallationPackage
     */
    public function setVersionAppVXP($versionAppVXP)
    {
        $this->versionAppVXP = $versionAppVXP;

        return $this;
    }

    /**
     * Get versionAppVXP
     *
     * @return string 
     */
    public function getVersionAppVXP()
    {
        return $this->versionAppVXP;
    }

    /**
     * Set versionAppVW7
     *
     * @param string $versionAppVW7
     * @return InstallationPackage
     */
    public function setVersionAppVW7($versionAppVW7)
    {
        $this->versionAppVW7 = $versionAppVW7;

        return $this;
    }

    /**
     * Get versionAppVW7
     *
     * @return string 
     */
    public function getVersionAppVW7()
    {
        return $this->versionAppVW7;
    }

    /**
     * Set connectionGroup
     *
     * @param boolean $connectionGroup
     * @return InstallationPackage
     */
    public function setConnectionGroup($connectionGroup)
    {
        $this->connectionGroup = $connectionGroup;

        return $this;
    }

    /**
     * Get connectionGroup
     *
     * @return boolean 
     */
    public function getConnectionGroup()
    {
        return $this->connectionGroup;
    }
}
