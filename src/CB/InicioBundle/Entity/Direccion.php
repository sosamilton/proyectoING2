<?php

namespace CB\InicioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Direccion
 *
 * @ORM\Table()
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
     * @var CB\InicioBundle\Entity\Ciudad
     *
     * @ORM\OneToOne(targetEntity="CB\InicioBundle\Entity\Ciudad") 
     */
    private $ciudad;

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
     * Set ciudad
     *
     * @param \CB\InicioBundle\Entity\Ciudad $ciudad
     * @return Direccion
     */
    public function setCiudad(\CB\InicioBundle\Entity\Ciudad $ciudad = null)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return \CB\InicioBundle\Entity\Ciudad 
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }
    
    public function __toString() {
        return $this->getProvincia(). ' - ' .$this->getCiudad();
    }
}
