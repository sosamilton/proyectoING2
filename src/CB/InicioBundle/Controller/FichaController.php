<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\MaterialidadSelecionada;
use CB\InicioBundle\Entity\PatologiasSeleccionadas;
use CB\InicioBundle\Entity\Ficha;
use CB\InicioBundle\Form\FichaType;
use CB\InicioBundle\Entity\TipoFicha;
use CB\InicioBundle\Entity\Identificacion;
use CB\InicioBundle\Entity\Ubicacion;
use CB\InicioBundle\Entity\Ubicacion2d;
use CB\InicioBundle\Entity\Ubicacion3d;
use CB\InicioBundle\Entity\Dimension;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;

/**
 * Ficha controller.
 *
 * @Route("/ficha")
 */
class FichaController extends Controller
{

    /**
     * Lists all Ficha entities.
     *
     * @Route("/", name="ficha")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Ficha')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Ficha entity.
     *
     * @Route("/", name="ficha_create")
     * @Method("POST")
     * @Template("InicioBundle:Ficha:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Ficha();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ficha_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Ficha entity.
    *
    * @param Ficha $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Ficha $entity)
    {
        $form = $this->createForm(new FichaType(), $entity, array(
            'action' => $this->generateUrl('ficha_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Ficha entity.
     *
     * @Route("/new", name="ficha_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Ficha();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Ficha entity.
     *
     * @Route("/{id}", name="ficha_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Ficha')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ficha entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Ficha entity.
     *
     * @Route("/{id}/edit", name="ficha_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Ficha')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ficha entity.');
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
    * Creates a form to edit a Ficha entity.
    *
    * @param Ficha $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Ficha $entity)
    {
        $form = $this->createForm(new FichaType(), $entity, array(
            'action' => $this->generateUrl('ficha_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Ficha entity.
     *
     * @Route("/{id}", name="ficha_update")
     * @Method("PUT")
     * @Template("InicioBundle:Ficha:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Ficha')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ficha entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ficha_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Ficha entity.
     *
     * @Route("/{id}", name="ficha_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Ficha')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ficha entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ficha'));
    }

    /**
     * Creates a form to delete a Ficha entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ficha_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    public function generate2dAction($tipoFichaId, Request $request){
        $data = array();
        $form = $this->createFormBuilder($data)
                
            ->add('identificacion_serie', 'integer')
            ->add('identificacion_ubicacion_espacio', 'text')
                
            ->add('ubicacion_piso', 'text')
            ->add('ubicacion_local', 'entity', array('class' => 'CB\InicioBundle\Entity\Local'))
            ->add('ubicacion_objeto', 'entity', array(
                'class' => 'InicioBundle:Objeto',
                'query_builder' => function(EntityRepository $er) use ($tipoFichaId) {
                    return $er->createQueryBuilder('o')
                        ->where('o.tipoFichaId = :tipo')
                        ->setParameter('tipo', $tipoFichaId);
                    }
                )
            )
            ->add('ubicacion_inferior', 'text')
                
            ->add('descripcion', 'textarea')
                
            ->add('dimensiones_alto', 'text')
            ->add('dimensiones_ancho', 'text')
                
            ->add('estado_general', 'entity', array('class' => 'CB\InicioBundle\Entity\EstadoGeneral'))
            
            ->add('observaciones', 'textarea');
            
            $mc = $this->getDoctrine()
                ->getRepository('InicioBundle:MaterialidadConjunto')
                ->findByTipoFichaId($tipoFichaId);            
            foreach($mc as $materialidadConjunto):
                $form->add('Materialidad'.$materialidadConjunto->getId(), 'entity', array(
                    'required'      => false,
                    'class' => 'InicioBundle:Materialidad',
                    'query_builder' => function(EntityRepository $er) use ($materialidadConjunto){
                        return $er->createQueryBuilder('m')
                            ->where('m.conjuntoId = :conj')
                            ->setParameter('conj', $materialidadConjunto->getId());
                    },                
                    'multiple'      => true,
                    'expanded'      => true
                ));
            /*    
            foreach($materialidades as $materialidad):
                    ->add('dimensiones_pesoaproximado', 'text');
                endforeach;*/
            endforeach;
            
            $grupos = $this->getDoctrine()
                ->getRepository('InicioBundle:PatologiaGrupo')
                ->findByTipoFichaId($tipoFichaId);            
            
