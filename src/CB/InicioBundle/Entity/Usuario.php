<?php
 
namespace CB\InicioBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
 
/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario extends BaseUser
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var CB\InicioBundle\Entity\Tarjeta
     * @ORM\ManyToMany(targetEntity="CB\InicioBundle\Entity\Tarjeta")
     */
    private $tarjetas;
    

    /**
     * Agrega un rol al usuario.
     * @throws Exception
     * @param Rol $rol 
     */
    public function addRole( $rol )
    {
	array_push($this->roles, $rol);
    }
    
    

    public function getUsername() {
        return $this->username;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getRoles() {
        return $this->roles;
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
     * Constructor
     */
    public function __construct()
    {
        $this->tarjetas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tarjetas
     *
     * @param \CB\InicioBundle\Entity\Tarjeta $tarjetas
     * @return Usuario
     */
    public function addTarjeta(\CB\InicioBundle\Entity\Tarjeta $tarjetas)
    {
        $this->tarjetas[] = $tarjetas;

        return $this;
    }

    /**
     * Remove tarjetas
     *
     * @param \CB\InicioBundle\Entity\Tarjeta $tarjetas
     */
    public function removeTarjeta(\CB\InicioBundle\Entity\Tarjeta $tarjetas)
    {
        $this->tarjetas->removeElement($tarjetas);
    }

    /**
     * Get tarjetas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTarjetas()
    {
        return $this->tarjetas;
    }
}
