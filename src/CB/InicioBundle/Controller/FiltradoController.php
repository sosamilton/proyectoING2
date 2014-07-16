<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use CB\InicioBundle\Entity\Libro;
use CB\InicioBundle\Entity\Autor;
use CB\InicioBundle\Entity\Editorial;
use CB\InicioBundle\Entity\Categoria;
use CB\InicioBundle\Entity\Pedido;
use CB\InicioBundle\Entity\Mensaje;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\DateTime;


class FiltradoController extends Controller
{
    /**
     * Lists all Ficha.
     *
     * @Route("/", name="buscarFicha")
     * @Method("GET")
     * @Template("InicioBundle:Ficha:new.html.twig")
     */
//    public function indexAction($orden)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $fichas = $this->getDoctrine()
//        ->getRepository('InicioBundle:Ficha')
//        ->findBy(array(), array("$orden"=>'asc'));
//        $array = array(
//            "title" =>"Buscar",
//            "data" => $fichas,
//            "tipos" => $this->getDoctrine()->getRepository('InicioBundle:TipoFicha')->findAll(),
//            "estados" => $this->getDoctrine()->getRepository('InicioBundle:EstadoGeneral')->findAll(),
//        );
//        return $this->render('InicioBundle:Default:buscarFicha.html.twig', $array);
//    }

    public function filterLibroAction(Request $request){
        //Recibo el dato
        $data = $request->request->get('data');
        //Recibo el filtro
        $place = $request->request->get('place');

        $session = $this->getRequest()->getSession();

        /* 
        Seteo el filtro modificado
        */
        $session->set('filtro_'.$place, $data);

        /*
        Creo la consulta base
        */
        /*
        $repositorio = $this->getDoctrine()
            ->getRepository('InicioBundle:Ficha');
        $findParameters = array();
        */
        
        $dql="	select l from InicioBundle:Libro as l where 1 = 1";
        /*
        Obtengo todos los filtros y los aplico 
        en caso de ser necesario
        */

        $withParam=false;
        if(($session->has('filtro_isbn'))and($session->get('filtro_isbn')!='')):
            if($withParam): 
            	$dql .= " where ";
            	$where = true;
            endif;
        	$dql .= ((!$withParam)? " and " : "")."l.isbn LIKE :isbn";
        endif;
        
        if((($session->has('filtro_titulo')))and($session->get('filtro_titulo')!='')):
    		if($withParam): 
            	$dql .= " where ";
            	$where = true;
           	endif;
        	$dql .= ((!$withParam)? " and " : "")."l.titulo LIKE :titulo";
        endif;
       	
        if(($session->has('filtro_descripcion'))and($session->get('filtro_descripcion')!='')):
    		if($withParam): 
            	$dql .= " where ";
            	$withParam = false;
            endif;
        	$dql .= ((!$withParam)? " and " : "")." l.descripcion LIKE :descripcion";
        endif;
        
        if(($session->has('filtro_paginas'))and($session->get('filtro_paginas')!='')):
            if ($withParam):
                    $dql .= " where ";
                    $where = true;
            endif;
            $dql .= ((!$withParam)? " and " : "")."l.paginas LIKE :paginas";
        endif;

        if(($session->has('filtro_idioma'))and($session->get('filtro_idioma')!='')):
            if($withParam):
                    $dql .= " where ";
                    $where = true;
            endif;
            $dql .= ((!$withParam)? " where " : "")."l.idioma LIKE :idioma";
        endif;
            
        if(($session->has('filtro_precio'))and($session->get('filtro_precio')!='')):
	        if($withParam):
	        	$dql .= " where ";
	        	$where = true;
	        endif;
            $dql .= ((!$withParam)? " and " : "")."l.precio LIKE :precio";
        endif;
        
        if(($session->has('filtro_editorial'))and($session->get('filtro_editorial')!='')):
	        if($withParam):
	        	$dql .= " where ";
	        	$where = true;
	        endif;
            $dql .= ((!$withParam)? " and " : "")."l.editorial LIKE :editorial";
        endif;
        
        if(($session->has('filtro_fecha'))and($session->get('filtro_fecha')!='')):
	        if($withParam):
	        	$dql .= " where ";
	        	$where = true;
	        endif;
            $dql .= ((!$withParam)? " and " : "")." l.fecha LIKE :fecha";
        endif;
        
        if(substr($dql, -4,4)==" and ")
        	$dql = substr($dql, 0, strlen($dql)-5);
        /*if(!empty($findParameters))
        	$fichas = $repositorio->findBy($findParameters, array('id' => 'ASC'));
        else*/
        $dql.=" ORDER BY l.id ASC";
        
        $em=$this->getDoctrine()->getEntityManager();
        $query=$em->createQuery($dql);
        
        if(($session->has('filtro_isbn'))and($session->get('filtro_isbn')!=''))
        	$query->setParameter("isbn", "%".$session->get('filtro_isbn')."%");
        if((($session->has('filtro_titulo')))and($session->get('filtro_titulo')!=''))
        	$query->setParameter("titulo", "%".$session->get('filtro_titulo')."%");
        if(($session->has('filtro_descripcion'))and($session->get('filtro_descripcion')!=''))
        	$query->setParameter("descripcion", "%".$session->get('filtro_descripcion')."%");
        if(($session->has('filtro_paginas'))and($session->get('filtro_paginas')!='')){
            $query->setParameter("paginas", "%".$session->get('filtro_paginas')."%");            
        }
        if(($session->has('filtro_idioma'))and($session->get('filtro_idioma')!='')){
        }
        if(($session->has('filtro_precio'))and($session->get('filtro_precio')!='')){          
            $query->setParameter("precio", $session->get('filtro_precio'));
        }
        if(($session->has('filtro_editorial'))and($session->get('filtro_editorial')!=''))
        	$query->setParameter("editorial", $session->get('filtro_editorial'));
        if(($session->has('filtro_fecha'))and($session->get('filtro_fecha')!=''))
        	$query->setParameter("fecha", $session->get('filtro_fecha'));
        

        $libros=$query->getResult();

        $resultado = array();
        foreach ($libros as $libro) {
            $resultado[] = array(
                "id" => $libro->getId(),
                "isbn" => $libro->getIsbn(),
                "titulo" => $libro->getTitulo(),
                "descripcion" => substr(strip_tags($libro->getDescripcion()), 0, 50),
                "pagina" => $libro->getPaginas(),
                "idioma" => $libro->getIdioma(),
                "precio" => $libro->getPrecio(),
                "fecha" => $libro->getFecha(),
                'borrado' => $libro->getBorrado(),
            );
        }

        $response = new JsonResponse();
        $response->setData($resultado);

        return $response;
    }
    
