<?php
 
namespace CB\InicioBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

 
class SecurityController extends Controller
{
     public function indexAction(){
        $em = $this->getDoctrine()->getManager();
            $user = $this->getDoctrine()
            ->getRepository('InicioBundle:Usuario')
            ->findAll();

            $array = array(
                "title" =>"Usuarios",
                "data" => $user,
                "ruta" => "usuarios"
            );
            return $this->render('InicioBundle:Usuario:index.html.twig', $array);
    }
    
    public function loginAction()
    {     
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('index'));
        }
        
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('admin'));
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