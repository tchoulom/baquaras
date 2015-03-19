<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Fichier
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Fichier
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
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;
	
    private $fichier;
    
   /**
     * @var string
     *
     * @ORM\Column(name="fileName", type="string", length=255, nullable=true)
     */
    private $fileName;


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
     * Set url
     *
     * @param string $url
     * @return Fichier
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

	public function getFichier()
	{
		return $this->fichier;
	}

	public function setFichier(UploadedFile $fichier = null)
	{
		$this->fichier = $fichier;
	}
	
	/*
	 * Méthode d'upload du fichier 
	 */
	public function upload()
	{
		// Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
		if (null === $this->fichier) 
			return;
		$extension = $this->fichier->guessExtension();
		if (!$extension) 
			$extension = 'bin';
		// on génére un nom de fichier aléatoire
		$name = rand(1, 99999).'.'.$extension;
		$this->setUrl($name);
		$this->fichier->move($this->getUploadRootDir(), $name);
	}

	public function getUploadDir()
	{
		return 'uploads';
	}

	public function getUploadRootDir()
	{
		return __DIR__.'/../../../../web/'.$this->getUploadDir();
	}
        
        /**
        * Set url
        *
        * @param string $fileName
        * @return Fichier
        */
       public function setFileName($fileName)
       {
           $this->fileName = $fileName;

           return $this;
       }

       /**
        * Get fileName
        *
        * @return string 
        */
       public function getFileName()
       {
           return $this->fileName;
       }
       public function getOriginalFileName()
       {
           //return $this->fileName;
           if (null === $this->fichier) 
                return;
           $fileName = $this->fichier->getClientOriginalName();// On récupère le nom original du fichier
           return $fileName;
       }
       
      /*  public function getFileName()
       {
            $fileName = $this->fichier->getClientOriginalName();// On récupère le nom original du fichier
       }*/
}
