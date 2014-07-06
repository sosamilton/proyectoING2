<?php

namespace CB\InicioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Direccion
 *
 * @ORM\Table(name="Direccion", indexes={@ORM\Index(name="fk_Identificacion_Ficha1_idx", columns={"Usuario"})})
 * @ORM\Entity
 */
class Direccion
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
     * @var CB\InicioBundle\Entity\Provincia
     *
     * @ORM\OneToOne(targetEntity="CB\InicioBundle\Entity\Provincia") 
     */
    private $provincia;

    /**
     * @var CB\InicioBundle\Entity\Localidad
     *
     * @ORM\OneToOne(targetEntity="CB\InicioBundle\Entity\Localidad") 
     */
    private $localidad;

    /**
     * @var string
     *
     * @ORM\Column(name="calle", type="string", length=50)
     */
    private $calle;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero", type="integer", nullable=true)
     */
    private $numero;

    /**
     * @var integer
     *
     * @ORM\Column(name="piso", type="integer", nullable=true)
     */
    private $piso;

    /**
     * @var string
     *
     * @ORM\Column(name="dpto", type="string", length=5, nullable=true)
     */
    private $dpto;
    
    
    /**
    * @ORM\Column(type="integer")
    * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="Direccion")
    * @ORM\JoinColumn(referencedColumnName="id")
    */
    private $usuario;


    
    public function __toString() {
        return $this->getProvincia(). ' - ' .$this->getLocalidad();
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
     * Set calle
     *
     * @param string $calle
     * @return Direccion
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     * @return Direccion
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set piso
     *
     * @param integer $piso
     * @return Direccion
     */
    public function setPiso($piso)
    {
        $this->piso = $piso;

        return $this;
    }

    /**
     * Get piso
     *
     * @return integer 
     */
    public function getPiso()
    {
        return $this->piso;
    }

    /**
     * Set dpto
     *
     * @param string $dpto
     * @return Direccion
     */
    public function setDpto($dpto)
    {
        $this->dpto = $dpto;

        return $this;
    }

    /**
     * Get dpto
     *
     * @return string 
     */
    public function getDpto()
    {
        return $this->dpto;
    }

    /**
     * Set provincia
     *
     * @param \CB\InicioBundle\Entity\Provincia $provincia
     * @return Direccion
     */
    public function setProvincia(\CB\InicioBundle\Entity\Provincia $provincia = null)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return \CB\InicioBundle\Entity\Provincia 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set localidad
     *
     * @param \CB\InicioBundle\Entity\Localidad $localidad
     * @return Direccion
     */
    public function setLocalidad(\CB\InicioBundle\Entity\Localidad $localidad = null)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return \CB\InicioBundle\Entity\Localidad 
     */
    public function getLocalidad()
    {
        return $this->localidad;
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
}
