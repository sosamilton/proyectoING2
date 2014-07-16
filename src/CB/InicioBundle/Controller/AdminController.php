<?php

namespace CB\InicioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use CB\InicioBundle\Entity\Pedido;
use CB\InicioBundle\Entity\Estado;
use CB\InicioBundle\Entity\Mensaje;

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
        $em = $this->getDoctrine()->getManager();
        $usuario= $this->get('security.context')->getToken()->getUser();
        $pedidos = $em->getRepository('InicioBundle:Pedido')->findAll();
        $estados= $em->getRepository('InicioBundle:Estado')->findAll();
        return $this->render('InicioBundle:Admin:listPedidos.html.twig', array(
            'title'     => 'Listado de Pedidos',
            'pedidos'   => $pedidos,
            'estados'     => $estados,
            'ruta'     => "pedidos",
        ));
    }
    
    public function listPedidosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuario= $this->get('security.context')->getToken()->getUser();
        $pedidos = $em->getRepository('InicioBundle:Pedido')->findAll();
        $estados= $em->getRepository('InicioBundle:Estado')->findAll();
        return $this->render('InicioBundle:Admin:listPedidos.html.twig', array(
            'title'     => 'Listado de Pedidos',
            'pedidos'   => $pedidos,
            'estados'     => $estados,
            'ruta'     => "pedidos",
        ));    
    }
    
        
    public function buscarCantAction(Request $request)
    {
        $data = $request->request->get('data');
        $em = $this->getDoctrine()->getManager();
        
        $estado = $em->getRepository('InicioBundle:Estado')->findOneByNombre('Pendiente');
        $pedidos = $em->getRepository('InicioBundle:Pedido')->findByEstado($estado->getId());
        $mensajes = $em->getRepository('InicioBundle:Mensaje')->findByLeido(false);
        $datos=array();
        if(isset($pedidos)){
            $datos['pedidos']= count($pedidos);
        }else{
            $datos['pedidos']=0;
        }
        if(isset($mensajes)){
            $datos['mensaje']= count($mensajes);
        }else{
            $datos['mensaje']=0;
        }
        $response = new JsonResponse();
        $response->setData($datos);
        return $response;
    }
    
    public function verPedidoAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $pedidos = $em->getRepository('InicioBundle:Pedido')->findOneById($id);
        $tarjeta=$pedidos->getTarjeta()->getNumero();
        $dim=strlen($tarjeta);
        $dim=$dim-5;
        for ($i=0; $i <= $dim; $i++){
            $tarjeta[$i]="*";
        }
        $pedidos->getTarjeta()->setNumero($tarjeta);
        $libros = $pedidos->getLibros($dim);
        $res=array();
        $tot=0;
        foreach ($libros as $libro) {
            $tot=$tot+$libro->getPrecio();
            $res[$libro->getId()]['titulo']=$libro->getTitulo();
            $res[$libro->getId()]['precio']=$libro->getPrecio();
            if (isset($res[$libro->getId()]['cant'])){
                 $res[$libro->getId()]['cant']++;
            }else{
                 $res[$libro->getId()]['cant']=1;
            }
        }
        $direccion=$em->getRepository('InicioBundle:Direccion')->findOneById($pedidos->getDireccion());
        return $this->render('InicioBundle:Admin:verPedidos.html.twig', array(
            'title'     => 'Viendo Pedido',
            'direccion' =>  $direccion,
            'pedido'    =>  $pedidos,
            'total'     => $tot,
            'libros'    =>  $res,
            'ruta'    =>  "pedidos",
        ));
    }
    public function balanceAction(Request $request) {
        if($request->isMethod('POST')){
            $datos = $request->request->all();
            $dql="select d from InicioBundle:";
            if($datos['filtro']=="1"){
                $dql.="Usuario as d ";    
            }else{
                $dql.="Pedido as d "; 
            }
            $dql.=" where d.fecha between :min and :max";
            $em=$this->getDoctrine()->getEntityManager();
            $query=$em->createQuery($dql);
            $query->setParameter("min", $datos['min']);
            $query->setParameter("max", $datos['max']);
            $result=$query->getResult();
            if($datos['filtro']=="2"){
                $aux=array();
                foreach ($result as $pedido) {
                    $elementos=$pedido->getElementos();
                    foreach ($elementos as $elemento) {
                        $libro=$elemento->getLibro();
                        $aux[$libro->getId()]['dato']=$libro;
                        if(isset($aux[$libro->getId()]['cant'])){
                            $aux[$libro->getId()]['cant']++;
                        }else
                            $aux[$libro->getId()]['cant']=1;
                    }
                }
                foreach ($aux as $key => $row) {
                    $pepe[$key] = $row['cant'];
                }
                array_multisort($pepe, SORT_DESC, $aux);
                $datos=array_slice($aux, 0, 5);
                $tipo=2;
            }else{
                $datos=$result;
                $tipo=1;
            }
        }else{
            $datos=false;
            $tipo=0;
        }
        $array=array(
            'title' => 'Balance',
            'tipo' => $tipo,
            'ruta' => 'balance',
            'datos' => $datos
        );
        
        return $this->render('InicioBundle:Balance:index.html.twig', $array);
    }

}