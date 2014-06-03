<?php

namespace CB\InicioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CB\InicioBundle\Entity\Usuario;

class LoadUsuarioData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userAdmin = new Usuario();
        $userAdmin->setUsername('admin');
        $userAdmin->setPassword('test');

        $manager->persist($userAdmin);
        $manager->flush();
    }
}