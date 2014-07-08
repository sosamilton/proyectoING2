<?php

namespace CB\InicioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tarjeta
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Tarjeta
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
     * @ORM\Column(name="numero", type="string", length=17)
     */
    private $numero;

    /**
     * @var CB\InicioBundle\Entity\TipoTarjeta
     * @ORM\ManyToOne(targetEntity="CB\InicioBundle\Entity\TipoTarjeta")
     */
    private $tipoTarjeta;
    
    /**
     * @var CB\InicioBundle\Entity\Usuario
     * @ORM\ManyToMany(targetEntity="CB\InicioBundle\Entity\Usuario")
     */
    private $usuario;
    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=5)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=100)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=10)
     */
    private $dni;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuario = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set numero
     *
     * @param string $numero
     * @return Tarjeta
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Tarjeta
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Tarjeta
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Tarjeta
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set dni
     *
     * @param string $dni
     * @return Tarjeta
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string 
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set tipoTarjeta
     *
     * @param \CB\InicioBundle\Entity\TipoTarjeta $tipoTarjeta
     * @return Tarjeta
     */
    public function setTipoTarjeta(\CB\InicioBundle\Entity\TipoTarjeta $tipoTarjeta = null)
    {
        $this->tipoTarjeta = $tipoTarjeta;

        return $this;
    }

    /**
     * Get tipoTarjeta
     *
     * @return \CB\InicioBundle\Entity\TipoTarjeta 
     */
    public function getTipoTarjeta()
    {
        return $this->tipoTarjeta;
    }

    /**
     * Add usuario
     *
     * @param \CB\InicioBundle\Entity\Usuario $usuario
     * @return Tarjeta
     */
    public function addUsuario(\CB\InicioBundle\Entity\Usuario $usuario)
    {
        $this->usuario[] = $usuario;

        return $this;
    }

    /**
     * Remove usuario
     *
     * @param \CB\InicioBundle\Entity\Usuario $usuario
     */
    public function removeUsuario(\CB\InicioBundle\Entity\Usuario $usuario)
    {
        $this->usuario->removeElement($usuario);
    }

    /**
     * Get usuario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    
    public function __toString() {
        
        return $this->getNumero();
    }
}
