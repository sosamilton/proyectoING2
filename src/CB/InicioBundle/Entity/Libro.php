<?php

namespace CB\InicioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Libro
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity("isbn")
 */
class Libro
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
     * @var integer
     *
     * @ORM\Column(name="isbn", type="integer", unique=true)
     */
    private $isbn;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="paginas", type="integer")
     */
    private $paginas;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=100)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=100)
     */
    private $imagen;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="idioma", type="string", length=30)
     */
    private $idioma;

    /**
     * @var string
     *
     * @ORM\Column(name="precio", type="decimal")
     */
    private $precio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="borrado", type="boolean")
     */
    private $borrado;
    
     /**
     * @var CB\InicioBundle\Entity\Editorial
     *
     * @ORM\ManyToOne(targetEntity="CB\InicioBundle\Entity\Editorial") 
     */
    private $editorial;
    
    /**
     * @var CB\InicioBundle\Entity\Autor
     *
     * @ORM\ManyToMany(targetEntity="CB\InicioBundle\Entity\Autor") 
     */
    private $autor;
    
    /**
     * @var CB\InicioBundle\Entity\Categoria
     *
     * @ORM\ManyToMany(targetEntity="CB\InicioBundle\Entity\Categoria") 
     */
    private $categoria;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->autor = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categoria = new \Doctrine\Common\Collections\ArrayCollection();
        $this->borrado = false;
        $this->fecha = new \DateTime();

    }

   
    
    public function __toString() {
        return $this->getTitulo();
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
     * Set isbn
     *
     * @param integer $isbn
     * @return Libro
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return integer 
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set paginas
     *
     * @param integer $paginas
     * @return Libro
     */
    public function setPaginas($paginas)
    {
        $this->paginas = $paginas;

        return $this;
    }

    /**
     * Get paginas
     *
     * @return integer 
     */
    public function getPaginas()
    {
        return $this->paginas;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Libro
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Libro
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string 
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Libro
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Libro
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set idioma
     *
     * @param string $idioma
     * @return Libro
     */
    public function setIdioma($idioma)
    {
        $this->idioma = $idioma;

        return $this;
    }

    /**
     * Get idioma
     *
     * @return string 
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * Set precio
     *
     * @param string $precio
     * @return Libro
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set borrado
     *
     * @param boolean $borrado
     * @return Libro
     */
    public function setBorrado($borrado)
    {
        $this->borrado = $borrado;

        return $this;
    }

    /**
     * Get borrado
     *
     * @return boolean 
     */
    public function getBorrado()
    {
        return $this->borrado;
    }

    /**
     * Set editorial
     *
     * @param \CB\InicioBundle\Entity\Editorial $editorial
     * @return Libro
     */
    public function setEditorial(\CB\InicioBundle\Entity\Editorial $editorial = null)
    {
        $this->editorial = $editorial;

        return $this;
    }

    /**
     * Get editorial
     *
     * @return \CB\InicioBundle\Entity\Editorial 
     */
    public function getEditorial()
    {
        return $this->editorial;
    }

    /**
     * Add autor
     *
     * @param \CB\InicioBundle\Entity\Autor $autor
     * @return Libro
     */
    public function addAutor(\CB\InicioBundle\Entity\Autor $autor)
    {
        $this->autor[] = $autor;

        return $this;
    }

    /**
     * Remove autor
     *
     * @param \CB\InicioBundle\Entity\Autor $autor
     */
    public function removeAutor(\CB\InicioBundle\Entity\Autor $autor)
    {
        $this->autor->removeElement($autor);
    }

    /**
     * Get autor
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Add categoria
     *
     * @param \CB\InicioBundle\Entity\Categoria $categoria
     * @return Libro
     */
    public function addCategoria(\CB\InicioBundle\Entity\Categoria $categoria)
    {
        $this->categoria[] = $categoria;

        return $this;
    }

    /**
     * Remove categoria
     *
     * @param \CB\InicioBundle\Entity\Categoria $categoria
     */
    public function removeCategoria(\CB\InicioBundle\Entity\Categoria $categoria)
    {
        $this->categoria->removeElement($categoria);
    }

    /**
     * Get categoria
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
}
