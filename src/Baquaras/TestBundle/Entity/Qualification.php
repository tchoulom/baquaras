<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Qualification
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\QualificationRepository")
 */
class Qualification
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
     * @ORM\Column(name="Type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="Numero_Lot", type="string", length=255, nullable=true)
     */
    private $numeroLot;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Demarrage_Packaging", type="datetime", nullable=true)
     */
    private $dateDemarragePackaging;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Recette_Standardisation", type="datetime", nullable=true)
     */
    private $dateRecetteStandardisation;
	
	/**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Recette_Conformite", type="datetime", nullable=true)
     */
    private $dateRecetteConformite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Mise_En_Service_Souhaitee", type="datetime", nullable=true)
     */
    private $dateMiseEnServiceSouhaitee;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Production_Qualification", type="datetime", nullable=true)
     */
    private $dateProductionQualification;
	
	/**
     * @var string
     *
     * @ORM\Column(name="Agent_PreQualif", type="string", length=1000, nullable=true)
     */
    private $agentPreQualif;

    /**
     * @var string
     *
     * @ORM\Column(name="PV_Prequalification", type="string", length=1000, nullable=true)
     */
    private $pVPrequalification;

    /**
     * @var string
     *
     * @ORM\Column(name="PV_Qualification", type="string", length=1000, nullable=true)
     */
    private $pVQualification;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_PV_Qualification", type="datetime", nullable=true)
     */
    private $datePVQualification;
	
	/**
     * @var string
     *
     * @ORM\Column(name="Agent_Qualif", type="string", length=1000, nullable=true)
     */
    private $agentQualif;
	
    /**
     * @var string
     *
     * @ORM\Column(name="Sous_Compte", type="string", length=255, nullable=true)
     */
    private $sousCompte;
		
	/**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=5000, nullable=true)
     */
    private $commentaire;
	
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
     * Set type
     *
     * @param string $type
     * @return Qualification
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set numeroLot
     *
     * @param string $numeroLot
     * @return Qualification
     */
    public function setNumeroLot($numeroLot)
    {
        $this->numeroLot = $numeroLot;

        return $this;
    }

    /**
     * Get numeroLot
     *
     * @return string 
     */
    public function getNumeroLot()
    {
        return $this->numeroLot;
    }

    /**
     * Set dateDemarragePackaging
     *
     * @param \DateTime $dateDemarragePackaging
     * @return Qualification
     */
    public function setDateDemarragePackaging($dateDemarragePackaging)
    {
        $this->dateDemarragePackaging = $dateDemarragePackaging;

        return $this;
    }

    /**
     * Get dateDemarragePackaging
     *
     * @return \DateTime 
     */
    public function getDateDemarragePackaging()
    {
        return $this->dateDemarragePackaging;
    }

    /**
     * Set dateRecetteStandardisation
     *
     * @param \DateTime $dateRecetteStandardisation
     * @return Qualification
     */
    public function setDateRecetteStandardisation($dateRecetteStandardisation)
    {
        $this->dateRecetteStandardisation = $dateRecetteStandardisation;

        return $this;
    }

    /**
     * Get dateRecetteStandardisation
     *
     * @return \DateTime 
     */
    public function getDateRecetteStandardisation()
    {
        return $this->dateRecetteStandardisation;
    }

    /**
     * Set dateMiseEnServiceSouhaitee
     *
     * @param \DateTime $dateMiseEnServiceSouhaitee
     * @return Qualification
     */
    public function setDateMiseEnServiceSouhaitee($dateMiseEnServiceSouhaitee)
    {
        $this->dateMiseEnServiceSouhaitee = $dateMiseEnServiceSouhaitee;

        return $this;
    }

    /**
     * Get dateMiseEnServiceSouhaitee
     *
     * @return \DateTime 
     */
    public function getDateMiseEnServiceSouhaitee()
    {
        return $this->dateMiseEnServiceSouhaitee;
    }

    /**
     * Set dateProductionQualification
     *
     * @param \DateTime $dateProductionQualification
     * @return Qualification
     */
    public function setDateProductionQualification($dateProductionQualification)
    {
        $this->dateProductionQualification = $dateProductionQualification;

        return $this;
    }

    /**
     * Get dateProductionQualification
     *
     * @return \DateTime 
     */
    public function getDateProductionQualification()
    {
        return $this->dateProductionQualification;
    }

    /**
     * Set pVPrequalification
     *
     * @param string $pVPrequalification
     * @return Qualification
     */
    public function setPVPrequalification($pVPrequalification)
    {
        $this->pVPrequalification = $pVPrequalification;

        return $this;
    }

    /**
     * Get pVPrequalification
     *
     * @return string 
     */
    public function getPVPrequalification()
    {
        return $this->pVPrequalification;
    }

    /**
     * Set pVQualification
     *
     * @param string $pVQualification
     * @return Qualification
     */
    public function setPVQualification($pVQualification)
    {
        $this->pVQualification = $pVQualification;

        return $this;
    }

    /**
     * Get pVQualification
     *
     * @return string 
     */
    public function getPVQualification()
    {
        return $this->pVQualification;
    }

    /**
     * Set datePVQualification
     *
     * @param \DateTime $datePVQualification
     * @return Qualification
     */
    public function setDatePVQualification($datePVQualification)
    {
        $this->datePVQualification = $datePVQualification;

        return $this;
    }

    /**
     * Get datePVQualification
     *
     * @return \DateTime 
     */
    public function getDatePVQualification()
    {
        return $this->datePVQualification;
    }

    /**
     * Set sousCompte
     *
     * @param string $sousCompte
     * @return Qualification
     */
    public function setSousCompte($sousCompte)
    {
        $this->sousCompte = $sousCompte;

        return $this;
    }

    /**
     * Get sousCompte
     *
     * @return string 
     */
    public function getSousCompte()
    {
        return $this->sousCompte;
    }

    /**
     * Set dateRecetteConformite
     *
     * @param \DateTime $dateRecetteConformite
     * @return Qualification
     */
    public function setDateRecetteConformite($dateRecetteConformite)
    {
        $this->dateRecetteConformite = $dateRecetteConformite;

        return $this;
    }

    /**
     * Get dateRecetteConformite
     *
     * @return \DateTime 
     */
    public function getDateRecetteConformite()
    {
        return $this->dateRecetteConformite;
    }

    /**
     * Set agentPreQualif
     *
     * @param string $agentPreQualif
     * @return Qualification
     */
    public function setAgentPreQualif($agentPreQualif)
    {
        $this->agentPreQualif = $agentPreQualif;

        return $this;
    }

    /**
     * Get agentPreQualif
     *
     * @return string 
     */
    public function getAgentPreQualif()
    {
        return $this->agentPreQualif;
    }

    /**
     * Set agentQualif
     *
     * @param string $agentQualif
     * @return Qualification
     */
    public function setAgentQualif($agentQualif)
    {
        $this->agentQualif = $agentQualif;

        return $this;
    }

    /**
     * Get agentQualif
     *
     * @return string 
     */
    public function getAgentQualif()
    {
        return $this->agentQualif;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return Qualification
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
}
