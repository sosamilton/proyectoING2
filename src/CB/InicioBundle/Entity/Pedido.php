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
     * @ORM\Column(name="Fecha", type="datetime")
     */
    private $fecha;

    
     /**
     * @var CB\InicioBundle\Entity\Estado
     * @ORM\ManyToOne(targetEntity="CB\InicioBundle\Entity\Estado")
     * @ORM\JoinColumn(name="Estado", referencedColumnName="id", nullable=false) 
     */
    private $estado;

    /**
     * @var CB\InicioBundle\Entity\Direccion
     *
     * @ORM\ManyToOne(targetEntity="CB\InicioBundle\Entity\Direccion")
     * @ORM\JoinColumn(name="Direccion", referencedColumnName="id", nullable=false) 
     */
    private $direccion;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CB\InicioBundle\Entity\Elemento")
     */
    private $elementos;

    /**
     * @var CB\InicioBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="CB\InicioBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="Usuario", referencedColumnName="id", nullable=false) 
     */
    private $usuario;
    
    
    /**
     * @var CB\InicioBundle\Entity\Tarjeta
     *
     * @ORM\ManyToOne(targetEntity="CB\InicioBundle\Entity\Tarjeta")
     * @ORM\JoinColumn(name="Tarjeta", referencedColumnName="id", nullable=true) 

     */
    private $tarjeta;
    
    
    public function __construct()
    {
        $this->elementos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \CB\InicioBundle\Entity\Estado $estado
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
     * @return \CB\InicioBundle\Entity\Estado 
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
    public function setDireccion($direccion)
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
     * Set elementos
     *
     * @param \CB\InicioBundle\Entity\Elemento $elementos
     * @return Pedido
     */
    public function setElementos($elementos)
    {
        $this->elementos = $elementos;

        return $this;
    }

    /**
     * Get elementos
     *
     * @return \Doctrine\Common\Collections\ArrayCollection 
     */
    public function getElementos()
    {
        return $this->elementos;
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
     * Add elementos
     *
     * @param \CB\InicioBundle\Entity\Elemento $elementos
     * @return Pedido
     */
    public function addElemento(\CB\InicioBundle\Entity\Elemento $elementos)
    {
        $this->elementos[] = $elementos;

        return $this;
    }

    /**
     * Remove elementos
     *
     * @param \CB\InicioBundle\Entity\Elemento $elementos
     */
    public function removeElemento(\CB\InicioBundle\Entity\Elemento $elementos)
    {
        $this->elementos->removeElement($elementos);
    }

    /**
     * Set tarjeta
     *
     * @param \CB\InicioBundle\Entity\Tarjeta $tarjeta
     * @return Pedido
     */
    public function setTarjeta(\CB\InicioBundle\Entity\Tarjeta $tarjeta = null)
    {
        $this->tarjeta = $tarjeta;

        return $this;
    }

    /**
     * Get tarjeta
     *
     * @return \CB\InicioBundle\Entity\Tarjeta 
     */
    public function getTarjeta()
    {
        return $this->tarjeta;
    }
}