            foreach ($grupos as $grupo):
                $conjuntos = $this->getDoctrine()
                    ->getRepository('InicioBundle:PatologiaConjunto')
                    ->findByGrupoId($grupo->getId());            
                foreach($conjuntos as $conjunto):
                    $form->add('Patologia'.$conjunto->getId(), 'entity', array(
                        'required'      => false,
                        'class' => 'InicioBundle:Patologia',
                        'query_builder' => function(EntityRepository $er) use ($conjunto){
                            return $er->createQueryBuilder('p')
                                ->where('p.conjuntoId = :conj')
                                ->setParameter('conj', $conjunto->getId());
                        },                
                        'multiple'      => true,
                        'expanded'      => true
                    ));
                endforeach;
            endforeach;
            
            for($i=1;$i<19;$i++){
                $form->add('fragmentos'.$i, 'integer', array('required'=>false));
            }
                $form->add('Enviar', 'submit');
             $form= $form->getForm();
            
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            //Guardar la ficha
            $ficha = new Ficha();
            $repo = $this->getDoctrine()->getRepository('InicioBundle:TipoFicha');
            $ficha->setTipoFichaId($repo->find($tipoFichaId));
            $repo = $this->getDoctrine()->getRepository('InicioBundle:Objeto');
            $ficha->setObjetoId($repo->find($data["ubicacion_objeto"]));
            
            $usr= $this->get('security.context')->getToken()->getUser();
            $ficha->setUsuarioCarga($usr->getUsername());
            $ficha->setFechaCarga(new \DateTime());
            $ficha->setDescripcion($data["descripcion"]);
            $ficha->setSerie($data["identificacion_serie"]);
            $em->persist($ficha);
            $em->flush();
            //Guardar la identificacion
            /*
            $identificacion = new Identificacion();
            $identificacion->setFichaId($ficha->getId());
            $identificacion->setEstracto($data["identificacion_estracto"]);
            $identificacion->setLado($data["identificacion_lado"]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($identificacion);
            $em->flush();
            */
            //Guardar la ubicacion
            $ubicacion = new Ubicacion();
            $ubicacion->setFichaId($ficha);
            $em = $this->getDoctrine()->getManager();
            $em->persist($ubicacion);
            $em->flush();
            //Guardar la ubicacion 2d
            $ubicacion2d = new Ubicacion2d();
            $ubicacion2d->setPiso($data["ubicacion_piso"]);
            $repo = $this->getDoctrine()->getRepository('InicioBundle:Local');
            $ubicacion2d->setLocalId($repo->find($data["ubicacion_local"]));
            $ubicacion2d->setUbicacionId($ubicacion);
            $em = $this->getDoctrine()->getManager();
            $em->persist($ubicacion2d);
            $em->flush();
            //Guardar las dimensiones
            $dimension = new Dimension();
            $dimension->setFichaId($ficha);
            $dimension->setAlto($data["dimensiones_alto"]);
            $dimension->setAncho($data["dimensiones_ancho"]);
            //$dimension->setProfundidad($data["dimensiones_profundidad"]);
            //$dimension->setVolumen($data["dimensiones_volumen"]);
            //$dimension->setPeso($data["dimensiones_pesoaproximado"]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($dimension);
            $em->flush();
            //Guardo las materialidades
            $mc = $this->getDoctrine()
                ->getRepository('InicioBundle:MaterialidadConjunto')
                ->findByTipoFichaId($tipoFichaId); 
            foreach($mc as $materialidadConjunto):
                $materialidades =  $this->getDoctrine()
                ->getRepository('InicioBundle:Materialidad')
                ->findByConjuntoId($materialidadConjunto->getId());
                $id = $materialidadConjunto->getId(); 
                if(isset($data["Materialidad".$materialidadConjunto->getId()])){
                    foreach($data["Materialidad".$materialidadConjunto->getId()] as $materialidad):
                        $materialidadSeleccionada = new MaterialidadSeleccionada();
                        $materialidadSeleccionada->setMaterialidadId($materialidad);
                        $materialidadSeleccionada->setFichaId($ficha);
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($materialidadSeleccionada);
                        $em->flush();
                    endforeach;
                }
            endforeach;
            //guardo las patologias
            $grupos = $this->getDoctrine()
                ->getRepository('InicioBundle:PatologiaGrupo')
                ->findByTipoFichaId($tipoFichaId);            
            foreach ($grupos as $grupo):
                $conjuntos = $this->getDoctrine()
                    ->getRepository('InicioBundle:PatologiaConjunto')
                    ->findByGrupoId($grupo->getId());            
                foreach($conjuntos as $conjunto):
                    if(isset($data["Patologia".$conjunto->getId()])){
                        foreach($data["Patologia".$conjunto->getId()] as $patologia):
                            $patologiaSeleccionada = new PatologiasSeleccionadas();
                            $patologiaSeleccionada->setPatologiaId($patologia);
                            $patologiaSeleccionada->setFichaId($ficha);
                            $em = $this->getDoctrine()->getManager();
                            $em->persist($patologiaSeleccionada);
                            $em->flush();
                        endforeach;
                    }
                endforeach;
            endforeach;
            
