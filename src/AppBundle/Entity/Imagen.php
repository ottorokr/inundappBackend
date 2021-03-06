<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Imagen
 */
class Imagen
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $idEvento;

      public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
      //Este web path es el que usamos en el template para linkear a la imagen
        return null === $this->path
            ? null
            : '~inundapp/inundapp/web/'.$this->getUploadDir().$this->path;
    }

    protected function getUploadRootDir()
    {
        //Este es el path absoluto donde se guardan las fotos
        #return '/home/www-users/inundapp/public_html/inundapp/web/'.$this->getUploadDir();
    return realpath('./../../../web/').$this->getUploadDir();
	}

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'images/uploads/';
    }

     public function upload($data)
    {
   
    // use the original file name here but you should
    // sanitize it at least to avoid any security issues

    $extension = 'jpg'; //Seteo extension default

    //Construyo el path para la imagen
     $path_recuperado = rand(1, 999999).'.'.$extension;
      
     //Esta función es idéntica que llamar a fopen(), fwrite() y fclose() sucesivamente para escribir información en un fichero.
    //Si filename no existe, se crea el fichero. De otro modo, el fichero existente se sobrescribe, a menos que la bandera FILE_APPEND esté establecida. 
    //No se puede calcular la extension

     //LO IDEAL SERIA CONTROLAR ESTAS PROPIEDADES DE LA IMAGEN SUBIDA

    //**
    // * @Assert\File(maxSize="6000000")
    // * @Assert\Image(
    // *     allowLandscape = false,
    // *     allowPortrait = false
    // * )
    // */

    //devuelve el número de bytes que fueron escritos en el fichero, o FALSE en caso de error. 
    $resultado = file_put_contents($this->getUploadRootDir().$path_recuperado, $data);

    //Seteo el path del filename donde guardo la imagen
    $this->path = $path_recuperado;

    return $resultado;
}
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idEvento = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Imagen
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
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
     * Add idEvento
     *
     * @param \AppBundle\Entity\Evento $idEvento
     * @return Imagen
     */
    public function addIdEvento(\AppBundle\Entity\Evento $idEvento)
    {
        $this->idEvento[] = $idEvento;

        return $this;
    }

    /**
     * Remove idEvento
     *
     * @param \AppBundle\Entity\Evento $idEvento
     */
    public function removeIdEvento(\AppBundle\Entity\Evento $idEvento)
    {
        $this->idEvento->removeElement($idEvento);
    }

    /**
     * Get idEvento
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdEvento()
    {
        return $this->idEvento;
    }

}
