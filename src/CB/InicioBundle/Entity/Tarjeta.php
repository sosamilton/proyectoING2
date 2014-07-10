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
     *
     * @ORM\ManyToOne(targetEntity="CB\InicioBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="Usuario", referencedColumnName="id", nullable=false) 
     */
    private $usuario;
    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=5, nullable=true)
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
     * @ORM\Column(name="vencimiento", type="string", length=7, nullable=false)
     */
    private $vencimiento;

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
     * @var boolean
     *
     * @ORM\Column(name="noTieneCod", type="boolean", nullable=true)
     */
    private $noTieneCod;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

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
     * Set vencimiento
     *
     * @param string $fecha
     * @return Tarjeta
     */
    public function setVencimiento($fecha)
    {
        $this->vencimiento = $fecha;

        return $this;
    }

    /**
     * Get vencimiento
     *
     * @return string 
     */
    public function getVencimiento()
    {
        return $this->vencimiento;
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
     * Set usuario
     *
     * @param \CB\InicioBundle\Entity\Usuario $usuario
     * @return Tarjeta
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
     * Set noTieneCod
     *
     * @param boolean $valor
     * @return Tarjeta
     */
    public function setNoTieneCod($valor)
    {
        $this->noTieneCod = $valor;

        return $this;
    }

    /**
     * Get noTieneCod
     *
     * @return boolean 
     */
    public function getNoTieneCod()
    {
        return $this->noTieneCod;
    }
    
    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Tarjeta
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

    
    public function __toString() {
        $numero=$this->getNumero();
        $cant=strlen($numero);
        $cant=$cant-5;
        for( $i=0; $i <= $cant; $i++){
        $numero{$i}='*';
        }
        $text =$this->getTipoTarjeta().' - '.$numero;
        return $text;
    }
}
