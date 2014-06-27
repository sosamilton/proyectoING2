<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Libro;
use CB\InicioBundle\Form\LibroType;
use Symfony\Component\Security\Core\SecurityContext;

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
            'libros'    => $entities,
            'error'         => false,
        ));
    }
    public function loginIndexAction(){
        $em = $this->getDoctrine()->getManager();
            $user = $this->getDoctrine()
            ->getRepository('InicioBundle:Usuario')
            ->findAll();

            $array = array(
                "title" =>"Usuarios",
                "data" => $user,
            );
            return $this->render('InicioBundle:Usuario:index.html.twig', $array);
    }
    
    public function loginAction()
    {     
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('index'));
        }
        
        $request = $this->getRequest();
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('InicioBundle:Usuario:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }

    public function getTokenAction()
    {
        return new Response($this->container->get('form.csrf_provider')
            ->generateCsrfToken('authenticate'));
    }
}