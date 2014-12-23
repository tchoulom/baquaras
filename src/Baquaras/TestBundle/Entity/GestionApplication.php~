<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GestionApplication
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Baquaras\TestBundle\Entity\GestionApplicationRepository")
 */
class GestionApplication
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
     * @ORM\Column(name="Liste_Postes_Installes", type="string", length=255, nullable=true)
     */
    private $listePostesInstalles;

    /**
     * @var string
     *
     * @ORM\Column(name="Postes_Pilotes_WSUS", type="string", length=255, nullable=true)
     */
    private $postesPilotesWSUS;

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
     * Set listePostesInstalles
     *
     * @param string $listePostesInstalles
     * @return GestionApplication
     */
    public function setListePostesInstalles($listePostesInstalles)
    {
        $this->listePostesInstalles = $listePostesInstalles;

        return $this;
    }

    /**
     * Get listePostesInstalles
     *
     * @return string 
     */
    public function getListePostesInstalles()
    {
        return $this->listePostesInstalles;
    }

    /**
     * Set postesPilotesWSUS
     *
     * @param string $postesPilotesWSUS
     * @return GestionApplication
     */
    public function setPostesPilotesWSUS($postesPilotesWSUS)
    {
        $this->postesPilotesWSUS = $postesPilotesWSUS;

        return $this;
    }

    /**
     * Get postesPilotesWSUS
     *
     * @return string 
     */
    public function getPostesPilotesWSUS()
    {
        return $this->postesPilotesWSUS;
    }
}
