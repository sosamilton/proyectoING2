<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Autor;
use CB\InicioBundle\Form\AutorType;

/**
 * Autor controller.
 *
 * @Route("/admin/autor")
 */
class AutorController extends Controller
{

    /**
     * Lists all Autor entities.
     *
     * @Route("/", name="autor")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('InicioBundle:Autor')->findAll();
        return array(
            'entities' => $entities,
            'ruta'=> "autor"
        );
    }
    /**
     * Ordenar por nombre.
     *
     * @Route("/ordenar/{order}", name="ordenar_autor")
     * @Method("GET")
     * @Template()
     */
    public function findAllOrderedByNombreAction($order)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('InicioBundle:Autor')->findBy(array(), 
                array('nombre' => $order
        ));
        
        return $this->render('InicioBundle:Autor:index.html.twig', array('entities' => $entities, 'ruta'=> "autor"));
    }
    /**
     * Creates a new Autor entity.
     *
     * @Route("/", name="autor_create")
     * @Method("POST")
     * @Template("InicioBundle:Autor:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Autor();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $error=false;
        $nombre=$entity->getNombre();
        $em = $this->getDoctrine()->getManager();
        $existe = $em->getRepository('InicioBundle:Autor')->findOneByNombre($nombre);
        if ( (isset($existe)) && ($existe->getBorrado()) ){
            $existe->setBorrado(false);
            $em->persist($existe);
            $em->flush();
            return $this->redirect($this->generateUrl('autor', array('title'=>"listado de autores")));
        } else{
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('autor_show', array('id' => $entity->getId())));
            } else{
                $error=true;
            }
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'error' => $error,
            'ruta'=> "autor"
        );
    }

    /**
    * Creates a form to create a Autor entity.
    *
    * @param Autor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Autor $entity)
    {
        $form = $this->createForm(new AutorType(), $entity, array(
            'action' => $this->generateUrl('autor_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Autor entity.
     *
     * @Route("/crear", name="autor_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Autor();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'error' => false,
            'ruta'=> "autor"
        );
    }

    /**
     * Finds and displays a Autor entity.
     *
     * @Route("/{id}", name="autor_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Autor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Autor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'ruta'=> "autor"
        );
    }

    /**
     * Displays a form to edit an existing Autor entity.
     *
     * @Route("/{id}/editar", name="autor_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Autor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Autor entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'error'=> false,
            'ruta'=> "autor"
        );
    }

    /**
    * Creates a form to edit a Autor entity.
    *
    * @param Autor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Autor $entity)
    {
        $form = $this->createForm(new AutorType(), $entity, array(
            'action' => $this->generateUrl('autor_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Autor entity.
     *
     * @Route("/{id}", name="autor_update")
     * @Method("PUT")
     * @Template("InicioBundle:Autor:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Autor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Autor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        $error=false;
        if ($editForm->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('autor'));
        }else{
            $error=true;
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'error' => $error,
            'ruta'=> "autor"
        );
    }
    /**
     * Deletes a Autor entity.
     *
     * @Route("/{id}", name="autor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Autor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Autor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('autor'));
    }

    /**
     * Creates a form to delete a Autor entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('autor_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('InicioBundle:Autor')->find($id);
        $entity->setBorrado(!$entity->getBorrado());
        $em->flush();
        return $this->redirect($this->generateUrl('autor'));
    }
}
