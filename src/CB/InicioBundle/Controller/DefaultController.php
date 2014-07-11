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

use CB\InicioBundle\Entity\Pedido;
use CB\InicioBundle\Entity\Direccion;
use CB\InicioBundle\Entity\Usuario;
use CB\InicioBundle\Entity\Estado;

use CB\InicioBundle\Entity\Mensaje;
use CB\InicioBundle\Form\MensajeType;

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
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('admin'));
        }
        //return $this->render('InicioBundle:Default:index.html.twig', $array);
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('InicioBundle:Default:index.html.twig', array(
            'title'     => 'Inicio',
            'libros'    => $entities,
            'error'     => false,
            'form'      => false
        ));
        }else{
            return $this->render('InicioBundle:Default:index.html.twig', array(
            'title'     => 'Inicio',
            'libros'    => $entities,
            'error'     => true,
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
        
        $entity = new Mensaje();
        $form   = $this->createCreateForm($entity);
        $datos= array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'title' => "Contacto",
        );
        
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
        
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('admin'));
        }
        
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('InicioBundle:Contacto:index.html.twig', array(
            'title'     => 'Contacto',
            'error'     => false,
            'contacto'  =>  $datos,
            'form'      => $form->createView()
        ));
        }else{
            return $this->render('InicioBundle:Contacto:index.html.twig', array(
            'title'     =>  'Contacto',
            'error'     =>  true,
            'contacto'  =>  $datos,
            'form'      =>  $form->createView()));
        }
        return $this->render('InicioBundle:Contacto:index.html.twig', $datos);
    }
    
    private function createCreateForm(Mensaje $entity)
    {
        $form = $this->createForm(new MensajeType(), $entity, array(
            'action' => $this->generateUrl('mensaje_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }
    
    public function ayudaAction()
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
        
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('admin'));
        }
        
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('InicioBundle:Ayuda:index.html.twig', array(
            'title'     => 'Ayuda',
            'error'         => false,
            'form' => false
        ));
        }else{
            return $this->render('InicioBundle:Ayuda:index.html.twig', array(
            'title'     => 'Ayuda',
            'error'         => true,
            'form' => $form->createView()));
        }
    }
    
    public function listPedidosAction()
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
        $em = $this->getDoctrine()->getManager();
        $usuario= $this->get('security.context')->getToken()->getUser();
        $pedidos = $em->getRepository('InicioBundle:Pedido')->findByUsuario($usuario);

        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('admin'));
        }
        
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('InicioBundle:Default:listPedidos.html.twig', array(
            'title'     => 'Listado de Pedidos',
            'pedidos'   => $pedidos,
            'error'     => false,
            'form'      => false
        ));
        }else{
            return $this->render('InicioBundle:Default:listPedidos.html.twig', array(
            'title'     => 'Listado de Pedidos',
            'pedidos'   => $pedidos,
            'error'     => true,
            'form'      => $form->createView()));
        }
    }
    
    public function verPedidoAction($id)
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
        $em = $this->getDoctrine()->getManager();
        $usuario= $this->get('security.context')->getToken()->getUser();
        $pedidos = $em->getRepository('InicioBundle:Pedido')->findByUsuario($usuario);

        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('admin'));
        }
        
        $em = $this->getDoctrine()->getManager();
        $pedidos = $em->getRepository('InicioBundle:Pedido')->findOneById($id);
        if (($pedidos->getTarjeta()) != null){
            $tarjeta=$pedidos->getTarjeta()->getNumero();
            $dim=strlen($tarjeta);
            $dim=$dim-5;
            for ($i=0; $i <= $dim; $i++){
                $tarjeta[$i]="*";
            }
            $pedidos->getTarjeta()->setNumero($tarjeta);
        }

        $elementos = $pedidos->getElementos();
        $pedidos->getTarjeta()->setNumero($tarjeta);
        $libros = $pedidos->getLibros();
        $res=array();
        $tot=0;
        foreach ($elementos as $elemento) {
            $libro=$elemento->getLibro();
            $tot=$tot+$libro->getPrecio();
            $res[$libro->getId()]['titulo']=$libro->getTitulo();
            $res[$libro->getId()]['precio']=$libro->getPrecio();
            $res[$libro->getId()]['cant']=$elemento->getCantidad();
            if (isset($res[$libro->getId()]['cant'])){
                 $res[$libro->getId()]['cant']++;
            }else{
                 $res[$libro->getId()]['cant']=1;
            }
        }
        $direccion=$em->getRepository('InicioBundle:Direccion')->findOneById($pedidos->getDireccion()->getId());
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('InicioBundle:Default:verPedidos.html.twig', array(
            'title'     => 'Viendo Pedido',
            'direccion' =>  $direccion,
            'pedido'    =>  $pedidos,
            'total'     => $tot,
            'libros'    =>  $res,
            'error'     =>  false,
            'form'      =>  false
        ));
        }else{
            return $this->render('InicioBundle:Default:verPedidos.html.twig', array(
            'title'     => 'Viendo Pedido',
            'direccion' =>  $direccion,
            'pedido'    =>  $pedidos,
            'total'     => $tot,
            'libros'    =>  $res,
            'error'     => true,
            'form'      => $form->createView()));
        }
    }
    
        
    public function cambiarNombreUsuario($id,$username) {
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('InicioBundle:Usuario')->find($id);
        $entity->setUserName($username);
        $em->flush();
    }
    
    public function perfilAction()
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
        $em = $this->getDoctrine()->getManager();
        $usuario= $this->get('security.context')->getToken()->getUser();
        $pedidos = $em->getRepository('InicioBundle:Pedido')->findByUsuario($usuario);

        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('admin'));
        }
        
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('InicioBundle:Usuario:perfil.html.twig', array(
            'title'     => 'Mi Perfil',
            'error'     =>  false,
            'form'      =>  false
        ));
        }else{
            return $this->render('InicioBundle:Usuario:perfil.html.twig', array(
            'title'     => 'Mi Perfil',
            'error'     => true,
            'form'      => $form->createView()));
        }
    }
    
    public function borrarUsuarioAction($id) {
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('InicioBundle:Usuario')->find($id);
        $em->remove($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('inicio'));
    }
}
