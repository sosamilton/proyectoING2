<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use CB\InicioBundle\Entity\Libro;
use CB\InicioBundle\Form\LibroType;

use FOS\UserBundle\Model\UserInterface;

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
        
         $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();
            
            $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
            $route = 'fos_user_registration_check_email';

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);
            $response = new RedirectResponse($url);

            return $response;
        }
        
        //return $this->render('InicioBundle:Default:index.html.twig', $array);
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('InicioBundle:Default:index.html.twig', array(
            'title'     => 'Inicio',
            'libros'    => $entities,
            'error'         => false,
            'form' => false
        ));
        }else{
            return $this->render('InicioBundle:Default:index.html.twig', array(
            'title'     => 'Inicio',
            'libros'    => $entities,
            'error'         => false,
            'form' => $form->createView()));
        }
        
    }
    
    // INICIO DE FUNCIONES DE REGISTRO
    protected function authenticateUser(UserInterface $user, Response $response)
    {
        try {
            $this->container->get('fos_user.security.login_manager')->loginUser(
                $this->container->getParameter('fos_user.firewall_name'),
                $user,
                $response);
        } catch (AccountStatusException $ex) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
    }

    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
    }

    protected function getEngine()
    {
        return $this->container->getParameter('fos_user.template.engine');
    }
    
        public function checkEmailAction()
    {
        $email = $this->container->get('session')->get('fos_user_send_confirmation_email/email');
        $this->container->get('session')->remove('fos_user_send_confirmation_email/email');
        $user = $this->container->get('fos_user.user_manager')->findUserByEmail($email);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $email));
        }

        return $this->container->get('templating')->renderResponse('InicioBundle:Usuario:checkEmail.html.'.$this->getEngine(), array(
            'user' => $user,
        ));
    }

    /**
     * Receive the confirmation token from user email provider, login the user
     */
    public function confirmAction($token)
    {
        $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $user->setLastLogin(new \DateTime());

        $this->container->get('fos_user.user_manager')->updateUser($user);
        $response = new RedirectResponse($this->container->get('router')->generate('fos_user_registration_confirmed'));
        $this->authenticateUser($user, $response);

        return $response;
    }

    /**
     * Tell the user his account is now confirmed
     */
    public function confirmedAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:confirmed.html.'.$this->getEngine(), array(
            'user' => $user,
        ));
    }
    // FIN DE FUNCIONES DEL REGISTRO 
    
    
    // FUNCION DE LOGIN
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
    //FIN DE LOGIN
    
    
    //FUNCION DE REGISTRO ROBADA
    public function registerAction()
    {
       
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();
            
            $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
            $route = 'fos_user_registration_check_email';

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);
            $response = new RedirectResponse($url);

            return $response;
        }

        return $this->container->get('templating')->renderResponse('InicioBundle:Usuario:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function contactoAction()
    {
        return $this->render('InicioBundle:Contacto:index.html.twig');
    }
    
    public function ayudaAction()
    {
        return $this->render('InicioBundle:Ayuda:index.html.twig');
    }
}