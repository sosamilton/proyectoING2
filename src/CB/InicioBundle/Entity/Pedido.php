<?php

namespace CB\InicioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pedido
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Pedido
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var CB\InicioBundle\Entity\Estado
     *
     * @ORM\ManyToOne(targetEntity="CB\InicioBundle\Entity\Estado") 
     */
    private $estado;

    /**
     * @var CB\InicioBundle\Entity\Direccion
     *
     * @ORM\ManyToOne(targetEntity="CB\InicioBundle\Entity\Direccion")
     */
    private $direccion;

    /**
     * @var CB\InicioBundle\Entity\Libro
     *
     * @ORM\ManyToMany(targetEntity="CB\InicioBundle\Entity\Libro")
     */
    private $libros;

    /**
     * @var CB\InicioBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="CB\InicioBundle\Entity\Usuario")
     */
    private $usuario;
    
    public function __construct()
    {
        $this->libros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fecha = new \DateTime();
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Pedido
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
     * Set estado
     *
     * @param string $estado
     * @return Pedido
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set direccion
     *
     * @param \CB\InicioBundle\Entity\Direccion $direccion
     * @return Pedido
     */
    public function setDireccion(\CB\InicioBundle\Entity\Direccion $direccion = null)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return \CB\InicioBundle\Entity\Direccion 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set libros
     *
     * @param \CB\InicioBundle\Entity\Categoria $libros
     * @return Pedido
     */
    public function setLibros(\CB\InicioBundle\Entity\Categoria $libros = null)
    {
        $this->libros = $libros;

        return $this;
    }

    /**
     * Get libros
     *
     * @return \CB\InicioBundle\Entity\Categoria 
     */
    public function getLibros()
    {
        return $this->libros;
    }

    /**
     * Set usuario
     *
     * @param \CB\InicioBundle\Entity\Usuario $usuario
     * @return Pedido
     */
    public function setUsuario(\CB\InicioBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \CB\InicioBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Add libros
     *
     * @param \CB\InicioBundle\Entity\Libro $libros
     * @return Pedido
     */
    public function addLibro(\CB\InicioBundle\Entity\Libro $libros)
    {
        $this->libros[] = $libros;

        return $this;
    }

    /**
     * Remove libros
     *
     * @param \CB\InicioBundle\Entity\Libro $libros
     */
    public function removeLibro(\CB\InicioBundle\Entity\Libro $libros)
    {
        $this->libros->removeElement($libros);
    }
}
