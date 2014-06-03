<?php

namespace CB\InicioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

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
        $array['title'] = 'Inicio';
        return $this->render('InicioBundle:Default:index.html.twig', $array);
    }
}