            for($i=1;$i<19;$i++){
                if($data["fragmentos".$i]!=''):
                    $fragmentoFicha = new FragmentosFicha();
                    $fragmentoFicha->setFichaFragmentoId($data["fragmentos".$i]);
                    $fragmentoFicha->setFichaId($ficha);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($fragmentoFicha);
                    $em->flush();
                endif;
            }

            return $this->render('InicioBundle:Ficha:2d.html.twig', array(
                "form" => $form->createView(),
            ));
        }else{
            return $this->render('InicioBundle:Ficha:2d.html.twig', array(
                "form" => $form->createView(),
            ));
        }
    }
    
    public function generate3dAction($tipoFichaId, Request $request){
        $data = array();
        $form = $this->createFormBuilder($data)
                
            ->add('identificacion_serie', 'integer')
            ->add('identificacion_estrato', 'text')
            ->add('identificacion_lado', 'text')
                
            ->add('ubicacion_izquierda', 'text')
            ->add('ubicacion_derecha', 'text')
            ->add('ubicacion_superior', 'text')
            ->add('ubicacion_inferior', 'text')
                
            ->add('descripcion', 'textarea')
                
            ->add('dimensiones_alto', 'text')
            ->add('dimensiones_ancho', 'text')
            ->add('dimensiones_profundidad', 'text')
            ->add('dimensiones_volumen', 'text')
            ->add('dimensiones_pesoaproximado', 'text');
            
            $mc = $this->getDoctrine()
                ->getRepository('InicioBundle:MaterialidadConjunto')
                ->findByTipoFichaId($tipoFichaId); 
            foreach($mc as $materialidadConjunto):
                $materialidades =  $this->getDoctrine()
                ->getRepository('InicioBundle:Materialidad')
                ->findByConjuntoId($materialidadConjunto->getId());
                $id = $materialidadConjunto->getId();    
                $form->add("Materialidad".$materialidadConjunto->getId(), 'entity', array(
                    'required'      => false,
                    'class' => 'InicioBundle:Materialidad',                    
                    'query_builder' => function(EntityRepository $er) use ($id){
                        return $er->createQueryBuilder('m')
                            ->where('m.conjuntoId=:conjunto')
                            ->setParameter('conjunto', $id);
                    },                
                    'multiple'      => true,
                    'expanded'      => true
                ));
            endforeach;
            
            $grupos = $this->getDoctrine()
                ->getRepository('InicioBundle:PatologiaGrupo')
                ->findByTipoFichaId($tipoFichaId);            
            foreach ($grupos as $grupo):
                $conjuntos = $this->getDoctrine()
                    ->getRepository('InicioBundle:PatologiaConjunto')
                    ->findByGrupoId($grupo->getId());            
                foreach($conjuntos as $conjunto):
                    $form->add("Patologia".$conjunto->getId(), 'entity', array(
                        'required'      => false,
                        'class' => 'InicioBundle:Patologia',
                        'query_builder' => function(EntityRepository $er) use ($conjunto){
                            return $er->createQueryBuilder('p')
                                ->where('p.conjuntoId = :conj')
                                ->setParameter('conj', $conjunto->getId());
                        },                
                        'multiple'      => true,
                        'expanded'      => true
                    ));
                endforeach;
            endforeach;
            
            for($i=1;$i<11;$i++){
                $form->add('fragmentos'.$i, 'integer', array('required'=>false));
            }
            $form->add('Enviar', 'submit');
            $form= $form->getForm();
            
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $data = $form->getData();

            //Guardar la ficha
            $ficha = new Ficha();
            $repo = $this->getDoctrine()->getRepository('InicioBundle:TipoFicha');
            $ficha->setTipoFichaId($repo->find($tipoFichaId));
            $usr= $this->get('security.context')->getToken()->getUser();
            $ficha->setUsuarioCarga($usr->getUsername());
            $ficha->setFechaCarga(new \DateTime());
            $ficha->setDescripcion($data["descripcion"]);
            $ficha->setSerie($data["identificacion_serie"]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($ficha);
            $em->flush();

            //Guardar la identificacion
            $identificacion = new Identificacion();
            $identificacion->setFichaId($ficha);
            $identificacion->setEstracto($data["identificacion_estrato"]);
            $identificacion->setLado($data["identificacion_lado"]);
            $em->persist($identificacion);
            $em->flush();
            //Guardar la ubicacion
            $ubicacion = new Ubicacion();
            $ubicacion->setFichaId($ficha);
            $em->persist($ubicacion);
            $em->flush();
            //Guardar la ubicacion 3d
            $ubicacion3d = new Ubicacion3d();
            $ubicacion3d->setArriba($data["ubicacion_superior"]);
            $ubicacion3d->setAbajo($data["ubicacion_inferior"]);
            $ubicacion3d->setDerecha($data["ubicacion_derecha"]);
            $ubicacion3d->setIzquierda($data["ubicacion_izquierda"]);
            $ubicacion3d->setUbicacionId($ubicacion);
            $em->persist($ubicacion3d);
            $em->flush();
            //Guardar las dimensiones
            $dimension = new Dimension();
            $dimension->setFichaId($ficha);
            $dimension->setAlto($data["dimensiones_alto"]);
            $dimension->setAncho($data["dimensiones_ancho"]);
            $dimension->setProfundidad($data["dimensiones_profundidad"]);
            $dimension->setVolumen($data["dimensiones_volumen"]);
            $dimension->setPeso($data["dimensiones_pesoaproximado"]);
            $em->persist($dimension);
            $em->flush();
            //Guardo las materialidades
            $mc = $this->getDoctrine()
                ->getRepository('InicioBundle:MaterialidadConjunto')
                ->findByTipoFichaId($tipoFichaId); 
            foreach($mc as $materialidadConjunto):
                $materialidades =  $this->getDoctrine()
                ->getRepository('InicioBundle:Materialidad')
                ->findByConjuntoId($materialidadConjunto->getId());
                $id = $materialidadConjunto->getId();    
                foreach($data["Materialidad".$materialidadConjunto->getId()] as $materialidad):
                    $materialidadSeleccionada = new MaterialidadSelecionada();
                    $repo = $this->getDoctrine()->getRepository('InicioBundle:Materialidad');
                    $materialidadSeleccionada->setMaterialidadId($repo->find($materialidad));
                    $materialidadSeleccionada->setFichaId($ficha);
                    $em->persist($materialidadSeleccionada);
                    $em->flush();
                endforeach;
            endforeach;
            //guardo las patologias
            $grupos = $this->getDoctrine()
                ->getRepository('InicioBundle:PatologiaGrupo')
                ->findByTipoFichaId($tipoFichaId);            
            foreach ($grupos as $grupo):
                $conjuntos = $this->getDoctrine()
                    ->getRepository('InicioBundle:PatologiaConjunto')
                    ->findByGrupoId($grupo->getId());            
                foreach($conjuntos as $conjunto):
                    foreach($data["Patologia".$conjunto->getId()] as $patologia):
                        $patologiaSeleccionada = new PatologiasSeleccionadas();
                        $repo = $this->getDoctrine()->getRepository('InicioBundle:Patologia');
                        $patologiaSeleccionada->setPatologiaId($repo->find($patologia));
                        $patologiaSeleccionada->setFichaId($ficha);
                        $em->persist($patologiaSeleccionada);
                        $em->flush();
                    endforeach;
                endforeach;
            endforeach;
            
            for($i=1;$i<19;$i++){
                if($data["fragmentos".$i]!=''):
                    $fragmentoFicha = new FragmentosFicha();
                    $fragmentoFicha->setFichaFragmentoId($data["fragmentos".$i]);
                    $fragmentoFicha->setFichaId($ficha);
                    $em->persist($fragmentoFicha);
                    $em->flush();
                endif;
            }

            return $this->render('InicioBundle:Ficha:3d.html.twig', array(
                "form" => $form->createView(),
            ));
        }else{
            return $this->render('InicioBundle:Ficha:3d.html.twig', array(
                "form" => $form->createView(),
            ));
        }
    }
    
    public function generateFichaAction(Request $request){
        
        $data = array();
        $form = $this->createFormBuilder($data)
            ->add('tipoFichaId', 'entity', array('class' => 'CB\InicioBundle\Entity\TipoFicha'))
            ->add('enviar','submit')
            ->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $data = $form->getData();
            $tipoFichaId = $data["tipoFichaId"]->getId();
            $tipoFicha = $this->getDoctrine()
                ->getRepository('InicioBundle:TipoFicha')
                ->find($tipoFichaId);
            if($tipoFicha->getEs3d()){
                //es 3d
                return $this->redirect($this->generateUrl('generate_3d', array("tipoFichaId"=>$tipoFichaId)));
            }else{ 
                //es 2d
                return $this->redirect($this->generateUrl('generate_2d', array("tipoFichaId"=>$tipoFichaId)));
            }
        }else{
            return $this->render('InicioBundle:Ficha:primer-paso.html.twig', 
                    array("form"=>$form->createView()));
        }
            
    }
}

