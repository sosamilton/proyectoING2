<?php

namespace CB\InicioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provincia
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Provincia
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
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;
    
    /**
     * @var CB\InicioBundle\Entity\Ciudad
     *
     * @ORM\OneToMany(targetEntity="CB\InicioBundle\Entity\Ciudad", mappedBy="provincia") 
     */
    private $ciudades;

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
     * Set nombre
     *
     * @param string $nombre
     * @return Provincia
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
    
    public function __toString() {
        return $this->getNombre();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ciudades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ciudades
     *
     * @param \CB\InicioBundle\Entity\Ciudad $ciudad
     * @return Provincia
     */
    public function addCiudad(\CB\InicioBundle\Entity\Ciudad $ciudad)
    {
        $this->ciudades[] = $ciudad;

        return $this;
    }

    /**
     * Remove ciudades
     *
     * @param \CB\InicioBundle\Entity\Ciudad $ciudad
     */
    public function removeCiudad(\CB\InicioBundle\Entity\Ciudad $ciudad)
    {
        $this->ciudades->removeElement($ciudad);
    }

    /**
     * Get ciudades
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCiudades()
    {
        return $this->ciudades;
    }
}
