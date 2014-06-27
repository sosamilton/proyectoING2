<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Libro;
use CB\InicioBundle\Form\LibroType;

/**
 * Default controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * Show default index.
     *
     * @Route("/", name="index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Libro')->findAll();
        
        $array['title'] = 'Inicio';
        $array['libros'] = $entities;
        //return $this->render('InicioBundle:Default:index.html.twig', $array);
        return $this->render('InicioBundle:Default:index.html.twig', array(
            'title'     => 'Inicio',
            'libros'    => $entities
        ));
    }
}