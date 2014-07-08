<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\SecurityContext;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use CB\InicioBundle\Entity\Pedido;
use CB\InicioBundle\Entity\Libro;
use CB\InicioBundle\Entity\Estado;
use CB\InicioBundle\Entity\Provincia;
use CB\InicioBundle\Entity\Direccion;
use CB\InicioBundle\Form\PedidoType;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;


/**
 * Pedido controller.
 *
 * @Route("/pedido")
 */
class PedidoController extends Controller
{

    /**
     * Lists all Pedido entities.
     *
     * @Route("/", name="pedido")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Pedido')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Pedido entity.
     *
     * @Route("/", name="pedido_create")
     * @Method("POST")
     * @Template("InicioBundle:Pedido:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Pedido();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pedido_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Pedido entity.
    *
    * @param Pedido $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Pedido $entity)
    {
        $form = $this->createForm(new PedidoType(), $entity, array(
            'action' => $this->generateUrl('pedido_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Pedido entity.
     *
     * @Route("/new", name="pedido_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Pedido();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Pedido entity.
     *
     * @Route("/{id}", name="pedido_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Pedido')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pedido entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Pedido entity.
     *
     * @Route("/{id}/edit", name="pedido_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Pedido')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pedido entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Pedido entity.
    *
    * @param Pedido $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pedido $entity)
    {
        $form = $this->createForm(new PedidoType(), $entity, array(
            'action' => $this->generateUrl('pedido_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Pedido entity.
     *
     * @Route("/{id}", name="pedido_update")
     * @Method("PUT")
     * @Template("InicioBundle:Pedido:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Pedido')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pedido entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pedido_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Pedido entity.
     *
     * @Route("/{id}", name="pedido_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Pedido')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pedido entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pedido'));
    }

    /**
     * Creates a form to delete a Pedido entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pedido_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    public function conformarCarritoAction(Request $request){
        $data = $request->request->get('data');
        $em =$this->getDoctrine()->getEntityManager();
        $array = explode("|", $data);
        $cant=sizeof($array)-1;
        $response = new JsonResponse();
        unset($array[$cant]);
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) { 
            $libros=array();
            foreach ($array as $id) {
                $libro = $em->getRepository('InicioBundle:Libro')
                    ->findOneById($id);
                $libros[]=$libro;
            }
            $session = $this->getRequest()->getSession();
            $session->set('pedido', $libros);
            $response->setData(true);
        }else{
            $response->setData(false);
        }
        return $response;
    }
    
    public function compraPasoUnoAction(Request $request)
    {
        $session = $request->getSession();
        $libros = $session->get('pedido');
        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('InicioBundle:Provincia')->findAll();
        $array['libros']= $libros;
        
        $array['title'] = 'Compra paso 1';
        $array['provincias']= $provincias;
        return $this->render('InicioBundle:Default:compra-paso-uno.html.twig', $array);
    }
    
    public function compraPasoDosAction(Request $request)
    {
        
        $datos = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        
        // Guardo la direccion
        $direccion = new Direccion();
        $provincia = $em->getRepository('InicioBundle:Provincia')->findOneById($datos['dir']['provincia']);       
        $direccion->setProvincia($provincia);
        $usr= $this->get('security.context')->getToken()->getUser();
        $localidad = $em->getRepository('InicioBundle:Localidad')->findOneById($datos['dir']['localidad']);   
        $direccion->setLocalidad($localidad);
        $direccion->setUsuario($usr);
        $direccion->setCalle($datos['dir']['calle']);
        $direccion->setNumero($datos['dir']['numero']);
        $direccion->setPiso($datos['dir']['piso']);
        $direccion->setDpto($datos['dir']['dpto']);
//        $em->persist($direccion);
//        $em->flush();
        
        // Guardo Pedido
        $pedido= new Pedido();
        $pedido->setDireccion($direccion);
        $estado = $em->getRepository('InicioBundle:Estado')->findOneByNombre('Pendiente');
        $pedido->setEstado($estado);
        $pedido->setFecha(new \DateTime());
        $pedido->setUsuario($usr);
        $libros=$datos['libro'];
        $aux=array();
        $total=0;
        foreach ( $libros as $id ){
                $libro = $em->getRepository('InicioBundle:Libro')
                    ->findOneById($id['id']);
                $aux[$libro->getId()]['libro']=$libro;
                $aux[$libro->getId()]['cant']=$id['cant'];
            for ($i=1; $i <= $id['cant']; $i++){
                $pedido->addLibro($libro);
                $total= $total+$libro->getPrecio();
            }
        }
//        $em->persist($pedido);
//        $em->flush();
        $array=array();
        $array['pedido']=$aux;
        $array['total']=$total;
        $array['direccion']=$direccion;
        $array['title']= "Seleccione el Modo de Pago";
        
        return $this->render('InicioBundle:Default:compra-paso-dos.html.twig', $array);
    }
    
    public function buscarLocalidadesAction(Request $request)
    {
        $data = $request->request->get('data');
        $em = $this->getDoctrine()->getManager();
        $provincia = $em->getRepository('InicioBundle:Provincia')->findOneById($data);
        $resultado = $provincia->getLocalidades();
        $datos=array();
        $i=0;
        foreach ($resultado as $result){
            $datos[$i]['nombre']= $result->getNombre();
            $datos[$i]['id']= $result->getId();
            $i++;
        }
        $response = new JsonResponse();
        $response->setData($datos);

        return $response;
    }
    
    public function buscarDatosTarjetaAction(Request $request)
    {
        $data = $request->request->get('data');
        $em = $this->getDoctrine()->getManager();
//        $provincia = $em->getRepository('InicioBundle:Provincia')->findOneById($data);
//        $resultado = $provincia->getLocalidades();
        if(true){
        $datos=array();
        $datos['numero']= 300303030;
        $datos['fecha']= "2014-07";
        $datos['tieneCSC']= true;
        $datos['numCSC']= 366;
        }else{
           $datos=false; 
        }
        $response = new JsonResponse();
        $response->setData($datos);
        return $response;
    }
    
    public function buscarPedidosAction(Request $request)
    {
        $data = $request->request->get('data');
        $em = $this->getDoctrine()->getManager();
        
        $estado = $em->getRepository('InicioBundle:Estado')->findOneByNombre('Pendiente');
        $usuario= $this->get('security.context')->getToken()->getUser();
       
        $pedidos = $em->getRepository('InicioBundle:Pedido')->findBy(
                array('estado' => $estado, 'usuario' => $usuario));
        $pedido=$em->getRepository('InicioBundle:Pedido')->findOneByUsuario($usuario);
        var_dump($pedido->getDireccion());
        die;
        if(isset($pedidos)){
            $datos['cant']= count($pedidos);
            $datos['dir']= $pedido->getDireccion();
        }else{
            $datos['cant']=0;
        }

        $response = new JsonResponse();
        $response->setData($datos);
        return $response;
    }
    
    
    
}
