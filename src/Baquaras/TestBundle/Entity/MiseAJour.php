<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MiseAJour
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\MiseAJourRepository")
 */
class MiseAJour
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
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="type", referencedColumnName="id")
	 * @Assert\NotBlank (message = "Veuillez sélectionner le type de la mise à jour")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="Version", type="string", length=255)
	 * @Assert\NotBlank (message = "Veuillez indiquer la version de la mise à jour")
     */
    private $version;

    /**
     * @var string
     *
     * @ORM\Column(name="Indice", type="string", length=255)
	 * @Assert\NotBlank (message = "Veuillez renseigner l\'indice de la mise à jour")
     */
    private $indice;

    /**
     * @var string
     *
     * @ORM\Column(name="Statut_Patch", type="string", length=255, nullable=true)
     */
    private $statutPatch;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=2000, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Demande_MAJ", type="datetime", nullable=true)
     */
    private $dateDemandeMAJ;

    /**
     * @var string
     *
     * @ORM\Column(name="Documentation_Technique", type="string", length=255, nullable=true)
     * @Assert\File(maxSize="6000000") 
     */
    private $documentationTechnique;

    /**
     * @var string
     *
     * @ORM\Column(name="Commentaire", type="string", length=2000, nullable=true)
     */
    private $commentaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Mise_En_Prod_MAJ", type="datetime", nullable=true)
     */
    private $dateMiseEnProdMAJ;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_Publication_Patch", type="string", length=255)
	 * @Assert\NotBlank (message = "Veuillez indiquer le nom de publication du patch")
     */
    private $nomPublicationPatch;

    /**
     * @var string
     *
     * @ORM\Column(name="Ligne_Commande_Patch_Teledistribution", type="string", length=255)
	 * @Assert\NotBlank (message = "Veuillez indiquer la ligne de commande patch télédistribution")
     */
    private $ligneCommandePatchTeledistribution;

    /**
     * @var string
     *
     * @ORM\Column(name="Ligne_Commande_Patch_Publication", type="string", length=255)
	 * @Assert\NotBlank (message = "Veuillez indiquer la ligne de commande patch publication")
     */
    private $ligneCommandePatchPublication;

    /**
     * @var string
     *
     * @ORM\Column(name="Chemin_Patch", type="string", length=255, nullable=true)
     */
    private $cheminPatch;
	
 	/**
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="oscible", referencedColumnName="id")
     * @Assert\NotBlank (message = "Veuillez sélectionner un système d'exploitation")
     */
    private $oscible;
	
    /**
     * @ORM\ManyToOne(targetEntity="Application", inversedBy="misesajour")
     * @ORM\JoinColumn(name="application", referencedColumnName="id")
     **/
    private $application;
	
	 /**
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="misesajour")
     * @ORM\JoinColumn(name="Personne_chargee_MAJ", referencedColumnName="id")
     **/
    private $personneChargeeMAJ;
	
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
     * Set version
     *
     * @param string $version
     * @return MiseAJour
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set indice
     *
     * @param string $indice
     * @return MiseAJour
     */
    public function setIndice($indice)
    {
        $this->indice = $indice;

        return $this;
    }

    /**
     * Get indice
     *
     * @return string 
     */
    public function getIndice()
    {
        return $this->indice;
    }

    /**
     * Set statutPatch
     *
     * @param string $statutPatch
     * @return MiseAJour
     */
    public function setStatutPatch($statutPatch)
    {
        $this->statutPatch = $statutPatch;

        return $this;
    }

    /**
     * Get statutPatch
     *
     * @return string 
     */
    public function getStatutPatch()
    {
        return $this->statutPatch;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return MiseAJour
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateDemandeMAJ
     *
     * @param \DateTime $dateDemandeMAJ
     * @return MiseAJour
     */
    public function setDateDemandeMAJ($dateDemandeMAJ)
    {
        $this->dateDemandeMAJ = $dateDemandeMAJ;

        return $this;
    }

    /**
     * Get dateDemandeMAJ
     *
     * @return \DateTime 
     */
    public function getDateDemandeMAJ()
    {
        return $this->dateDemandeMAJ;
    }

    /**
     * Set documentationTechnique
     *
     * @param string $documentationTechnique
     * @return MiseAJour
     */
    public function setDocumentationTechnique($documentationTechnique)
    {
        $this->documentationTechnique = $documentationTechnique;

        return $this;
    }

    /**
     * Get documentationTechnique
     *
     * @return string 
     */
    public function getDocumentationTechnique()
    {
        return $this->documentationTechnique;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return MiseAJour
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
     * Set dateMiseEnProdMAJ
     *
     * @param \DateTime $dateMiseEnProdMAJ
     * @return MiseAJour
     */
    public function setDateMiseEnProdMAJ($dateMiseEnProdMAJ)
    {
        $this->dateMiseEnProdMAJ = $dateMiseEnProdMAJ;

        return $this;
    }

    /**
     * Get dateMiseEnProdMAJ
     *
     * @return \DateTime 
     */
    public function getDateMiseEnProdMAJ()
    {
        return $this->dateMiseEnProdMAJ;
    }

    /**
     * Set nomPublicationPatch
     *
     * @param string $nomPublicationPatch
     * @return MiseAJour
     */
    public function setNomPublicationPatch($nomPublicationPatch)
    {
        $this->nomPublicationPatch = $nomPublicationPatch;

        return $this;
    }

    /**
     * Get nomPublicationPatch
     *
     * @return string 
     */
    public function getNomPublicationPatch()
    {
        return $this->nomPublicationPatch;
    }

    /**
     * Set ligneCommandePatchTeledistribution
     *
     * @param string $ligneCommandePatchTeledistribution
     * @return MiseAJour
     */
    public function setLigneCommandePatchTeledistribution($ligneCommandePatchTeledistribution)
    {
        $this->ligneCommandePatchTeledistribution = $ligneCommandePatchTeledistribution;

        return $this;
    }

    /**
     * Get ligneCommandePatchTeledistribution
     *
     * @return string 
     */
    public function getLigneCommandePatchTeledistribution()
    {
        return $this->ligneCommandePatchTeledistribution;
    }

    /**
     * Set ligneCommandePatchPublication
     *
     * @param string $ligneCommandePatchPublication
     * @return MiseAJour
     */
    public function setLigneCommandePatchPublication($ligneCommandePatchPublication)
    {
        $this->ligneCommandePatchPublication = $ligneCommandePatchPublication;

        return $this;
    }

    /**
     * Get ligneCommandePatchPublication
     *
     * @return string 
     */
    public function getLigneCommandePatchPublication()
    {
        return $this->ligneCommandePatchPublication;
    }

    /**
     * Set cheminPatch
     *
     * @param string $cheminPatch
     * @return MiseAJour
     */
    public function setCheminPatch($cheminPatch)
    {
        $this->cheminPatch = $cheminPatch;

        return $this;
    }

    /**
     * Get cheminPatch
     *
     * @return string 
     */
    public function getCheminPatch()
    {
        return $this->cheminPatch;
    }

    /**
     * Set application
     *
     * @param \Baquaras\TestBundle\Entity\Application $application
     * @return MiseAJour
     */
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
     * Set personneChargeeMAJ
     *
     * @param \Baquaras\TestBundle\Entity\Utilisateur $personneChargeeMAJ
     * @return MiseAJour
     */
    public function setPersonneChargeeMAJ(\Baquaras\TestBundle\Entity\Utilisateur $personneChargeeMAJ = null)
    {
        $this->personneChargeeMAJ = $personneChargeeMAJ;

        return $this;
    }

    /**
     * Get personneChargeeMAJ
     *
     * @return \Baquaras\TestBundle\Entity\Utilisateur 
     */
    public function getPersonneChargeeMAJ()
    {
        return $this->personneChargeeMAJ;
    }

    /**
     * Set type
     *
     * @param \Baquaras\TestBundle\Entity\Item $type
     * @return MiseAJour
     */
    public function setType(\Baquaras\TestBundle\Entity\Item $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Baquaras\TestBundle\Entity\Item 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set oscible
     *
     * @param \Baquaras\TestBundle\Entity\Item $oscible
     * @return MiseAJour
     */
    public function setOscible(\Baquaras\TestBundle\Entity\Item $oscible = null)
    {
        $this->oscible = $oscible;

        return $this;
    }

    /**
     * Get oscible
     *
     * @return \Baquaras\TestBundle\Entity\Item 
     */
    public function getOscible()
    {
        return $this->oscible;
    }
}