    public function filterAutorAction(Request $request){
        //Recibo el dato
        $data = $request->request->get('data');
        $place = $request->request->get('place');
        $session = $this->getRequest()->getSession();
        $session->set('filtro_'.$place, $data);
        
        $dql="	select a from InicioBundle:Autor as a where 1 = 1";
        
        $withParam=false;
        if(($session->has('filtro_nombreA'))and($session->get('filtro_nombreA')!='')):
        	$dql .= ((!$withParam)? " and " : "")."a.nombre LIKE :nombre ";
        endif;
        
        if(substr($dql, -4,4)==" and ")
        	$dql = substr($dql, 0, strlen($dql)-5);

        $dql.=" ORDER BY a.id ASC";
        
        $em=$this->getDoctrine()->getEntityManager();
        $query=$em->createQuery($dql);
        
        if(($session->has('filtro_nombreA'))and($session->get('filtro_nombreA')!='')){
            $query->setParameter("nombre", "%".$session->get('filtro_nombreA')."%");            
        }
        
        $autores=$query->getResult();

        $resultado = array();
        foreach ($autores as $autor) {
            $resultado[] = array(
                "id" => $autor->getId(),
                "nombre" => $autor->getNombre(),
                'borrado' => $autor->getBorrado(),
            );
        }

        $response = new JsonResponse();
        $response->setData($resultado);

        return $response;
    }
    
