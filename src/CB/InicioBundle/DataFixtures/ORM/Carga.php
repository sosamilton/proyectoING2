<?php
namespace CB\InicioBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CB\InicioBundle\Entity\Autor;
use CB\InicioBundle\Entity\Editorial;
use CB\InicioBundle\Entity\Categoria;
use CB\InicioBundle\Entity\Estado;

class Carga implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $autores = array(
            array('nombre' => 'Autor 1', 'borrado' => FALSE),
            array('nombre' => 'Autor 2', 'borrado' => FALSE),
            array('nombre' => 'Autor 3', 'borrado' => FALSE),
            array('nombre' => 'Autor 4', 'borrado' => FALSE),
            array('nombre' => 'Autor 5', 'borrado' => FALSE),
            array('nombre' => 'Autor 6', 'borrado' => FALSE),
            array('nombre' => 'Autor 7', 'borrado' => FALSE),
            array('nombre' => 'Autor 8', 'borrado' => FALSE),
            array('nombre' => 'Autor 9', 'borrado' => FALSE),
            array('nombre' => 'Autor 10', 'borrado' => FALSE),
        );


        $editoriales = array(
            array('nombre' => 'Editorial 1', 'borrado' => FALSE),
            array('nombre' => 'Editorial 2', 'borrado' => FALSE),
            array('nombre' => 'Editorial 3', 'borrado' => FALSE),
            array('nombre' => 'Editorial 4', 'borrado' => FALSE),
            array('nombre' => 'Editorial 5', 'borrado' => FALSE),
            array('nombre' => 'Editorial 6', 'borrado' => FALSE),
            array('nombre' => 'Editorial 7', 'borrado' => FALSE),
            array('nombre' => 'Editorial 8', 'borrado' => FALSE),
            array('nombre' => 'Editorial 9', 'borrado' => FALSE),
            array('nombre' => 'Editorial 10', 'borrado' => FALSE),
        );

        $categorias = array(
            array('nombre' => 'Categoria 1', 'borrado' => FALSE),
            array('nombre' => 'Categoria 2', 'borrado' => FALSE),
            array('nombre' => 'Categoria 3', 'borrado' => FALSE),
            array('nombre' => 'Categoria 4', 'borrado' => FALSE),
            array('nombre' => 'Categoria 5', 'borrado' => FALSE),
            array('nombre' => 'Categoria 6', 'borrado' => FALSE),
            array('nombre' => 'Categoria 7', 'borrado' => FALSE),
            array('nombre' => 'Categoria 8', 'borrado' => FALSE),
            array('nombre' => 'Categoria 9', 'borrado' => FALSE),
            array('nombre' => 'Categoria 10', 'borrado' => FALSE),
        );

        $estados = array(
            array('nombre' => 'Estado 1'),
            array('nombre' => 'Estado 2'),
            array('nombre' => 'Estado 3'),
            array('nombre' => 'Estado 4'),
            array('nombre' => 'Estado 5'),
        );
        
        foreach ($autores as $autor) {
            $entidad = new Autor();
            $entidad->setNombre($autor['nombre']);
            $entidad->setBorrado($autor['borrado']);
            $manager->persist($entidad);
        }

        foreach ($editoriales as $editorial) {
            $entidad = new Editorial();
            $entidad->setNombre($editorial['nombre']);
            $entidad->setBorrado($editorial['borrado']);
            $manager->persist($entidad);
        }

        foreach ($categorias as $categoria) {
            $entidad = new Categoria();
            $entidad->setNombre($categoria['nombre']);
            $entidad->setBorrado($categoria['borrado']);
            $manager->persist($entidad);
        }
        
        foreach ($estados as $estado) {
            $entidad = new Estado();
            $entidad->setNombre($estado['nombre']);
            $manager->persist($entidad);
        }
        $manager->flush();
        //dato de prueba
        //dato2
    }
}