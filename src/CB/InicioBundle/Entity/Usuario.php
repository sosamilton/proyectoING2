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
     * Agrega un rol al usuario.
     * @throws Exception
     * @param Rol $rol 
     */
    public function addRole( $rol )
    {
	array_push($this->roles, $rol);
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
}
