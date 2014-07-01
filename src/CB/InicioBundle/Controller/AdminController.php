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
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * Show default index.
     *
     * @Route("/", name="index_admin")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $array['title'] = 'Panel Administrativo';
        $array['ruta']="volver";
        return $this->render('InicioBundle:Admin:index.html.twig', $array);
    }
}