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
use CB\InicioBundle\Entity\Elemento;
use CB\InicioBundle\Entity\Localidad;
use CB\InicioBundle\Entity\TipoTarjeta;
use CB\InicioBundle\Entity\Tarjeta;
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
        $usr= $this->get('security.context')->getToken()->getUser();
        $provincias = $em->getRepository('InicioBundle:Provincia')->findAll();
        $ultimoPedido = $em->getRepository('InicioBundle:Pedido')->findOneBy(
                array('usuario' => $usr ),
                array('fecha' => 'DESC' )
                );
        
        if (isset($ultimoPedido)) {  
            $id=$ultimoPedido->getDireccion()->getId();
            $dir = $em->getRepository('InicioBundle:Direccion')->findOneById($id);
            $localidades = $em->getRepository('InicioBundle:Localidad')->findByProvincia($dir->getProvincia()->getId());
            $array['dir']= $dir;
            $array['localidades']= $localidades;
        }else{
            $array['dir']= false;
        }
        $array['libros']= $libros;
        $array['title'] = 'Compra paso 1';
        $array['provincias']= $provincias;
        return $this->render('InicioBundle:Default:compra-paso-uno.html.twig', $array);
    }
    
    public function compraPasoDosAction(Request $request)
    {
        
        $datos = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $id=$session->get('idCarrito');
        if (!(isset($id))){
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
            $em->persist($direccion);
            $em->flush();

            // Guardo Pedido
            $pedido= new Pedido();
            $pedido->setDireccion($direccion);
            $estado = $em->getRepository('InicioBundle:Estado')->findOneByNombre('Pendiente');
            $pedido->setEstado($estado);
            $pedido->setFecha(new \DateTime());
            $pedido->setUsuario($usr);
            $em->persist($pedido);
            $em->flush();
        }else{
            $pedido = $em->getRepository('InicioBundle:Pedido')->findOneById($id);
            $direccion= $em->getRepository('InicioBundle:Direccion')->findOneById($pedido->getDireccion()->getId()); 
        }
        
        $libros=$datos['libro'];
        $aux=array();
        $total=0;
        foreach ( $libros as $id ){
                $libro = $em->getRepository('InicioBundle:Libro')
                    ->findOneById($id['id']);
                $aux[$id['id']]['libro']=$libro;
                $aux[$id['id']]['cant']=$id['cant'];
               //Creo un elemento
                if (!(isset($id))){
                    $elemento = new Elemento();
                    $elemento->setLibro($libro);
                    $elemento->setCantidad($id['cant']);
                    $em->persist($elemento);
                    $em->flush();
                
                    //Fin crear elemento
                    $pedido->addElemento($elemento);
                }
                $total += $id['cant']*$libro->getPrecio()   ;
        }
        if (!(isset($id))){
            $em->persist($pedido);
            $em->flush();
        }
        $session->set('idCarrito', $pedido->getId());
        $tarjetas= $em->getRepository('InicioBundle:TipoTarjeta')->findAll();
        $array=array();
        $array['pedido']=$aux;
        $array['tarjetas']=$tarjetas;
        $array['total']=$total;
        $array['direccion']=$direccion;
        $array['title']= "Seleccione el Modo de Pago";
        
        return $this->render('InicioBundle:Default:compra-paso-dos.html.twig', $array);
    }
    
    public function finalizarCompraAction(Request $request)
    {
        $datos = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        // Guardo Pago
        $pago= new Tarjeta();
        $pago->setNumero($datos['numero']);
        $pago->setVencimiento($datos['vencimiento']);
        if (isset($datos['tieneCSC'])){
           $pago->setNoTieneCod(true);
        }else{
            $pago->setNoTieneCod(false);
            $pago->setCodigo($datos['csc']);
        }
        $pago->setNombre($datos['nombre']);
        $usr= $this->get('security.context')->getToken()->getUser();
        $pago->setUsuario($usr);
        $pago->setApellido($datos['apellido']);
        $pago->setDni($datos['dni']);
        $tipoTarjeta = $em->getRepository('InicioBundle:TipoTarjeta')->findOneById($datos['tipo_tarjeta']);
        $pago->setTipoTarjeta($tipoTarjeta);
        $pago->setFecha(new \DateTime());
        $em->persist($pago);
        $em->flush();
     
        $em = $this->getDoctrine()->getManager();
        $session = $this->getRequest()->getSession();
        $id = $session->get('idCarrito');
        $pedido=$em->getRepository('InicioBundle:Pedido')->findOneById($id);
        $pedido->setTarjeta($pago);
        $em->persist($pedido);
        $em->flush();
        $id = $session->remove('idCarrito');
        
        return $this->redirect($this->generateUrl('ListarPedidos'));
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
        $tipoTarjeta = $em->getRepository('InicioBundle:TipoTarjeta')->findOneById($data);
        $usr= $this->get('security.context')->getToken()->getUser();
        $val = $em->getRepository('InicioBundle:Tarjeta')->findOneBy(array(
           'usuario' => $usr,
            'tipoTarjeta' => $tipoTarjeta
        ));

        if(isset($val)){
        $datos=array();
        $datos['numero']= $val->getNumero();
        $datos['fecha']= $val->getVencimiento();
        $datos['tieneCSC']= $val->getNoTieneCod();
        $datos['numCSC']= $val->getCodigo();
        $datos['nombre']= $val->getNombre();
        $datos['apellido']= $val->getApellido();
        $datos['dni']= $val->getDni();
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
                array('estado' => $estado->getId(), 'usuario' => $usuario));
        if(isset($pedidos)){
            $datos= count($pedidos);
        }else{
            $datos=0;
        }
        $response = new JsonResponse();
        $response->setData($datos);
        return $response;
    }
    
    public function setEstadoAction(Request $request)
    {
        $pedidoId = $request->request->get('id');
        $estadoId = $request->request->get('estado');
        $em = $this->getDoctrine()->getManager();
        $pedido = $em->getRepository('InicioBundle:Pedido')->findOneById($pedidoId);
        $estado = $em->getRepository('InicioBundle:Estado')->findOneById($estadoId);
        $pedido->setEstado($estado);
        $em->persist($pedido);
        $em->flush();
        $datos=array(
            'pedido' => $pedidoId,
            'estado' => $estadoId
        );
        $response = new JsonResponse();
        $response->setData($datos);

        return $response;
    }

    
}
