<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * CatalogueSIT
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\CatalogueSITRepository")
 */
class CatalogueSIT
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
     * @ORM\Column(name="Reference_Application", type="string", length=255, nullable=true)
     */
    private $referenceApplication;

    /**
     * @var string
     *
     * @ORM\Column(name="Usage_Application", type="string", length=255, nullable=true)
     */
    private $usageApplication;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Mise_En_Ligne_Application", type="datetime", nullable=true)
     */
    private $dateMiseEnLigneApplication;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Fin_De_Vie_Application", type="datetime", nullable=true)
     */
    private $dateFinDeVieApplication;

    /**
     * @var string
     *
     * @ORM\Column(name="Type_Catalogue", type="string", length=255, nullable=true)
     */
    private $typeCatalogue;

    /**
     * @var string
     *
     * @ORM\Column(name="Version_Payee", type="string", length=255, nullable=true)
     */
    private $versionPayee;

    /**
     * @var string
     *
     * @ORM\Column(name="Cout", type="string", length=255, nullable=true)
     */
    private $cout;
	
	/**
     * @ORM\OneToOne(targetEntity="Fichier", cascade={"persist"})
     * @ORM\JoinColumn(name="docInfoComplementaire", referencedColumnName="id", nullable=true)
     **/
    private $docInfoComplementaire;

    	
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
     * Set referenceApplication
     *
     * @param string $referenceApplication
     * @return CatalogueSIT
     */
    public function setReferenceApplication($referenceApplication)
    {
        $this->referenceApplication = $referenceApplication;

        return $this;
    }

    /**
     * Get referenceApplication
     *
     * @return string 
     */
    public function getReferenceApplication()
    {
        return $this->referenceApplication;
    }

    /**
     * Set usageApplication
     *
     * @param string $usageApplication
     * @return CatalogueSIT
     */
    public function setUsageApplication($usageApplication)
    {
        $this->usageApplication = $usageApplication;

        return $this;
    }

    /**
     * Get usageApplication
     *
     * @return string 
     */
    public function getUsageApplication()
    {
        return $this->usageApplication;
    }
	
	/**
     * Set dateMiseEnLigneApplication
     *
     * @param \DateTime $dateMiseEnLigneApplication
     * @return CatalogueSIT
     */
    public function setDateMiseEnLigneApplication($dateMiseEnLigneApplication)
    {
        $this->dateMiseEnLigneApplication = $dateMiseEnLigneApplication;

        return $this;
    }

    /**
     * Get dateMiseEnLigneApplication
     *
     * @return \DateTime 
     */
    public function getDateMiseEnLigneApplication()
    {
        return $this->dateMiseEnLigneApplication;
    }

    /**
     * Set dateFinDeVieApplication
     *
     * @param \DateTime $dateFinDeVieApplication
     * @return CatalogueSIT
     */
    public function setDateFinDeVieApplication($dateFinDeVieApplication)
    {
        $this->dateFinDeVieApplication = $dateFinDeVieApplication;

        return $this;
    }

    /**
     * Get dateFinDeVieApplication
     *
     * @return \DateTime 
     */
    public function getDateFinDeVieApplication()
    {
        return $this->dateFinDeVieApplication;
    }

    /**
     * Set typeCatalogue
     *
     * @param string $typeCatalogue
     * @return CatalogueSIT
     */
    public function setTypeCatalogue($typeCatalogue)
    {
        $this->typeCatalogue = $typeCatalogue;

        return $this;
    }

    /**
     * Get typeCatalogue
     *
     * @return string 
     */
    public function getTypeCatalogue()
    {
        return $this->typeCatalogue;
    }

    /**
     * Set versionPayee
     *
     * @param string $versionPayee
     * @return CatalogueSIT
     */
    public function setVersionPayee($versionPayee)
    {
        $this->versionPayee = $versionPayee;

        return $this;
    }

    /**
     * Get versionPayee
     *
     * @return string 
     */
    public function getVersionPayee()
    {
        return $this->versionPayee;
    }

    /**
     * Set cout
     *
     * @param string $cout
     * @return CatalogueSIT
     */
    public function setCout($cout)
    {
        $this->cout = $cout;

        return $this;
    }

    /**
     * Get cout
     *
     * @return string 
     */
    public function getCout()
    {
        return $this->cout;
    }

    /**
     * Set docInfoComplementaire
     *
     * @param \Baquaras\TestBundle\Entity\CatalogueSIT $docInfoComplementaire
     * @return CatalogueSIT
     */
    public function setDocInfoComplementaire(\Baquaras\TestBundle\Entity\Fichier $docInfoComplementaire = null)
    {
        $this->docInfoComplementaire = $docInfoComplementaire;

        return $this;
    }

    /**
     * Get docInfoComplementaire
     *
     * @return \Baquaras\TestBundle\Entity\Fichier 
     */
    public function getDocInfoComplementaire()
    {
        return $this->docInfoComplementaire;
    }
}
