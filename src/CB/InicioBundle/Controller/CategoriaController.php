<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Categoria;
use CB\InicioBundle\Form\CategoriaType;

/**
 * Categoria controller.
 *
 * @Route("/admin/categoria")
 */
class CategoriaController extends Controller
{

    /**
     * Lists all Categoria entities.
     *
     * @Route("/", name="categoria")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Categoria')->findAll();

        return array(
            'entities' => $entities,
            'ruta'=> "categoria"
        );
    }
    
    /**
     * Ordenar por nombre.
     *
     * @Route("/ordenar/{order}", name="ordenar_categoria")
     * @Method("GET")
     * @Template()
     */
    public function findAllOrderedByNombreAction($order)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('InicioBundle:Categoria')->findBy(array(), 
                array('nombre' => $order
        ));
        
        return $this->render('InicioBundle:Categoria:index.html.twig', array('entities' => $entities));
    }
    /**
     * Creates a new Categoria entity.
     *
     * @Route("/", name="categoria_create")
     * @Method("POST")
     * @Template("InicioBundle:Categoria:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Categoria();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $error=false;
        
        $nombre=$entity->getNombre();
        $em = $this->getDoctrine()->getManager();
        $existe = $em->getRepository('InicioBundle:Categoria')->findOneByNombre($nombre);
        if ( (isset($existe)) && ($existe->getBorrado()) ){
            $existe->setBorrado(false);
            $em->persist($existe);
            $em->flush();
            return $this->redirect($this->generateUrl('categoria', array('title'=>"listado de categorías")));
        } else
            
        {
              
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('categoria_show', array('id' => $entity->getId())));
        }else{
            $error=true;
        }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'error' => $error,
        );
    }

    /**
    * Creates a form to create a Categoria entity.
    *
    * @param Categoria $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Categoria $entity)
    {
        $form = $this->createForm(new CategoriaType(), $entity, array(
            'action' => $this->generateUrl('categoria_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Categoria entity.
     *
     * @Route("/crear", name="categoria_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Categoria();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'error' => false,
        );
    }

    /**
     * Finds and displays a Categoria entity.
     *
     * @Route("/{id}", name="categoria_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Categoria entity.
     *
     * @Route("/{id}/editar", name="categoria_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'error'=> false,
        );
    }

    /**
    * Creates a form to edit a Categoria entity.
    *
    * @param Categoria $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Categoria $entity)
    {
        $form = $this->createForm(new CategoriaType(), $entity, array(
            'action' => $this->generateUrl('categoria_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Categoria entity.
     *
     * @Route("/{id}", name="categoria_update")
     * @Method("PUT")
     * @Template("InicioBundle:Categoria:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        $error=false;
        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('categoria'));
        }else{
            $error=true;
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'error' => $error,
        );
    }
    /**
     * Deletes a Categoria entity.
     *
     * @Route("/{id}", name="categoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Categoria')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Categoria entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('categoria'));
    }

    /**
     * Creates a form to delete a Categoria entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categoria_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('InicioBundle:Categoria')->find($id);
        $borrado= $entity->getBorrado();
        $entity->setBorrado(!$borrado);
        $em->flush();
        return $this->redirect($this->generateUrl('categoria'));
    }
}
