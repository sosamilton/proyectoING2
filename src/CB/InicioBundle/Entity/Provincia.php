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
     * @var CB\InicioBundle\Entity\Localidad
     *
     * @ORM\OneToMany(targetEntity="CB\InicioBundle\Entity\Localidad", mappedBy="provincia") 
     */
    private $localidades;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->localidades = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Add localidades
     *
     * @param \CB\InicioBundle\Entity\Localidad $localidad
     * @return Provincia
     */
    public function addLocalidad(\CB\InicioBundle\Entity\Localidad $localidad)
    {
        $this->localidades[] = $localidad;

        return $this;
    }

    /**
     * Remove localidades
     *
     * @param \CB\InicioBundle\Entity\Localidad $localidad
     */
    public function removeLocalidad(\CB\InicioBundle\Entity\Localidad $localidad)
    {
        $this->localidades->removeElement($localidad);
    }

    /**
     * Get localidades
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLocalidades()
    {
        return $this->localidades;
    }
    public function __toString() {
        return $this->getNombre();
    }

    /**
     * Add localidades
     *
     * @param \CB\InicioBundle\Entity\Localidad $localidades
     * @return Provincia
     */
    public function addLocalidade(\CB\InicioBundle\Entity\Localidad $localidades)
    {
        $this->localidades[] = $localidades;

        return $this;
    }

    /**
     * Remove localidades
     *
     * @param \CB\InicioBundle\Entity\Localidad $localidades
     */
    public function removeLocalidade(\CB\InicioBundle\Entity\Localidad $localidades)
    {
        $this->localidades->removeElement($localidades);
    }
}
