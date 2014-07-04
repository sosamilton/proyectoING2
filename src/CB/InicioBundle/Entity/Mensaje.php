<?php

namespace CB\InicioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mensaje
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Mensaje
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
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="asunto", type="string", length=255)
     */
    private $asunto;

    /**
     * @var string
     *
     * @ORM\Column(name="contenido", type="text")
     */
    private $contenido;

    /**
     * @var boolean
     *
     * @ORM\Column(name="leido", type="boolean")
     */
    private $leido;
    
    /**
     * @var CB\InicioBundle\Entity\Usuario
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="Usuario", referencedColumnName="id", nullable=true) 
     */
    private $usuario;

        
    public function __construct() {
        $this->leido = false;
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
     * Set email
     *
     * @param string $email
     * @return Mensaje
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Mensaje
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
     * Set asunto
     *
     * @param string $asunto
     * @return Mensaje
     */
    public function setAsunto($asunto)
    {
        $this->asunto = $asunto;

        return $this;
    }

    /**
     * Get asunto
     *
     * @return string 
     */
    public function getAsunto()
    {
        return $this->asunto;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     * @return Mensaje
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string 
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set leido
     *
     * @param boolean $leido
     * @return Mensaje
     */
    public function setLeido($leido)
    {
        $this->leido = $leido;

        return $this;
    }

    /**
     * Get leido
     *
     * @return boolean 
     */
    public function getLeido()
    {
        return $this->leido;
    }
    
    /**
     * Set usuario
     *
     * @param \CB\InicioBundle\Entity\Usuario $usuario
     * @return Usuario
     */
    public function setUsuario(\CB\InicioBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get Usuario
     *
     * @return \CB\InicioBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    
    public function __toString() {
        return $this->getAsunto();
    }
}