    public function filterEditorialAction(Request $request){
        //Recibo el dato
        $data = $request->request->get('data');
        $place = $request->request->get('place');
        $session = $this->getRequest()->getSession();
        $session->set('filtro_'.$place, $data);
        
        $dql="	select e from InicioBundle:Editorial as e where 1 = 1";
        
        $withParam=false;
        if(($session->has('filtro_nombreE'))and($session->get('filtro_nombreE')!='')):
            $dql .= ((!$withParam)? " and " : "")."e.nombre LIKE :nombre ";
        endif;
        
        if(substr($dql, -4,4)==" and ")
        	$dql = substr($dql, 0, strlen($dql)-5);
      
        $dql.=" ORDER BY e.id ASC";
        
        $em=$this->getDoctrine()->getEntityManager();
        $query=$em->createQuery($dql);
        
        if(($session->has('filtro_nombreE'))and($session->get('filtro_nombreE')!='')){
            $query->setParameter("nombre", "%".$session->get('filtro_nombreE')."%");            
        }
        
        $editoriales=$query->getResult();

        $resultado = array();
        foreach ($editoriales as $editorial) {
            $resultado[] = array(
                "id" => $editorial->getId(),
                "nombre" => $editorial->getNombre(),
                'borrado' => $editorial->getBorrado(),
            );
        }

        $response = new JsonResponse();
        $response->setData($resultado);

        return $response;
    }
    
    public function filterCategoriaAction(Request $request){
        //Recibo el dato
        $data = $request->request->get('data');
        $place = $request->request->get('place');
        $session = $this->getRequest()->getSession();
        $session->set('filtro_'.$place, $data);
        
        $dql="	select c from InicioBundle:Categoria as c where 1 = 1";
        
        $withParam=false;
        if(($session->has('filtro_nombreC'))and($session->get('filtro_nombreC')!='')):
        	$dql .= ((!$withParam)? " and " : "")."c.nombre LIKE :nombre ";
        endif;
        
        if(substr($dql, -4,4)==" and ")
        	$dql = substr($dql, 0, strlen($dql)-5);

        $dql.=" ORDER BY c.id ASC";
        
        $em=$this->getDoctrine()->getEntityManager();
        $query=$em->createQuery($dql);
        
        if(($session->has('filtro_nombreC'))and($session->get('filtro_nombreC')!='')){
            $query->setParameter("nombre", "%".$session->get('filtro_nombreC')."%");            
        }
        
        $categorias=$query->getResult();

        $resultado = array();
        foreach ($categorias as $categoria) {
            $resultado[] = array(
                "id" => $categoria->getId(),
                "nombre" => $categoria->getNombre(),
                'borrado' => $categoria->getBorrado(),
            );
        }

        $response = new JsonResponse();
        $response->setData($resultado);

        return $response;
    }
    
