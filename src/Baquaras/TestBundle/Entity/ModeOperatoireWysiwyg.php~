<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModeOperatoireWysiwyg
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\ModeOperatoireWysiwygRepository")
 */
class ModeOperatoireWysiwyg
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
  
	private $precautions;
	
	private $preliminaire;
	
	private $installation;
	
	private $test;
	
	private $repriseexistant;
	
	private $arborescence;
	
	private $parameters;
	
   
    public function __construct()
    {
        
    }

	
	 
    public function setPrecautions($precautions)
    {
        $this->precautions = $precautions;

        return $this;
    }

   
    public function getPrecautions()
    {
        return $this->precautions;
    }

 
	 
    public function setPreliminaire($preliminaire)
    {
        $this->preliminaire = $preliminaire;

        return $this;
    }

	
    public function getPreliminaire()
    {
        return $this->preliminaire;
    }  
	
	
    public function setInstallation($installation)
    {
        $this->installation = $installation;

        return $this;
    }

   
   
    public function getInstallation()
    {
        return $this->installation;
    }  
	
	
	
    public function setTest($test)
    {
        $this->test = $test;

        return $this;
    }

	
    
    public function getTest()
    {
        return $this->test;
    }  
	
	
	
    public function setRepriseexistant($respriseexistant)
    {
        $this->respriseexistant= $respriseexistant;

        return $this;
    }

    
	
    public function getRepriseexistant()
    {
        return $this->repriseexistant;
    }  
	
	
    public function setArborescence($arborescence)
    {
        $this->arborescence = $arborescence;

        return $this;
    }

    
    public function getArborescence()
    {
        return $this->arborescence;
    }
	
	
	  public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    
    public function getParameters()
    {
        return $this->parameters;
    }
	

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
     * Add packages
     *
     * @param \Baquaras\TestBundle\Entity\Package $packages
     * @return ModeOperatoireWysiwyg
     */
    public function addPackage(\Baquaras\TestBundle\Entity\Package $packages)
    {
        $this->packages[] = $packages;

        return $this;
    }

    /**
     * Remove packages
     *
     * @param \Baquaras\TestBundle\Entity\Package $packages
     */
    public function removePackage(\Baquaras\TestBundle\Entity\Package $packages)
    {
        $this->packages->removeElement($packages);
    }

    /**
     * Get packages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPackages()
    {
        return $this->packages;
    }
}
