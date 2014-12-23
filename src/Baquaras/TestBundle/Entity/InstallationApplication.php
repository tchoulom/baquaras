<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InstallationApplication
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\InstallationApplicationRepository")
 */
class InstallationApplication
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
     * @var boolean
     *
     * @ORM\Column(name="Comptabilisation_License", type="boolean", nullable=true)
     */
    private $comptabilisationLicense;

    /**
     * @var integer
     *
     * @ORM\Column(name="Nombre_Licenses", type="integer", nullable=true)
     */
    private $nombreLicenses;

    /**
     * @var string
     *
     * @ORM\Column(name="Modalite_Acquisition", type="string", length=255, nullable=true)
     */
    private $modaliteAcquisition;

    /**
     * @var string
     *
     * @ORM\Column(name="Mode_Installation_Souhaitee", type="string", length=255, nullable=true)
     */
    private $modeInstallationSouhaitee;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Installation_A_Distance", type="boolean", nullable=true)
     */
    private $installationADistance;

    /**
     * @ORM\OneToOne(targetEntity="Application")
     * @ORM\JoinColumn(name="Application", referencedColumnName="id")
     **/
    /*private $application;*/

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
     * Set comptabilisationLicense
     *
     * @param boolean $comptabilisationLicense
     * @return InstallationApplication
     */
    public function setComptabilisationLicense($comptabilisationLicense)
    {
        $this->comptabilisationLicense = $comptabilisationLicense;

        return $this;
    }

    /**
     * Get comptabilisationLicense
     *
     * @return boolean 
     */
    public function getComptabilisationLicense()
    {
        return $this->comptabilisationLicense;
    }

    /**
     * Set nombreLicenses
     *
     * @param integer $nombreLicenses
     * @return InstallationApplication
     */
    public function setNombreLicenses($nombreLicenses)
    {
        $this->nombreLicenses = $nombreLicenses;

        return $this;
    }

    /**
     * Get nombreLicenses
     *
     * @return integer 
     */
    public function getNombreLicenses()
    {
        return $this->nombreLicenses;
    }

    /**
     * Set modaliteAcquisition
     *
     * @param string $modaliteAcquisition
     * @return InstallationApplication
     */
    public function setModaliteAcquisition($modaliteAcquisition)
    {
        $this->modaliteAcquisition = $modaliteAcquisition;

        return $this;
    }

    /**
     * Get modaliteAcquisition
     *
     * @return string 
     */
    public function getModaliteAcquisition()
    {
        return $this->modaliteAcquisition;
    }

    /**
     * Set modeInstallationSouhaitee
     *
     * @param string $modeInstallationSouhaitee
     * @return InstallationApplication
     */
    public function setModeInstallationSouhaitee($modeInstallationSouhaitee)
    {
        $this->modeInstallationSouhaitee = $modeInstallationSouhaitee;

        return $this;
    }

    /**
     * Get modeInstallationSouhaitee
     *
     * @return string 
     */
    public function getModeInstallationSouhaitee()
    {
        return $this->modeInstallationSouhaitee;
    }

    /**
     * Set installationADistance
     *
     * @param boolean $installationADistance
     * @return InstallationApplication
     */
    public function setInstallationADistance($installationADistance)
    {
        $this->installationADistance = $installationADistance;

        return $this;
    }

    /**
     * Get installationADistance
     *
     * @return boolean 
     */
    public function getInstallationADistance()
    {
        return $this->installationADistance;
    }
}