    public function filterMainAction(Request $request){
        //Recibo el dato
        $data = $request->request->get('data');
        //Recibo el filtro
        $place = $request->request->get('place');
        
        $session = $this->getRequest()->getSession();
        $session->set('filtro_'.$place, $data);
        
        $dql="	select l from InicioBundle:Libro as l where 1 = 1";

        $withParam=false;
       
        if((($session->has('filtro_titulo')))and($session->get('filtro_titulo')!='')):
            $dql .= ((!$withParam)? " and " : "")."l.titulo LIKE :titulo";
        endif;
       	
        if(($session->has('filtro_descripcion'))and($session->get('filtro_descripcion')!='')):
        	$dql .= ((!$withParam)? " and " : "")." l.descripcion LIKE :descripcion";
        endif;
        
        if(($session->has('filtro_paginas'))and($session->get('filtro_paginas')!='')):
            $dql .= ((!$withParam)? " and " : "")."l.paginas LIKE :paginas";
        endif;

        if(($session->has('filtro_idioma'))and($session->get('filtro_idioma')!='')):
            $dql .= ((!$withParam)? " and " : "")."l.idioma LIKE :idioma";
        endif;
            
        if((($session->has('filtro_precio_min'))and($session->get('filtro_precio_min')!=''))):
            $dql .= ((!$withParam)? " and " : "")."l.precio >= :precioMin";
        endif;
        
        if((($session->has('filtro_precio_max'))and($session->get('filtro_precio_max')!=''))):
            $dql .= ((!$withParam)? " and " : "")."l.precio <= :precioMax";
        endif;
        
        if(($session->has('filtro_editorial'))and($session->get('filtro_editorial')!='')):
            $dql .= ((!$withParam)? " and " : "")."l.editorial = ( select e.id from InicioBundle:Editorial as e where e.nombre LIKE :editorial ) ";
        endif;
        
        if(($session->has('filtro_fecha'))and($session->get('filtro_fecha')!='')):
            $dql .= ((!$withParam)? " and " : "")." l.fecha LIKE :fecha";
        endif;
        
        if(substr($dql, -4,4)==" and ")
        	$dql = substr($dql, 0, strlen($dql)-5);

        $dql.=" ORDER BY l.id ASC";

        $em=$this->getDoctrine()->getEntityManager();
        $query=$em->createQuery($dql);
        
        if((($session->has('filtro_titulo')))and($session->get('filtro_titulo')!=''))
            $query->setParameter("titulo", "%".$session->get('filtro_titulo')."%");
        if(($session->has('filtro_descripcion'))and($session->get('filtro_descripcion')!=''))
            $query->setParameter("descripcion", "%".$session->get('filtro_descripcion')."%");
        if(($session->has('filtro_paginas'))and($session->get('filtro_paginas')!='')){
            $query->setParameter("paginas", "%".$session->get('filtro_paginas')."%");            
        }
        if(($session->has('filtro_idioma'))and($session->get('filtro_idioma')!='')){
            $query->setParameter("idioma", "%".$session->get('filtro_idioma')."%");
        }
        
        if(($session->has('filtro_precio_min'))and($session->get('filtro_precio_min')!='')){          
            $query->setParameter("precioMin", $session->get('filtro_precio_min'));
        }
        
        if(($session->has('filtro_precio_max'))and($session->get('filtro_precio_max')!='')){          
            $query->setParameter("precioMax", $session->get('filtro_precio_max'));
        }

        if(($session->has('filtro_editorial'))and($session->get('filtro_editorial')!=''))
        	$query->setParameter("editorial", $session->get('filtro_editorial'));
        if(($session->has('filtro_fecha'))and($session->get('filtro_fecha')!=''))
        	$query->setParameter("fecha", "%".$session->get('filtro_fecha')."%");
        
        $libros=$query->getResult();
        
        if(($session->has('filtro_autor'))and($session->get('filtro_autor')!='')){          
            $search=$session->get('filtro_autor');
            $aux=array();
            foreach ($libros as $libro) {
               $id=$libro->getId();
               $autores=$libro->getAutor();
               foreach ($autores as $autor) {
                   $nombre=$autor->getNombre();
                   $resultado = strpos($nombre, $search);
                   if ($resultado !== FALSE){
                        $aux[$id]=$libro;
                   }
               }
            }
            $libros=$aux;
        }
        
        if(($session->has('filtro_editorial'))and($session->get('filtro_editorial')!='')){          
            $search=$session->get('filtro_editorial');
            $aux=array();
            foreach ($libros as $libro) {
               $id=$libro->getId();
               $editoriales=$libro->getEditorial();
               foreach ($editoriales as $editorial) {
                   $nombre=$editorial->getNombre();
                   $resultado = strpos($nombre, $search);
                   if ($resultado !== FALSE){
                        $aux[$id]=$libro;
                   }
               }
            }
            $libros=$aux;
        }

        $resultado = array();
        foreach ($libros as $libro) {
            $resultado[] = array(
                "id" => $libro->getId(),
                "isbn" => $libro->getIsbn(),
                "titulo" => $libro->getTitulo(),
                "descripcion" => substr(strip_tags($libro->getDescripcion()), 0, 50),
                "pagina" => $libro->getPaginas(),
                "imagen" => $libro->getImagen(),
                "contenidoimagen" => $libro->getContenidoimagen(),
                "idioma" => $libro->getIdioma(),
                "editorial" => $libro->getEditorial()->getNombre(),
                "precio" => $libro->getPrecio(),
                "fecha" => $libro->getFecha()->format('d-m-Y'),
                'borrado' => $libro->getBorrado(),
            );
        }

        $response = new JsonResponse();
        $response->setData($resultado);

        return $response;
    }
}