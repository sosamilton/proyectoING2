<?php

namespace CB\InicioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Elemento
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Elemento
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
     * @var CB\InicioBundle\Entity\Libro
     * @ORM\ManyToOne(targetEntity="CB\InicioBundle\Entity\Libro")
     */
    private $libro;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;



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
     * Set cantidad
     *
     * @param integer $cantidad
     * @return Elemento
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set libro
     *
     * @param \CB\InicioBundle\Entity\Libro $libro
     * @return Elemento
     */
    public function setLibro(\CB\InicioBundle\Entity\Libro $libro = null)
    {
        $this->libro = $libro;

        return $this;
    }

    /**
     * Get libro
     *
     * @return \CB\InicioBundle\Entity\Libro 
     */
    public function getLibro()
    {
        return $this->libro;
    }
}
